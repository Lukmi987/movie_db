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
      <form class='searchForm ' method="get" action="doSearch.php">
        <input type='text' name='s' id='s' placeholder="Search database" />
        <input type='submit' value='go' />
  <div id='result'></div>
      </form>

    </div>
    <!-- /header -->
    <!-- Navigation -->
    <div class='navbar '>
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
         echo "<div class='alert'>logged in</div>";
       }  else{
        echo "<div class='alert'>Please sign in if you want to update and delete movies</div>";
      }
      echo display_success_login();
      echo display_errors();
      ?>

        <div class='video embed-responsive embed-responsive-16by9'>
          <iframe class="embed-responsive-item"  src="https://www.youtube.com/embed/V75dMMIW2B4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
          </iframe>
        </div>

        <div class='main col table-responsive'>
          <table class='table table-bordered' width='100%'  cellspacing="0">
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

        <div class=' about col'>
          <h3>Used Technology</h4>
          <p>
            For an <b>Authentication</b> I use <b>JWT</b> and store it into a cookie. <br>
            For encoding and decoding Jason Web Token from the cookie I use methods by the Firebase package.<br>
            Next to set and retrieve the cookie I use the HTTP Foundation package from Symfony<br>
            To save a user pwd in to DB securely I use <b>password_hash()</b> method.
          </p>
          <h6>Live Search</h6>
          <p>
           For a live search hints I use <b>AJAX</b> and Php script to obtain data from DB  after each written letter in the search field and finally autocomple() function by Jquery to do front-end magic :D.
          <p>
            <h6>Queries to MySQL database</h6>
            <p>To connect to MySQL db I use the connection object which is an instance of the PDO Class. In order to prevent <b>SQL injection</b> I use <b>PDO Prepared Statements</b>. </p><br>
          <h6>Loading data to the movie table</h6>
          <p>I use AJAX to get the data from a file in <b>JSON Format</b> which I create with a PHP script using json_encode method after retrieving the required data from DB</br>
            The obtained data from a JSON file are converted to the Javascript format with JSON.parse method.
          </p>
        </div> <!-- /side -->
    </div> <!-- /wrapper -->
    <footer class='main-footer'>
      <span>&copy;2019 Lukas Komprs</span>
    </footer>
    <script src='ajax_live_search.js'>
    </script>
    </body>
</html>
