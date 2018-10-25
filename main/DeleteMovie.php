<?php
//include "../config/dbconn.php"; // include connection file
require_once __DIR__ . '/authentication/requireFiles.php';
requireAuth();

$query = new queryToDatabase();
$filmId = $_GET['id'];

//befero I delete movie i need to check if the movie has some dependant images
// so first i delete all the dependant images if it has and then the movie itself
$result = $query->findImgAccordingtheFilmid($filmId);
if(empty($result)){
  $query->deleteMovie($filmId);
  echo 'Movie has been deleted';
} else{
  $query->deleteImages($result); //first we have to delete dependant images
  $query->deleteMovie($filmId);
  echo 'Movie has been deleted with all dependant images';
}

?>
