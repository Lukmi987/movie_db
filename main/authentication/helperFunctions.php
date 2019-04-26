<?php
include_once  "/../queryToDatabase.php";

/**
 * this helper gets the current request called request, which just creates a new Symphony request
 * object where we can get posted data.
 * @return \Symfony\Component\HttpFoundation\Request
 */
function request() {
    return \Symfony\Component\HttpFoundation\Request::createFromGlobals();
}

//the second property defaults to an empty array, that's because we can expand it in the future without to much Work
//after we set variable for the response and before we send it, we need to check for cookies inside of the extra array
function redirect($path, $extra =[]) {
    $response = \Symfony\Component\HttpFoundation\Response::create(null, \Symfony\Component\HttpFoundation\Response::HTTP_FOUND, ['Location' => $path]);
      if (key_exists('cookies', $extra)){  // if it exists we'll loop over each of the cookie so that we can set multiple cookies on the response headers using the SET cookie function
        foreach($extra['cookies'] as $cookie) {
          $response->headers->setCookie($cookie); //setcookie()  defines a cookie to be sent along with the rest of the HTTP headers.
          }
      }
    $response->send();
    exit;
}


function decodeJwt($prop = null){ // $prop property will tell the funciton if we want to return a scpecific item from the JWT or return whole JWT object itself if the property is null
  \Firebase\JWT\JWT::$leeway = 1; //When there is a clock skew(zkresleni) of time between the signing and verifying servers, then we can run the access token cookie through the decode method
  $jwt = \Firebase\JWT\JWT::decode(// decode takes 3 properties: JWT, serecet key and the array of approved signing algorihms
    request()->cookies->get('access_token'),
    getenv('SECRET_KEY'),
      ['HS256']//Since we signed the token with HS 256, That's the only approved signing algorithm we want in our list.
    );

  if ($prop === null) {
    return $jwt;
  }
  return $jwt->{$prop};
}

//checks if the user is authenticated in its own func
function isAuthenticated(){
  if(!request()->cookies->has('access_token')){
    return false;
  }
  //if we have access token we should try to validate the jwt by decoding it
  try{
      decodeJwt();
        return true; // if there were any exception thrown from the decoding of the jwt then we return false
  } catch (\Exception $e){

    return false;
  }
}

function requireAuth(){ //use it at the top of any file where you require authentication
  if(!isAuthenticated()){
    $accessToken = new Symfony\Component\HttpFoundation\Cookie('access_token', 'Expired', time()-3600,'/',
    getenv('COOKIE_DOMAIN')); //before we redirect we should set a new cookie  with the same name that expires in the past with an invalid jwt
    redirect('authentication/login.php',['cookies' => [$accessToken]]); //common practice for making sure that the browser doesn't see a valid jwt in case it misses that the cookie is actually expired
  }
}

function requireAdmin(){ // add to the top of the every page where we require Admin rights
if(!isAuthenticated()){
  $accessToken = new Symfony\Component\HttpFoundation\Cookie('access_token', 'Expired', time()-3600,'/',
  getenv('COOKIE_DOMAIN')); //before we redirect we should set a new cookie  with the same name that expires in the past with an invalid jwt
  redirect('authentication/login.php',['cookies' => [$accessToken]]);
  }

  global $session;// if we want to use a session variable we need to specify that we pull it from the global scope
  try{
    if(! decodeJwt('is_admin')){
      $session->getFlashBag()->add('error', 'Not Authorized');
      redirect('../showMovies.php');
    }
  } catch (\Exception $e){//If there's any problem reading from the cookie or the JWT we can clear the user and have them log back in
    $accessToken = new Symfony\Component\HttpFoundation\Cookie('access_token', 'Expired', time()-3600,'/',
    getenv('COOKIE_DOMAIN'));
    redirect('authentication/login.php',['cookies' => [$accessToken]]);
  }
}

function isAdmin(){
  if(!isAuthenticated()){
    return false;
  }
  try{
    $isAdmin = decodeJwt('is_admin');
  }catch(\Exception $e){
    return false;
  }
return (boolean)$isAdmin; // we want to make se it's eaither true or false. So, let's set it as a Boolean, just to be sure
}

function isOwner($MovieOwnerId){//we can get the owner of the movie from Db and pass it to this func to verify that the authenticated user is the actual owner
  if(!isAuthenticated()){
    return false;
  }
  try{
  $user = decodeJwt('sub');
} catch(\Exception $e){
    return false;
  }

  return $MovieOwnerId == $user;
}

function display_errors() {
  global $session;

    if (!$session->getFlashBag()->has('error')) {
      return;
    }
    // if we have errors
    $messages = $session->getFlashBag()->get('error');
  //create an allert with all the error messages
  $response = '<div class="alert alert-danger alert-dismissable">'; //
  foreach($messages as $message){
    $response .= "{$message}<br />";
    }
    $response .='</div>';
  //print_r($response);
  return $response;
}

function display_success_login(){
  global $session;

  if(!$session->getFlashBag()->has('success')) {
      return;
  }

  $messages = $session->getFlashBag()->get('success');

  $response = '<div class="alert alert-success alert-dismissable">';
  foreach ($messages as $message) {
      $response .= "{$message}<br>";
  }
  $response .= '</div>';

  return $response;
}

//since we're retrieving the information from the JWT in a cookie we do not have to pass a parameter
//we need to decode again JWT
   function findUserByIdFromJWT(){
     $query = new queryToDatabase();

    try{
      $userId = decodeJwt('sub'); //sub as a property will give us the user id
    } catch(\Exception $e){
      throw $e;
    }

    $q = "SELECT * FROM users WHERE id = '$userId'";
    $r =  mysqli_query($query->connect(), $q) OR die(mysqli_error($query->connect()));

    while($row = mysqli_fetch_assoc($r)){
        return $row;
    }
  }

    function updateUser($password,$userId){
       $query = new queryToDatabase();
       $updated = $query->resetUserPassword($password, $userId);
      return $updated;
    }

    function getAllUsers(){
        $query = new queryToDatabase();
        $allUsers = $query->returnAllUsers();
      return $allUsers;
      }
