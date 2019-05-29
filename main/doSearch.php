<?php
include_once '/queryToDatabase.php';
include_once '/authentication/requireFiles.php';
require_once __DIR__ . '/head.php';

$queryToDb = new queryToDatabase();
$search = null;

if(isset($_GET['s'])){
  $search = filter_input(INPUT_GET,'s',FILTER_SANITIZE_STRING);
}
$total_movies = $queryToDb->get_movies_count($search);
print_r($total_movies);

if($search != null){
  $result = $queryToDb->search_movie_array($search);
  echo "Search Results for \"".htmlspecialchars($search)."\"";

  $queryToDb->createArrayofFilmsandReturnJsonFile($result);
}

?>
<body id='movies-data' data-logged='<?php echo isAuthenticated();  ?>'> <!--https://developer.mozilla.org/en-US/docs/Learn/HTML/Howto/Use_data_attributes -->
  <!-- Header -->
  <div class='header'>
    <h1>Movie Databese!!!</h1>
    <!-- Search Form -->
    <form method="get" action="doSearch.php">
      <input class='search' type='text' name='s' id='s' placeholder="Search database" />
      <input type='submit' value='go' />
    </form>
  </div> <!-- /header -->
  <!-- Navigation -->
  <div class='navbar'>
    <ul class='navigation'>
      <li><a href='index.php'>HOME</a></li>
    <?php
      if(!isAuthenticated()) :?>
      <li><a href='authentication/login.php'>Sign In</a></li>
      <li><a href="authentication/registrationForm.php">Registration</a></li>
    <?php else: ?>

      <li><a href="authentication/doLogout.php">Log out</a></li>
      <li><a href="authentication /account.php">Reset your password</a></li>
        <?php if(isAdmin()): ?>
          <li><a href="authentication/admin.php">Admin</a></li>
        <?php endif; ?>
      <?php endif; ?>
    </ul>
  </div> <!-- /Navbar -->

    <div class='wrapper'>
    <?php
    // Because we set our extra parameter to accept an array, make sure you pass the cookie as an array.
     if(request()->cookies->has('access_token')){ //we retrieve the info through cookie name
       echo "logged in";
     }  else{
      echo "Please sign in if you want to update and delete movies";
    }
    echo display_success_login();
    echo display_errors();
    ?>

    <div class='row'>
      <div class='main col'>
        <?php
        if($total_movies < 1):{
            echo "<p><h1>No items were found matching the searched term</h1></p>";
          }
         ?>
       <?php else: ?>
         <p><h2>Your search results</h2></p>
        <table class='table table-striped' id="listOfMovies">
                 <thead>
                   <tr>
                     <td>Title</td>
                     <td>Description</td>
                     <td>Release year</td>
                     <td>Length of the movie</td>
                     <?php
                       if(isAuthenticated()): ?>
                     <td><a href="insert.php">Insert a new Movie to DB</a></td>
                  <?php endif; ?>
                   </tr>
                 </thead>
                 <tbody id="listOfMoviesBody">
                 </tbody>
        </table>
        <?php endif; ?>
      </div> <!-- /main -->
    </div> <!-- /row -->
  </div> <!-- /wrapper -->
  <footer class='main-footer'>
    <span>&copy;2019 Lukas Komprs</span>
  </footer>
  </body>
</html>
