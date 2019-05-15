<?php
require_once __DIR__ . '/requireFiles.php';
requireAuth();
requireAdmin();
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

      <li><a href="../authentication/doLogout.php">Log out</a></li>
      <li><a href="../authentication /account.php">Reset your password</a></li>
        <?php if(isAdmin()): ?>
          <li><a href="authentication/admin.php">Admin</a></li>
        <?php endif; ?>
      <?php endif; ?>
    </ul>
  </div> <!-- /Navbar -->

    <div class='wrapper'>
        <div class='row'>
          <div class="container">
      <div class="well">
          <h2> Admin Panel</h2>
              <?php echo display_errors(); ?>
              <?php echo display_success_login(); ?>
        <div class='panel'>
          <h4>Users</h4>
        <table class='table table-striped'>
          <thead>
            <tr>
                <th>Email</th>
                <th>Registered</th>
                <th>Promote/Demote</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach (getAllUsers() as $user): ?>
              <tr>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['created_at']; ?></td>
                <td><?php if ($user['role_id'] == 1): ?>
                  <a href="./addjustRole.php?role=demote&userId=<?php echo $user['id']; ?> "class="bt btn-xs btn-success">Demote from Admin</a>
                  <?php elseif ($user['role_id'] ==2): ?>
                    <a href="./addjustRole.php?role=promote&userId=<?php echo $user['id']; ?> "class="bt btn-xs btn-success">Promote to Admin</a>
                  <?php endif; ?>
                  </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
  </div>
</div>
    </div> <!-- /row -->
  </div> <!-- /wrapper -->
  <footer class='main-footer'>
    <span>&copy;2019 Lukas Komprs</span>
  </footer>
</body>
</html>
