<?php
require_once __DIR__ . '/requireFiles.php';
requireAuth();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>List of Movies</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel='stylesheet' href="../css/normalize.css">
    <link rel='stylesheet' href="../css/style.css">
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
      rel = "stylesheet">
   <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
   <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <head>
<body id='movies-data' data-logged='<?php echo isAuthenticated();  ?>'> <!--https://developer.mozilla.org/en-US/docs/Learn/HTML/Howto/Use_data_attributes -->
  <!-- Header -->
  <div class='header'>
    <h1>Movie Databese!!!</h1>
    <!-- Search Form -->
    <form method="get" action="../doSearch.php">
      <input class='search' type='text' name='s' id='s' placeholder="Search database" />
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

      <li><a href="../authentication/doLogout.php">Log out</a></li>
      <li><a href="../authentication /account.php">Reset your password</a></li>
        <?php if(isAdmin()): ?>
          <li><a href="../authentication/admin.php">Admin</a></li>
        <?php endif; ?>
      <?php endif; ?>
    </ul>
  </div> <!-- /Navbar -->

    <div class='wrapper'>

          <div class=" forms well col-sm-8 col-sm-offset-3 col-lg-5">
            <form class="form-signin" method="post" action="changePassword.php">
                <h2 class="form-signin-heading">My account</h2>
                <h4>Change Password</h4>
                <?php echo display_errors(); ?>
                <?php echo display_success_login(); ?>
                <label for="inputCurrentPassword" class="sr-only">Current password</label>
                <input type="password" id="inputCurrentPassword" name="current_password" class="form-control" placeholder="Current Password" required>
                <br>
                <label for="inputPassword" class="sr-only">New Password</label>
                <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
                <br>
                <label for="inputPassword" class="sr-only">Confirm new Password</label>
                <input type="password" id="inputPassword" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                <br>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Change password</button>
            </form>
          </div>
    </div> <!-- wrapper -->
<footer class='main-footer'>
<span>&copy;2019 Lukas Komprs</span>
</footer>
  <script src='../ajax_live_search.js'>
</body>
</html>
