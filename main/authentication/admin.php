<?php
require_once __DIR__ . '/requireFiles.php';
requireAuth();
requireAdmin();
?>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
  <div class="container">
      <div class="well">
          <h2> Admin</h2>
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
</body>
</html>
