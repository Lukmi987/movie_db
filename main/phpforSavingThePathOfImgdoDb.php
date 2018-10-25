<?php
include "../main/queryToDatabase.php"; // include connection file

$id = $_POST['file'];
$myId = intval($id);

$file_name = $_FILES['file']['name'];
$file_type = $_FILES['file']['type'];
$file_tmp_name = $_FILES['file']['tmp_name'];
$file_size = $_FILES['file']['size'];

//target directory
$target_dir = "upload/";

//uploding file
if(move_uploaded_file($file_tmp_name,$target_dir.$file_name)){
    $query = new queryToDatabase();
    $conn = $query->connect();

    $q = 'INSERT INTO images(film_id,name) VALUES ("'.$myId.'","'.$target_dir.$file_name.'")';
    //run query
    $r = mysqli_query($conn,$q);

    if(mysqli_affected_rows($conn)== 1) {
      echo "File has been successfully uploaded <br />";
    } else {
     print_r($conn);
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
