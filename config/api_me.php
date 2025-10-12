<?php
declare(strict_types=1);
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');

if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode(['ok'=>false,'error'=>'Not logged in']); exit;
}
echo json_encode([
  'ok'=>true,
  'user'=>[
    'id'=>$_SESSION['user_id'],
    'name'=>$_SESSION['user_name'] ?? null,
    'role'=>$_SESSION['user_role'] ?? null
  ]
]);
