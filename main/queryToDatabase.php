<?php



class queryToDatabase {

  public function test_input($data){
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
    }

    public function connect(){
      $conn = mysqli_connect('localhost', 'root', '', 'movie') or die(mysqli_error($conn));
      return $conn;
    }

      public function insertFilm(){
        //for connec to databe I can inlcude dbocnn.php file into each function or I can call connect() method
        include_once "../config/dbconn.php";
           $title = $this->test_input($_POST['title']);
           $description= $this->test_input($_POST['description']);
           $release_year= $this->test_input($_POST['year']);
           $length= $this->test_input($_POST['length']);

           $insertSQL = ("INSERT INTO movies(title,description,release_year,length) VALUES('$title','$description', '$release_year', '$length')");
           $insertQuery = mysqli_query($conn,$insertSQL) or die(mysqli_error($conn));
           return $insertQuery;
        }

        public function deleteMovie($filmId){
          $delete = "DELETE FROM movies WHERE film_id='$filmId'";
          $deletequery= mysqli_query($this->connect(),$delete) or (mysqli_error($this->connect()));
        if($deletequery){
          return "Movie has been deleted";
        } else {
          return "Sorry try again";
        }
      }

        public function updateFilm(){
          $au = new authentication();
          $filmId = $_GET['id'];
          $title = $this->test_input($_POST['title']);
          $description= $this->test_input($_POST['description']);
          $release_year= $this->test_input($_POST['year']);
          $length= $this->test_input($_POST['length']);

          $update =  "UPDATE
                        movies
                      SET
                        title='".$title."',
                        description='".$description."',
                        release_year='".$release_year."',
                        length='".$length."'
                     WHERE
                       film_id ='$filmId'";

                       $updateQuery = mysqli_query($this->connect(),$update) or die(mysqli_error($this->connect()));

                       return $updateQuery;
        }

    public function  selectFilm(){
      $filmId = $_GET['id'];
      $sql = "SELECT * FROM movies WHERE film_id='$filmId'";
      $result = mysqli_query($this->connect(), $sql) OR die(mysqli_error($this->connect()));
      return $result;
    }

    public function  findImgAccordingtheFilmid($filmId){
      $sql = "SELECT * FROM images WHERE film_id='$filmId'";
      $result = mysqli_query($this->connect(), $sql) OR die(mysqli_error($this->connect()));

      $images = [];
      //fill the array $images with the id of images for the movie we want to delete
      if(mysqli_num_rows($result) != 0) {
        while($row = mysqli_fetch_assoc($result)){
            $images[] = $row['id'];
        }
        return $images;
      }
    }

    public function deleteImages($images){
      $id = [];
      foreach($images as $image){
        $id[] =  $image;
      }
      $string  =  implode("','",$id);//create string with all id of images we wan to delete
      $sql = "DELETE FROM images WHERE id in  ('$string')";
      $result = mysqli_query($this->connect(), $sql) OR die(mysqli_error($this->connect()));

      if($result){
        } else{
        echo 'error';
      }
    }

    public function selectAllFilms(){
      $selectSQL = "SELECT * FROM movies"; // select all
      $selectQuery = mysqli_query($this->connect(), $selectSQL) or die(mysqli_error($this->connect())); // run sql query
        return $selectQuery;
    }

    public function verifyInsertSuccess($query){
      if($query) { // check if insertion is successful or not
          // insertion successful
          return "<h2>Record has been safed</h2>";
      } else {
          // insertion unsuccessful
        return "<h2>There are errors pls try again.</h2>";
      }
    }

    public function createArrayofFilmsandReturnJsonFile($selectQuery){
      if(mysqli_num_rows($selectQuery) != 0) { // check if there are record(s)

        $movies = array();
        while($row = mysqli_fetch_assoc($selectQuery)){
          $movies[] = $row;
        }
        //write to json file

        $fp = fopen('moviesData.json', 'w');
        fwrite($fp, json_encode($movies));
        fclose($fp);
      }
    }

// function to load a first picture into gallery from a database
    public function firstImgGallery(){
      $filmId = $_GET['id'];
      $q = "SELECT name FROM images WHERE film_id = '$filmId' ORDER BY name  LIMIT 1 OFFSET 0 ";
      $r = mysqli_query($this->connect(),$q);

      while($row = mysqli_fetch_assoc($r)){
          //print_r($row);
          $image = $row['name'];
      }
      return $image;
  }

  public function findUserByEmail($email){
    $q = "SELECT * FROM users WHERE email = '$email'";
    $r =  mysqli_query($this->connect(), $q) OR die(mysqli_error($this->connect()));

    while($row = mysqli_fetch_assoc($r)){

        return $row;
    }
  }

  public function createUser($email, $password){
    $q = "INSERT INTO users(email, password, role_id) VALUES ('$email','$password','2')";
    $r = mysqli_query($this->connect(),$q) or die(mysqli_error($this->connect()));
  return $this->findUserByEmail($email);
  }

  public function resetUserPassword($password, $userId){
    $q = "UPDATE users SET password ='$password' WHERE id = '$userId'";
    $r = mysqli_query($this->connect(),$q) or die(mysqli_error($this->connect()));
  return $r;
  }

  public function returnAllUsers() {
    $selectSQL = "SELECT * FROM users"; // select all
    $selectQuery = mysqli_query($this->connect(), $selectSQL) or die(mysqli_error($this->connect())); // run sql query

    while($row = mysqli_fetch_assoc($selectQuery)){
      $users[] = $row;
    }
return $users;
        }

    public function promote($userId){

      try{
        $query = "UPDATE users SET role_id=1 WHERE id='$userId'";
        $result = mysqli_query($this->connect(),$query) or die(mysqli_error($this->connect()));
      } catch(\Exception $e){
        throw $e;
    }
  }

  public function demote($userId){

    try{
      $query = "UPDATE users SET role_id=2 WHERE id='$userId'";
      $result = mysqli_query($this->connect(),$query) or die(mysqli_error($this->connect()));
    } catch(\Exception $e){
      throw $e;
  }
}
}
 ?>
