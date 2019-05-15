<?php
require_once __DIR__ . '/requireFiles.php';
include_once "../queryToDatabase.php";
$query = new queryToDatabase();

//get the user by the email address which was supplied
$user = $query->findUserByEmail(request()->get('email'));

if(empty($user)){ //from the session object in requireFiles.ph we get the FlashBag and can add to it
                  // first item is the key we want to use and the second is the message
  $session->getFlashBag()->add('error', 'UserName was not found'); //internally, it'll create an error array with all the messages that belong to that key
  redirect('login.php');
exit();
}

//since the pwd is hashed we can not compare what was provided to us with what is in the database
// but we can use password_verify() to do so.
if (!password_verify(request()->get('password'),$user['password'])) {
  $session->getFlashBag()->add('error', 'Email is ok but password not correct');
  redirect('login.php');
  exit();
}

$expTime = time() + 3600; //for one hour

//we will use the static method in code that lives in the class
// and encode() takes 3 properties, 1. the data we want in our claim,2 the signing key, and the encryption algorithm
 $jwt = \Firebase\JWT\JWT::encode([
   'iss' => request()->getBaseUrl(),
   'sub' => "{$user['id']}",
    'exp' => $expTime,
    'iat' => time(),
    'nbf' => time(),
    'is_admin' => $user['role_id'] == 1 //after our claims, we can sign the jwt  with our secret key from our env file
  ], getenv("SECRET_KEY"),'HS256');

//Now that we have the JWT ready, we will use the HTTP Foundations package to set and retrieve cookies.

//we use cookie class from symfony package
// first part name of the cookie, second Jason web token, third exp time, fourth the path, fith the domain and last part tells the cookie where it lives
//without it it'll live in this session and do not have to be always available
$accessToken = new Symfony\Component\HttpFoundation\Cookie('access_token', $jwt, $expTime, '/',
getenv('COOKIE_DOMAIN'));

//once we have our access token, we want to redirect the user back with a cookie,so we modify our redirect func to allow for a cookie to be passed in



$session->getFlashBag()->add('success', 'Success');


//redirect and pass the cookie
redirect('../index.php',['cookies' => [$accessToken]]);

//: Because we set our extra parameter to accept an array, make sure you pass the cookie as an array.

// iss	Issuer	Who issues this claim?
// sub	Subject	Who is the subject?
// exp	Expiration Time	When this JWT expires
// iat	Issued At	Seconds since epoch
// nbf	Not Before	Seconds since epoch
// is_admin	Private Claim Data	Is the user an Admin?

//notes for .env
// here we can define any environment  variables that you want to access with a get env function or the _env variable
// this file should contain any secret keys that you need for your application
// in our case we need a secret key for our jobs to be signed wit 36 random characters and domain where our cookie will live
