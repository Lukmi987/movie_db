<?php
class queryToDatabase {

    public function connectToDb(){
      $host='localhost';
      $db='movie';
      $username='root';
      $password='';

      $dsn= "mysql:host=$host;dbname=$db";
      try{
        //create a PDO connection with the configuration data
        $db = new PDO($dsn,$username,$password);
        //after creating new PDO object, we have sat the error mode attribute of the PDO object to throw all exceptions for any kind of error that happpens
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (Exception $e){
        echo $e->getMessage();
        die();
      }
      return $db;
    }

    public function test_input($data){
      $data=trim($data);
      $data=stripslashes($data);
      $data=htmlspecialchars($data);
      return $data;
      }

      public function insertFilm(){
           $title = $this->test_input($_POST['title']);
           $description= $this->test_input($_POST['description']);
           $release_year= $this->test_input($_POST['year']);
           $length= $this->test_input($_POST['length']);

           $Owner_id = $_POST['UserId'];
           $db =$this->connectToDb();

           try{
             $query = "INSERT INTO movies (title,description,release_year,length,Owner_id) VALUES (:title, :description, :release_year, :length, :Owner_id)";
             $stmt = $db->prepare($query);
             $stmt->bindParam(':title',$title);
             $stmt->bindParam(':description',$description);
             $stmt->bindParam(':release_year',$release_year);
             $stmt->bindParam(':length',$length);
             $stmt->bindParam(':Owner_id',$Owner_id);
             return $stmt->execute();
           }catch (\Exception $e){
             throw $e;
           }
        }

        public function deleteMovie($filmId){
          $db =$this->connectToDb();
          try{
            $query = "DELETE FROM movies WHERE film_id=?";
            $stmt = $db->prepare($query);
            $stmt->bindParam(1,$filmId);
            $stmt->execute();
          } catch (\Exception $e){
          throw $e;
          }
        return  "Movie has been deleted";
      }

        public function updateFilm(){
          $db =$this->connectToDb();
          $film_id = $_GET['id'];
          $title = $this->test_input($_POST['title']);
          $description= $this->test_input($_POST['description']);
          $release_year= $this->test_input($_POST['year']);
          $length= $this->test_input($_POST['length']);

          try {
              $query =  "UPDATE
                            movies
                          SET
                            title=:title,
                            description=:description,
                            release_year=:release_year,
                            length=:length
                         WHERE
                           film_id= :film_id";


                           $stmt = $db->prepare($query);
                           $stmt->bindParam(':title',$title);
                           $stmt->bindParam(':description',$description);
                           $stmt->bindParam(':release_year',$release_year);
                           $stmt->bindParam(':length',$length);
                           $stmt->bindParam(':film_id',$film_id);
                   return $stmt->execute();
            } catch (\Exception $e){
              throw $e;
            }
        }

    public function  selectFilm(){
      $db =$this->connectToDb();
      $film_id = intval($_GET['id']);
      try {
        $query = "SELECT * FROM movies WHERE film_id=:film_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':film_id', $film_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch(\Exception $e) {
        throw $e;
      }
    }

    public function selectAllFilms(){
      $db =$this->connectToDb();
      try{
        $query = "SELECT * FROM movies"; // select all
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (\Exception $e) {
        throw $e;
      }
    }

    public function  findImgAccordingtheFilmid($film_id){
      $db =$this->connectToDb();
      try{
          $query = "SELECT * FROM images WHERE film_id=:film_id";
          $stmt = $db->prepare($query);
          $stmt->bindParam('film_id',$film_id);
          $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e){
        throw $e;
      }
    }

    public function saveImages($myId,$target_dir,$file_name){
      $db = $this->connectToDb();
      try{
        $query = 'INSERT INTO images(film_id,name) VALUES ("'.$myId.'","'.$target_dir.$file_name.'")';
        $stmt = $db->prepare($query);
        $stmt->execute();
      } catch(\Exception $e){
        throw $e;
      }
    }

    public function deleteImages($images){
      $db =$this->connectToDb();
      try{
        $id;
        foreach($images as $image){
          $id[] =  intval($image['id']);
        }
          $idOfImages  =  intval(implode("','",$id));
          $query = "DELETE FROM images WHERE id in  ('$idOfImages')";
          $stmt = $db->prepare($query);
          $stmt->execute();
        } catch (\Exception $e){
          throw $e;
        }
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

    public function createArrayofFilmsandReturnJsonFile($movies){
      if(isset($movies)) {
        $listOfMovies = array();
        foreach($movies as $row){
          $listOfMovies[] = $row;
        }

        $fp = fopen('moviesData.json', 'w'); //write to json file
          fwrite($fp, json_encode($listOfMovies));
          fclose($fp);
      }
        else echo 'Sorry something went wrong !!';
    }

    // function to load a first picture into gallery from a database
    public function firstImgGallery(){
      $db = $this->connectToDb();
      try{
        $filmId = intval($_GET['id']);
        $query = "SELECT name FROM images WHERE film_id = :film_id ORDER BY name  LIMIT 1 OFFSET 0 ";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':film_id',$filmId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
      } catch(\Exception $e){
        throw $e;
    }
  }

    public function findUserByEmail($email){
     $db = $this->connectToDb();
       try{
           $query = "SELECT * FROM users WHERE email = ?";
           $stmt = $db->prepare($query);
           $stmt->bindParam(1,$email);
           $stmt->execute();
           return $stmt->fetch(PDO::FETCH_ASSOC);
      } catch (\Exception $e){
          throw $e;
        }
     }

    public function findUserById($userId){
      $db= $this->connectToDb();
    try{
      $query = "SELECT * FROM users WHERE id =:id";
      $stmt = $db->prepare($query);
      $stmt->bindParam('id',$userId);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(\Exception $e) {
        throw $e;
      }
    }

    public function createUser($email, $password){
      $db = $this->connectToDb();

      try{
          $query = "INSERT INTO users (email,password,role_id) VALUES(:email, :password, 2)";
          $stmt = $db->prepare($query);
          $stmt->bindParam(':email',$email);
          $stmt->bindParam(':password',$password);
          $stmt->execute();
          return $this->findUserByEmail($email);
     } catch (\Exception $e){
         throw $e;
       }
    }

    public function resetUserPassword($password, $userId){
      $db = $this->connectToDb();

      try {
          $query = "UPDATE users SET password = :password WHERE id =:id";
          $stmt = $db->prepare($query);
          $stmt->bindParam(':password', $password);
          $stmt->bindParam(':id', $userId);
          return $stmt->execute();
      } catch (\Exception $e) {
          throw $e;
      }
    }

    public function returnAllUsers() {
      $db = $this->connectToDb();
      try{
          $query = "SELECT * FROM users";
          $stmt = $db->prepare($query);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch(\Exception $e){
          throw $e;
    }
      return $users;
    }

      public function promote($userId){
        $db = $this->connectToDb();
        try{
          $query = "UPDATE users SET role_id=1 WHERE id=:id";
          $stmt = $db->prepare($query);
          $stmt->bindParam(':id',$userId);
          $stmt->execute();

        } catch(\Exception $e){
          throw $e;
        }
      }

      public function demote($userId){
        $db = $this->connectToDb();
        try{
          $query = "UPDATE users SET role_id=2 WHERE id=:id";
          $stmt = $db->prepare($query);
          $stmt->bindParam(':id',$userId);
          $stmt->execute();
        } catch(\Exception $e){
          throw $e;
        }
      }

    public function get_movies_count($search){
      $db= $this->connectToDb();

      try{
        $sql = 'SELECT COUNT(film_id) FROM movies';

        if (!empty($search)) {
    $result = $db->prepare(
        $sql
        . " WHERE title LIKE ?"
    );
    $result->bindValue(1,'%'.$search.'%',PDO::PARAM_STR);
    $result->execute();
    $count = $result->fetchColumn(0);
    return $count;
  }
      }catch(\Exception $e){
        throw $e;
      }
    }

  public function search_movie_array($search){
    $db = $this->connectToDb();

    try{
      $sql = "SELECT *
      FROM movies
      WHERE title LIKE ?
      ORDER BY
      REPLACE(
        REPLACE(
          REPLACE(title,'The ',''),
          'An ',
          ''
        ),
      'A ',
      ''
    )";
    $results = $db->prepare($sql);
    $results->bindValue(1,'%'.$search.'%',PDO::PARAM_STR);
    $results->execute();
    } catch(\Exception $e){
      echo 'Unable to retrieved results';
      exit;
    }
    $searchArray = $results->fetchAll();
    return $searchArray;
  }
}
 ?>
