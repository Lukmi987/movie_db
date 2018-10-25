<?php
require_once __DIR__ . '/requireFiles.php';
requireAuth();
?>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
  <div class="container">
      <div class="well col-sm-6 col-sm-offset-3">
          <form class="form-signin" method="post" action="changePassword.php">
              <h2 class="form-signin-heading">My account</h2>
              <h4>Change Password</h4>
              <?php echo display_errors(); ?>
              <?php echo display_success_login(); ?>
              <label for="inputCurrentPassword" class="sr-only">Current password</label>
              <input type="password" id="inputCurrentPassword" name="current_password" class="form-control" placeholder="Current Password" required autofocus>
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
  </div>
</body>
</html>
