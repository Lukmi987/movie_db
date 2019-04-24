<?php
include_once  "/../queryToDatabase.php";
require __DIR__ . '/requireFiles.php';

 $query = new queryToDatabase();
$userId = request()->get('userId');
var_dump($userId);
$role = request()->get('role');
var_dump($role);

 switch(strtolower($role)){
   case 'promote':
    $query->promote($userId);
    $session->getFlashBag()->add('success', 'Promoted to Admin');
    break;
  case 'demote':
  $query->demote($userId);
  $session->getFlashBag()->add('success', 'Demoted from Admin!');
  break;
 }
 redirect('./admin.php');
