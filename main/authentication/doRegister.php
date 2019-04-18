<?php
require_once __DIR__ . '/requireFiles.php';
include_once "../queryToDatabase.php";
$query = new queryToDatabase();

$password = request()->get('password');
$confirmPassword = request()->get('confirm_password');
$email = request()->get('email');

if($password != $confirmPassword){
  $session->getFlashBag()->add('error','Passwords do not match!!!');
   redirect('registrationForm.php');
}

$user = $query->findUserByEmail($email);

// if we find some email it means that it already exists, so we redirect back to registration page
if(!empty($user)){
  $session->getFlashBag()->add('error','Email already exits!!');
  redirect('registrationForm.php');
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
$findUser = $query->createUser($email,$hashed);

$expTime = time() + 3600;

$jwt = \Firebase\JWT\JWT::encode([
    'iss' => request()->getBaseUrl(),
    'sub' => "{$user['id']}",
    'exp' => $expTime,
    'iat' => time(),
    'nbf' => time(),
    'is_admin' => $user['role_id'] == 1
], getenv("SECRET_KEY"),'HS256');

$accessToken = new Symfony\Component\HttpFoundation\Cookie('access_token', $jwt, $expTime, '/',
getenv('COOKIE_DOMAIN'));

redirect('../showMovies.php',['cookies' => [$accessToken]]);


 ?>
