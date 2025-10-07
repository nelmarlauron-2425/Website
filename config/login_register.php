<?php
/* config/login_register.php */
declare(strict_types=1);
session_start();
require_once __DIR__.'/dbconfig.php';

function redirect(string $to){ header('Location: '.$to); exit; }

/** check if a column exists in users table */
function columnExists(mysqli $db, string $col): bool {
  $sql = "SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'users' AND COLUMN_NAME = ?";
  $stmt = $db->prepare($sql);
  $dbName = DB_NAME;
  $stmt->bind_param('ss', $dbName, $col);
  $stmt->execute();
  $stmt->store_result();
  $exists = $stmt->num_rows > 0;
  $stmt->close();
  return $exists;
}

$hasPasswordHash = columnExists($mysqli, 'password_hash'); // fallback to 'password' if false
$hasPassword     = columnExists($mysqli, 'password');

$action = $_POST['action'] ?? '';

if ($action === 'signup') {
  $first = trim($_POST['first_name'] ?? '');
  $last  = trim($_POST['last_name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $pass1 = $_POST['password'] ?? '';
  $pass2 = $_POST['confirm_password'] ?? '';
  $role  = ($_POST['role'] ?? 'buyer'); // default role

  if ($first===''||$last===''||$email===''||$pass1===''||$pass2===''){
    $_SESSION['signup_error']='All fields are required.'; redirect('../signup.php');
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $_SESSION['signup_error']='Invalid email address.'; redirect('../signup.php');
  }
  if ($pass1 !== $pass2){
    $_SESSION['signup_error']='Passwords do not match.'; redirect('../signup.php');
  }

  // dedupe email
  $stmt=$mysqli->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
  $stmt->bind_param('s',$email); $stmt->execute(); $stmt->store_result();
  if ($stmt->num_rows>0){ $stmt->close(); $_SESSION['signup_error']='Email already registered.'; redirect('../signup.php'); }
  $stmt->close();

  $hash = password_hash($pass1, PASSWORD_DEFAULT);

  if ($hasPasswordHash) {
    // schema: ... password_hash, role?
    if (!columnExists($mysqli, 'role')) { $role = null; }
    if ($role===null) {
      $stmt=$mysqli->prepare('INSERT INTO users (first_name,last_name,email,password_hash) VALUES (?,?,?,?)');
      $stmt->bind_param('ssss',$first,$last,$email,$hash);
    } else {
      $stmt=$mysqli->prepare('INSERT INTO users (first_name,last_name,email,password_hash,role) VALUES (?,?,?,?,?)');
      $stmt->bind_param('sssss',$first,$last,$email,$hash,$role);
    }
  } else {
    // schema: ... password (hashed), role?
    if (!columnExists($mysqli, 'role')) { $role = null; }
    if ($role===null) {
      $stmt=$mysqli->prepare('INSERT INTO users (first_name,last_name,email,password) VALUES (?,?,?,?)');
      $stmt->bind_param('ssss',$first,$last,$email,$hash);
    } else {
      $stmt=$mysqli->prepare('INSERT INTO users (first_name,last_name,email,password,role) VALUES (?,?,?,?,?)');
      $stmt->bind_param('sssss',$first,$last,$email,$hash,$role);
    }
  }

  if (!$stmt->execute()){
    $_SESSION['signup_error']='Error creating account. Please try again.'; $stmt->close(); redirect('../signup.php');
  }
  $stmt->close();
  $_SESSION['signup_success']='Account created! You can log in now.'; redirect('../signup.php');
}

if ($action === 'login') {
  $email = trim($_POST['email'] ?? '');
  $pass  = $_POST['password'] ?? '';
  if ($email===''||$pass===''){ $_SESSION['login_error']='Email and password are required.'; redirect('../login.php'); }

  // Select both columns if they exist, then choose available one
  $selectCols = 'id, first_name, last_name' .
                ($hasPasswordHash ? ', password_hash' : '') .
                ($hasPassword     ? ', password'      : '') .
                (columnExists($mysqli,'role') ? ', role' : '');
  $sql = "SELECT $selectCols FROM users WHERE email = ? LIMIT 1";
  $stmt=$mysqli->prepare($sql);
  $stmt->bind_param('s',$email);
  $stmt->execute();
  $res=$stmt->get_result();
  $user=$res->fetch_assoc();
  $stmt->close();

  if (!$user) { $_SESSION['login_error']='Invalid email or password.'; redirect('../login.php'); }

  $stored = $user['password_hash'] ?? ($user['password'] ?? '');
  if (!$stored || !password_verify($pass, $stored)) {
    $_SESSION['login_error']='Invalid email or password.'; redirect('../login.php');
  }

  $_SESSION['user_id']   = (int)$user['id'];
  $_SESSION['user_name'] = $user['first_name'].' '.$user['last_name'];
  $_SESSION['user_role'] = $user['role'] ?? null;

  redirect('../explorer.php');
}

redirect('../index.php');
