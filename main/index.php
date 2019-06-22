<?php
include_once '/queryToDatabase.php';
include_once '/authentication/requireFiles.php';
require_once __DIR__ . '/head.php';
require_once __DIR__ . '/authentication/requireFiles.php';
$query = new queryToDatabase();

try{
    $AllMovies = $query->selectAllFilms();
    $query->createArrayofFilmsandReturnJsonFile($AllMovies);
} catch (\Exception $e){
    throw $e;
}
if(isAuthenticated()){
 $IdCurrentLoggedUser = findUserByIdFromJWT();
 $roleId = intval($IdCurrentLoggedUser['role_id']);
 $IdCurrentLoggedUser  = intval($IdCurrentLoggedUser['id']);
}
?>
                                                      <!-- I do not need isAuthenticated , use func from (!isAdmin() && !isOwner($MovieOwnerId) -->
  <body id='movies-data' data-userid='<?php echo $IdCurrentLoggedUser;  ?>' data-role='<?php echo $roleId;  ?>'> <!--https://developer.mozilla.org/en-US/docs/Learn/HTML/Howto/Use_data_attributes -->
    <!-- Header -->
    <div class='header'>
      <h1>Movie Databese!!!</h1>
      <!-- Search Form -->
      <form method="get" action="doSearch.php">
        <input type='text' name='s' id='s' placeholder="Search database" />
        <input type='submit' value='go' />
  <div id='result'></div>
      </form>

    </div>
    <!-- /header -->
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
                       <td>Duration</td>
                       <?php
                         if(isAuthenticated()): ?>
                       <td><a href="insert.php">Insert Movie</a></td>
                    <?php endif; ?>
                     </tr>
                   </thead>
                   <tbody id="listOfMoviesBody">
                   </tbody>
          </table>
        </div> <!-- /main -->
        <div class='side_content col'>
          <h4>Logic of the system</h4>
          <p>
            When you register you can create a movie and you have got rights to Delete and Update your created movies.
          </p>
          <p>
            As a <b>Admin</b> you can create, delete and update any movie. You have also an access to the Admin Panel where you can promote a user to Admin and demote back to normal user.
          <p>
        </div> <!-- /side -->
      </div> <!-- /row -->
    </div> <!-- /wrapper -->
    <footer class='main-footer'>
      <span>&copy;2019 Lukas Komprs</span>
    </footer>
    <script src='ajax_live_search.js'>
    </script>
    </body>
</html>
