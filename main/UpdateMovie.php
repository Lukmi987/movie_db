<?php
include_once "../main/queryToDatabase.php"; // include connection file
include_once "../main/authentication.php";
require_once __DIR__ . '/authentication/requireFiles.php';
requireAuth();

$au = new authentication();
$query = new queryToDatabase();
$err = false; //defaultly we set it on false

//fill the variables for the input fields of the form with the current movie when the page is loaded
$result = $query->selectFilm();
$MovieOwnerId;
  if ($result->num_rows > 0){
    while($row= mysqli_fetch_assoc($result)) {
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

<html>
<head>
  <title>Select movie</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet"  href="stylesForGallery.css">
  <script src="ajaxForGettingImg.js"></script>
  <script src="ajaxToDisplayImgs.js"></script>
  </head>
<body>

      <form action="" method="POST">
                <br> Title: <input type="text" name='title' value="<?php echo $title; ?>"><br>
                <br> Description <input type="text" name="description" value="<?php echo $description; ?>"><br>
                <br> Year <input type="number" name="year" value="<?php echo $year; ?>"><br>
                <br> Length <input type="number" name="length" value="<?php echo $length; ?>"><br><br>
                  <span><?php
                  if($err){
                    echo 'Fill the empty fields pls';
                    }
                  ?></span>
                 <input type="submit" name="submit" value="submit" /><br>
      </form> <br>

<!-- imgs are saved on the local machine, using ajax for getting img path and sending it to php script
to save the path of the img to database -->
<h2>Save a new image</h2>
<h1>Ajax Image Upload</h1><br/>
<hr>
<form id="uploadimage" action="" method="post" enctype="multipart/form-data">
  <div id="selectImage">
    <label>Select Your Image</label><br/>
      <input type="file" name="file" required /> <br /> <!-- when i put input type file browser fills the name of the the button -->
      <input type="hidden" id="mynumber" name ="file" value= <?php echo $_GET['id'] ?> /> <!-- get id of the current movie -->
      <input type="submit" value="Upload" />
    </div>
</form>
<h4 id='loading' >loading..</h4>

<!--  -->
<h2>Using ajax to call dinamically img on each click of the button</h2>
<button type="button" id="ButtonImgs">Load 3 pictures</button>
</br>
</br>

<div class="container">
  <img id="carousel" src="<?php echo $query->firstImgGallery(); ?>" alt="">
  <button id="right-btn"><i class="arrow"></i><button>
</div>

</body>
</html>
