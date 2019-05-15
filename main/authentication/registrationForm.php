<?php
require_once __DIR__ . '/requireFiles.php';
 ?>

 <!DOCTYPE html>
 <html>
   <head>
     <title>List of Movies</title>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     <link rel='stylesheet' href="../css/normalize.css">
     <link rel='stylesheet' href="../css/style.css">
     <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
     <script src="getMovies.js"></script>
   <head>
 <body id='movies-data' data-logged='<?php echo isAuthenticated();  ?>'> <!--https://developer.mozilla.org/en-US/docs/Learn/HTML/Howto/Use_data_attributes -->
   <!-- Header -->
   <div class='header'>
     <h1>Movie Databese!!!</h1>
     <!-- Search Form -->
     <form method="get" action="catalog.php">
       <label for='s'>Search</label>
       <input type='text' name='s' id='s' />
       <input type='submit' value='go' />
     </form>
   </div> <!-- /header -->
   <!-- Navigation -->
   <div class='navbar'>
     <ul class='navigation'>
       <li><a href='../index.php'>HOME</a></li>
     <?php
       if(!isAuthenticated()) :?>
       <li><a href='../authentication/login.php'>Sign In</a></li>
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
          <form class="form-signin" method="post" action="doRegister.php">
              <h2 class="form-signin-heading">Registration</h2>
              <?php print display_errors(); ?>
              <label for="inputEmail" class="sr-only">Email address</label>
              <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus>
              <br>
              <label for="inputPassword" class="sr-only">Password</label>
              <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
              <br>
              <label for="inputPassword" class="sr-only">Confirm Password</label>
              <input type="password" id="inputPassword" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
              <br>
              <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
          </form>
        </div>
    </div> <!-- /row -->
  </div> <!-- wrapper -->
<footer class='main-footer'>
  <span>&copy;2019 Lukas Komprs</span>
</footer>
</body>
</html>
