<?php
declare(strict_types=1);
require_once __DIR__ . '/secrets.php';

/**
 * Sends an HTML email using SendGrid REST API.
 *
 * @param string $toEmail Recipient email address
 * @param string $toName  Recipient name
 * @param string $subject Email subject
 * @param string $html    HTML content of the email
 * @return bool True if sent successfully, False otherwise
 */
function sg_send_mail(string $toEmail, string $toName, string $subject, string $html): bool
{
    $payload = [
        'personalizations' => [[
            'to' => [['email' => $toEmail, 'name' => $toName]],
            'subject' => $subject
        ]],
        'from' => [
            'email' => APP_FROM_EMAIL,
            'name'  => APP_FROM_NAME
        ],
        'content' => [[
            'type'  => 'text/html',
            'value' => $html
        ]]
    ];

    $jsonData = json_encode($payload);

    // --- Send using cURL ---
    if (function_exists('curl_init')) {
        $ch = curl_init('https://api.sendgrid.com/v3/mail/send');
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . SENDGRID_API_KEY,
                'Content-Type: application/json'
            ],
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $jsonData,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 20,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error    = curl_error($ch);
        curl_close($ch);

        if ($error && APP_DEBUG) {
            error_log("[SendGrid cURL error] $error");
        }

        if ($httpCode !== 202) {
            if (APP_DEBUG) {
                error_log("[SendGrid cURL] HTTP $httpCode: $response");
            }
            return false;
        }

        return true;
    }

    // --- Fallback if cURL disabled ---
    $opts = [
        'http' => [
            'method'  => 'POST',
            'header'  => "Authorization: Bearer " . SENDGRID_API_KEY . "\r\n" .
                         "Content-Type: application/json\r\n",
            'content' => $jsonData,
            'timeout' => 20,
        ]
    ];

    $context = stream_context_create($opts);
    $fp = @fopen('https://api.sendgrid.com/v3/mail/send', 'rb', false, $context);

    if (!$fp) {
        if (APP_DEBUG) {
            error_log("[SendGrid] fopen failed. Enable php_curl or allow_url_fopen.");
        }
        return false;
    }

    $response = stream_get_contents($fp);
    fclose($fp);

    if (stripos($response, '"errors"') !== false) {
        if (APP_DEBUG) {
            error_log("[SendGrid API Error] $response");
        }
        return false;
    }

    return true;
}
