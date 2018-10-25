<?php
include "../main/queryToDatabase.php"; // include connection file

 displayImages();

 function displayImages(){
    $query = new queryToDatabase();
    $conn = $query->connect();

    $movieId =intval($_POST['id']);
    $offset =intval($_POST['limit']);

    $q = "SELECT name FROM images WHERE film_id = '$movieId' ORDER BY name  LIMIT 1 OFFSET $offset ";
    $r = mysqli_query($conn,$q);

    $images = array();

    while($row = mysqli_fetch_assoc($r)){
        //print_r($row);
        $images[] = $row['name'];
  }


 if(mysqli_affected_rows($conn)== 1) {
  echo json_encode( $images );
  } else {
    echo 0;
  }
    mysqli_close($conn);
  }
 ?>
