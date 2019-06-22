<?php
include "../main/queryToDatabase.php";
include "../main/authentication.php";
require_once __DIR__ . './authentication/requireFiles.php';
require_once __DIR__ . '/head.php';

requireAuth();
$userId = findUserByIdFromJWT();

$err=false;

if(isset($_POST["submit"])) { // isset($var); ---> determines whether a variables has been set(not null) or not(null). Returns boolean.
     $query = new queryToDatabase();
     $au = new authentication();
     $err = $au->testInput();
     if(!$err){
      $insert = $query->insertFilm();
      $wasItsave = $query->verifyInsertSuccess($insert);
      echo $wasItsave;
      }
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
          <div class='row'>
            <div class="well col-sm-6 col-sm-offset-3">
              <h1>ADD NEW MOVIE TO DB</h1>
              <form action="" method="post">
                <!-- attribute 'name' in each input are used as the passing variable from user to server which runs php code -->
                <label for="title" class="sr-only">Title</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Title" required>
                <br>
                <label for='description' class='sr-only'>Description></label>
                <input type="text" name="description" class="form-control" placeholder="Description" />
                <br>
                <label for="year" class="sr-only">Year</label>
                <input type="number" name="year" class="form-control" placeholder="Year" required>
                <br>
                <label for='length' class='sr-only'>Length</label>
                <input type="number" name="length" class="form-control" placeholder="Lenght of the movie" required>
                <input type="hidden" name="UserId" value="<?php echo $userId['id']; ?>">
                <br>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name='submit'>Submit</button>
              </form>
            </div>
          </div> <!-- /row -->
      </div> <!-- wrapper -->
      <footer class='main-footer'>
        <span>&copy;2019 Lukas Komprs</span>
      </footer>
      <script src='ajax_live_search.js'>
      </script>
    </body>
</html>
