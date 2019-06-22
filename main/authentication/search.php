<?php
include_once '/../queryToDatabase.php';

  $query = new queryToDatabase();

  $searchQuery = strtolower(trim(htmlspecialchars($_GET['q'])));
  $result = $query->ajaxLiveSearch($searchQuery);

  $searchResult = array();
  foreach ($result as $row) {
    $searchResult[] = $row['title'];
  }
 echo json_encode($searchResult);


//
//
//   $fp = fopen('moviesData.json', 'w'); //write to json file
//     fwrite($fp, json_encode($listOfMovies));
//     fclose($fp);
// }
//
//   $array = [];
//   while ($statement -> fetch()) {
//   $array[] = [
//     'name' => $name,
//     'picture' => $picture,
//     'description' => $description
//   ];
// }
// echo json_encode($array);
 ?>
