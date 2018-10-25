<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
  <div class="container">
      <div class="well col-sm-6 col-sm-offset-3">
          <form class="form-signin" method="post" action="doRegister.php">
              <h2 class="form-signin-heading">Registration</h2>
              <?php //print display_errors(); ?>
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
  </div>
</body>
</html>
