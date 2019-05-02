<?php
//include "../config/dbconn.php"; // include connection file
require_once __DIR__ . '/authentication/requireFiles.php';
requireAuth();

$query = new queryToDatabase();
$movie = $query->selectFilm();
$MovieOwnerId;
$filmId = $_GET['id'];

if(isset($movie)){ //Get the ownerId of the movie
  foreach($movie as $row){
  $MovieOwnerId = $row['Owner_id'];
  }
}

if (!isAdmin() && !isOwner($MovieOwnerId)){
  $session->getFlashBag()-add('error','Not Authorized');
  redirect('./showMovies.php');
}
//befero I delete movie i need to check if the movie has some dependant images
// so first i delete all the dependant images if it has and then the movie itself
$images = $query->findImgAccordingtheFilmid($filmId);

if(empty($images)){
  $query->deleteMovie($filmId);
  echo 'Movie has been deleted';
} else{
  $query->deleteImages($images); //first we have to delete dependant images
  $query->deleteMovie($filmId);
  echo 'Movie has been deleted with all dependant images';
}

?>
