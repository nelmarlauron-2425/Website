<?php
/* config/sendgrid_mailer.php */
declare(strict_types=1);
require_once __DIR__ . '/secrets.php';

/**
 * Send HTML email via SendGrid REST API.
 * 1) Try cURL (best)
 * 2) Fallback to file_get_contents stream context (if cURL not enabled)
 * Returns true on 202 Accepted.
 */
function sg_send_mail(string $toEmail, string $toName, string $subject, string $html): bool {
  $payload = [
    'personalizations' => [[
      'to'      => [['email' => $toEmail, 'name' => $toName]],
      'subject' => $subject
    ]],
    'from'    => ['email' => APP_FROM_EMAIL, 'name' => APP_FROM_NAME],
    'content' => [[ 'type' => 'text/html', 'value' => $html ]]
  ];
  $json = json_encode($payload);

  // --- Use cURL if available ---
  if (function_exists('curl_init')) {
    $ch = curl_init('https://api.sendgrid.com/v3/mail/send');
    curl_setopt_array($ch, [
      CURLOPT_HTTPHEADER     => [
        'Authorization: Bearer '.SENDGRID_API_KEY,
        'Content-Type: application/json'
      ],
      CURLOPT_POST           => true,
      CURLOPT_POSTFIELDS     => $json,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT        => 20,
    ]);
    $resp = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err  = curl_error($ch);
    curl_close($ch);

    if ($err && APP_DEBUG) error_log("[SendGrid cURL] $err");
    if ($code !== 202) {
      if (APP_DEBUG) error_log("[SendGrid cURL] HTTP $code resp: $resp");
      return false;
    }
    return true;
  }

  // --- Fallback without cURL ---
  $opts = [
    'http' => [
      'method'  => 'POST',
      'header'  => "Authorization: Bearer ".SENDGRID_API_KEY."\r\nContent-Type: application/json\r\n",
      'content' => $json,
      'timeout' => 20
    ]
  ];
  $ctx  = stream_context_create($opts);
  $fp   = @fopen('https://api.sendgrid.com/v3/mail/send', 'rb', false, $ctx);
  if (!$fp) {
    if (APP_DEBUG) error_log('[SendGrid] fopen failed. Enable php_curl or allow_url_fopen.');
    return false;
  }
  $meta = stream_get_meta_data($fp);
  $resp = stream_get_contents($fp);
  fclose($fp);

  // No direct way to get status code w/ fopen; assume 202 if no error & no HTML error returned
  if ($resp === false) {
    if (APP_DEBUG) error_log('[SendGrid] empty response (fallback).');
    return false;
  }
  // If SendGrid returns JSON w/ errors it won't be 202, but fallback can't read code easily—best effort:
  if (stripos($resp, '"errors"') !== false) {
    if (APP_DEBUG) error_log("[SendGrid] API error body: $resp");
    return false;
  }
  return true;
}
