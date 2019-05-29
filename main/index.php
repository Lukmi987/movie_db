<?php
include_once '/queryToDatabase.php';
include_once '/authentication/requireFiles.php';
require_once __DIR__ . '/head.php';
$query = new queryToDatabase();

try{
    $AllMovies = $query->selectAllFilms();
    $query->createArrayofFilmsandReturnJsonFile($AllMovies);
} catch (\Exception $e){
    throw $e;
}
?>
  <body id='movies-data' data-logged='<?php echo isAuthenticated();  ?>'> <!--https://developer.mozilla.org/en-US/docs/Learn/HTML/Howto/Use_data_attributes -->
    <!-- Header -->
    <div class='header'>
      <h1>Movie Databese!!!</h1>
      <!-- Search Form -->
      <form method="get" action="doSearch.php">
        <input type='text' name='s' id='s' placeholder="Search database" />
        <input type='submit' value='go' />
      </form>
    </div> <!-- /header -->
    <!-- Navigation -->
    <div class='navbar'>
      <ul class='navigation'>
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
        <div class='video embed-responsive embed-responsive-16by9'>
          <iframe class="embed-responsive-item"  src="https://www.youtube.com/embed/V75dMMIW2B4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
          </iframe>
        </div>

        <div class='main col'>
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
        </div> <!-- /main -->
        <div class='side_content col'>
          <h4>New movies in cinemas</h4>
          <ul>
            <li>Bohemian Rhapsidy</li>
            <li>Iron man 3</li>
            <li>True Detective Season 3</li>
            <li>Avatar</li>
            <li>Gladiator</li>
            <li>Matrix 3</li>
            <li>Deadpool 2</li>
          </ul>
        </div> <!-- /side -->
      </div> <!-- /row -->
    </div> <!-- /wrapper -->
    <footer class='main-footer'>
      <span>&copy;2019 Lukas Komprs</span>
    </footer>
    </body>
</html>
