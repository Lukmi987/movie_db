<?php
include_once "/queryToDatabase.php";
include_once "/authentication/requireFiles.php";

// Because we set our extra parameter to accept an array, make sure you pass the cookie as an array.
 if(request()->cookies->has('access_token')){ //we retrieve the info through cookie name
   echo "logged in";
 }  else{
  echo "Please sign in if you want to update and delete movies";
}

    $query = new queryToDatabase();
    $selectQuery = $query->selectAllFilms();

    if($selectQuery) { // check if the query succedded or failed
        $query->createArrayofFilmsandReturnJsonFile($selectQuery);
      }
?>

<html>
<head>
    <title>Select movie</title>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <!-- <script src="../jquery-cookie-master/src/jquery.cookie.js"></script> -->
    <script src="getMovies.js"></script>
</head>

<body id='movies-data' data-logged='<?php echo isAuthenticated();  ?>'> <!--https://developer.mozilla.org/en-US/docs/Learn/HTML/Howto/Use_data_attributes -->

<?php
echo display_success_login();
echo display_errors();

 if(!isAuthenticated()) : ?>
<h3><a href="authentication/login.php">Sign in</a></h3>
<h3><a href="authentication/registrationForm.php">Registration</a></h3>
 <?php else: ?>
  <h3><a href="insert.php">Insert a new movie to the list</a></h3>
  <h3><a href="authentication/doLogout.php">Log out</a></h3>
  <h3><a href="authentication /account.php">Reset your password</a></h3>
<?php if(isAdmin()): ?>
  <h3><a href="authentication/admin.php">Admin</a></h3>
<?php endif; ?>
 <?php endif; ?>
  <div>
    <table id="listOfMovies" border="1">
             <thead>
               <tr>
                 <td>Title</td>
                 <td>Description</td>
                 <td>Release year</td>
                 <td>Length of the movie</td>
               </tr>
             </thead>
             <tbody id="listOfMoviesBody">

             </tbody>
    </table>
</body>
</html>
