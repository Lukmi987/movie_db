<?php
include_once "../main/queryToDatabase.php"; // include connection file
include_once "../main/authentication.php";
require_once __DIR__ . '/authentication/requireFiles.php';
requireAuth();

$au = new authentication();
$query = new queryToDatabase();
$err = false; //defaultly we set it on false

//fill the variables for the input fields of the form with the current movie when the page is loaded
$movie = $query->selectFilm();
$MovieOwnerId;
  if (isset($movie)){
    foreach ($movie as $row) {
      $title = $row['title'];
      $description = $row['description'];
      $year = $row['release_year'];
      $length = $row['length'];
      $MovieOwnerId = $row['Owner_id'];
    }
  } else {
  echo "0 result";
  }


//We have to be admin or its owner, happens only if both func returns false
if(!isAdmin() && !isOwner($MovieOwnerId)){
  $session->getFlashBag()->add('error', 'Not Authorized');
  redirect('./showMovies.php');
}

//test post data from the form and update them to database
if (isset($_POST['submit'])){
  $err = $au->testInput(); // returns true if some field is empty
  if(!$err) { //if not false update the movie
  $update = $query->updateFilm();
  $wasItsave = $query->verifyInsertSuccess($update);
  echo $wasItsave;
  }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>List of Movies</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel='stylesheet' href='css/normalize.css'>
    <link rel='stylesheet' href='css/style.css'>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="ajaxForGettingImg.js"></script>
    <script src="ajaxToDisplayImgs.js"></script>
  <head>


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
        <div class='container d-flex flex-row flex-wrap justify-content-sm-center'>
        <div class="well col-sm-6 col-sm-offset-3">
          <h1>Update Movie</h1>
          <form action="" method="POST">
              <label for='title' class='sr-only'>Title</label>
              <input type="text" name='title' class="form-control" value="<?php echo $title; ?>" required>
              <br>
              <label for='description' class='sr-only'>Description</label>
              <input type="text" name="description" class="form-control" value="<?php echo $description; ?>" required>
              <br>
              <label for='year' class='sr-only'>year</label>
              <input type="number" name="year" class="form-control" value="<?php echo $year; ?>" required>
              <br>
              <label for='length' class='sr-only'>length</label>
              <input type="number" name="length" class="form-control" value="<?php echo $length; ?>">
              <br>
              <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Update</button>
      </form>
    </div>
    <div class='col'>
      <div class="form-group">
        <h2>Save a new image for the movie by using Ajax</h2>
        <form id="uploadimage" action="" method="post">
            <input type="file" name="idmovie" required> <br /> <!-- when i put input type file browser fills the name of the the button -->
            <input type="hidden" name='idmovie' value= <?php echo $_GET['id'] ?> /> <!-- get id of the current movie -->
            <input type="submit" value="Upload">
          </div>
        </form>
        <h4 id='message'></h4>
    </div>
  </div>
<!-- imgs are saved on the local machine, using ajax for getting img path and sending it to php script
to save the path of the img to database -->


<div class='container'>
<h2>Using ajax to call dinamically img on each click of the button</h2>
<button type="button" id="ButtonImgs">Load 3 pictures</button>
</br>
</br>
</div>

<div class="container">
  <img id="carousel" src="<?php $image = $query->firstImgGallery();
  foreach($image as $row){
  $image =  $row['name'];
  }
  echo $image;
  ?>" alt="">
  <button id="right-btn"><i class="arrow"></i><button>
</div>

    </div> <!-- row -->
  </div><!-- wrapper -->
  <footer class='main-footer'>
    <span>&copy;2019 Lukas Komprs</span>
  </footer>
</body>
</html>
