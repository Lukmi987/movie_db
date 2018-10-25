<?php
require __DIR__ . '/requireFiles.php';

$accessToken = new Symfony\Component\HttpFoundation\Cookie('access_token', 'Expired', time()-3600,'/',
getenv('COOKIE_DOMAIN')); //before we redirect we should set a new cookie  with the same name that expires in the past with an invalid jwt
redirect('login.php',['cookies' => [$accessToken]]);
