<?php
require_once __DIR__ . '/requireFiles.php';
include_once "../queryToDatabase.php";
$query = new queryToDatabase();

$password = request()->get('password');
$confirmPassword = request()->get('confirm_password');
$email = request()->get('email');

if($password != $confirmPassword){
redirect('registrationForm.php');
}

$user = $query->findUserByEmail($email);

// if we find some email it means that it already exists, so we redirect back to registration page
if(!empty($user)){
  redirect('registrationForm.php');
  var_dump('if user not empty');
  exit();
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
$findUser = $query->createUser($email,$hashed);
redirect('login.php');


 ?>
