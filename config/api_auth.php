<?php
/* config/api_auth.php */
declare(strict_types=1);
session_start();

require_once __DIR__.'/dbconfig.php';
require_once __DIR__.'/secrets.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type, Accept');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }

function json_out(array $d, int $c=200){ http_response_code($c); header('Content-Type: application/json'); echo json_encode($d, JSON_UNESCAPED_SLASHES); exit; }
function columnExists(mysqli $db, string $col): bool {
  $sql="SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA=? AND TABLE_NAME='users' AND COLUMN_NAME=?";
  $stmt=$db->prepare($sql); $dbName=DB_NAME; $stmt->bind_param('ss',$dbName,$col); $stmt->execute(); $stmt->store_result(); $ok=$stmt->num_rows>0; $stmt->close(); return $ok;
}

$hasHash = columnExists($mysqli,'password_hash');
$hasPwd  = columnExists($mysqli,'password');

$ctype = $_SERVER['CONTENT_TYPE'] ?? '';
$body  = (stripos((string)$ctype,'application/json')!==false)
  ? (json_decode(file_get_contents('php://input') ?: '[]', true) ?: [])
  : $_POST;

$action = $_GET['action'] ?? $body['action'] ?? '';

if ($action==='signup') {
  $first=trim($body['first_name']??''); $last=trim($body['last_name']??''); $email=trim($body['email']??''); $pass=(string)($body['password']??'');
  if ($first===''||$last===''||$email===''||strlen($pass)<8) json_out(['ok'=>false,'error'=>'Complete fields; password ≥ 8'], 422);
  if (!filter_var($email,FILTER_VALIDATE_EMAIL)) json_out(['ok'=>false,'error'=>'Invalid email'], 422);

  $stmt=$mysqli->prepare('SELECT id FROM users WHERE email=? LIMIT 1');
  $stmt->bind_param('s',$email); $stmt->execute(); $stmt->store_result();
  if ($stmt->num_rows>0){ $stmt->close(); json_out(['ok'=>false,'error'=>'Email already registered'], 409); }
  $stmt->close();

  $hash=password_hash($pass,PASSWORD_DEFAULT);
  if ($hasHash) $stmt=$mysqli->prepare('INSERT INTO users (first_name,last_name,email,password_hash) VALUES (?,?,?,?)');
  else          $stmt=$mysqli->prepare('INSERT INTO users (first_name,last_name,email,password) VALUES (?,?,?,?)');
  $stmt->bind_param('ssss',$first,$last,$email,$hash);
  if (!$stmt->execute()){ $e=$stmt->error; $stmt->close(); json_out(['ok'=>false,'error'=>'Insert failed','debug'=>APP_DEBUG?$e:null],500); }
  $uid=$stmt->insert_id; $stmt->close();
  json_out(['ok'=>true,'user_id'=>$uid,'message'=>'Account created']);
}

if ($action==='login') {
  $email=trim($body['email']??''); $pass=(string)($body['password']??'');
  if ($email===''||$pass==='') json_out(['ok'=>false,'error'=>'Email and password required'],400);
  $cols='id,first_name,last_name'.($hasHash?',password_hash':'').($hasPwd?',password':'');
  $stmt=$mysqli->prepare("SELECT $cols FROM users WHERE email=? LIMIT 1");
  $stmt->bind_param('s',$email); $stmt->execute(); $res=$stmt->get_result(); $u=$res->fetch_assoc(); $stmt->close();
  if (!$u){ json_out(['ok'=>false,'error'=>'Invalid email or password'],401); }
  $stored=$u['password_hash']??($u['password']??'');
  if (!$stored || !password_verify($pass,$stored)) json_out(['ok'=>false,'error'=>'Invalid email or password'],401);
  $_SESSION['user_id']=(int)$u['id']; $_SESSION['user_name']=$u['first_name'].' '.$u['last_name'];
  json_out(['ok'=>true,'user'=>['id'=>$u['id'],'name'=>$_SESSION['user_name']]]);
}

json_out(['ok'=>false,'error'=>'Unknown action. Use ?action=signup or ?action=login'],400);
