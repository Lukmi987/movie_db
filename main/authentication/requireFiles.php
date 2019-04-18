<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/helperFunctions.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load(); //this will tell the system where to find our dotenv file.

$session = new \Symfony\Component\HttpFoundation\Session\Session();
$session->start(); //this will create a new session object and start it.
//this is essentially the same thing as doing session_start
