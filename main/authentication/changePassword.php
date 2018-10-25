<?php
require __DIR__ . '/requireFiles.php';
requireAuth();

$currPassword = request()->get('current_password');
$newPassword = request()->get('password');
$confirmPassword = request()->get('confirm_password');

if($newPassword != $confirmPassword) {
  $session->getFlashBag()->add('error','New passwords do not match, please try again.');
  redirect('account.php');
}

$user = findUserByIdFromJWT();

if(empty($user)){
$session->getFlashBag()->add('error','Some err Happened, Try again. If it continues please log out and log back in.');
  redirect('account.php');
}

if(!password_verify($currPassword, $user['password'])){
  $session->getFlashBag()->add('error','Current password is incorrect, pls try again');
  redirect('account.php');
}


$updated = updateUser(password_hash($newPassword, PASSWORD_DEFAULT), $user['id']);


if(!updated){
  $session->getFlashBag()->add('error','Could not updated password, pls try again');
  redirect('account.php');
}

$session->getFlashBag()->add('success','Password Updated');
redirect('account.php');
