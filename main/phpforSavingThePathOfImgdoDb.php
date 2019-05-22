<?php
include "../main/queryToDatabase.php"; // include connection file



$myId = intval($_POST['idmovie']);

$file_name = $_FILES['idmovie']['name'];
$file_type = $_FILES['idmovie']['type'];
$file_tmp_name = $_FILES['idmovie']['tmp_name'];
$file_size = $_FILES['idmovie']['size'];


//target directory
$target_dir = "upload/";

//uploding file
if(move_uploaded_file($file_tmp_name,$target_dir.$file_name)){
    $query = new queryToDatabase();
    $query->saveImages($myId,$target_dir,$file_name);
    if($query) {
      echo "File has been successfully uploaded <br />";
    } else {
     echo "Something went wrong <br />";
  }
}


//   $q = "SELECT name FROM images WHERE film_id = '$myId'";
//   $r = mysqli_query($conn,$q);
//   while($row = mysqli_fetch_assoc($r)){
//       echo '<img height="300" width="300" src="'.$row['name'].'"> <br/>';
//   }
//   mysqli_close($conn);
// }

?>
