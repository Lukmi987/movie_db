<?php
include "../main/queryToDatabase.php";
include "../main/authentication.php";

$err=false;

if(isset($_POST["submit"])) { // isset($var); ---> determines whether a variables has been set(not null) or not(null). Returns boolean.
     $query = new queryToDatabase();
     $au = new authentication();
     $err = $au->testInput();
     if(!$err){
      $insert = $query->insertFilm();
      $wasItsave = $query->verifyInsertSuccess($insert);
      echo $wasItsave;
      }
  }
?>

<html>
    <head>
        <title>Simple Insert</title>
    </head>

    <body>

        <h1>Add a new movie</h1>
        <form action="" method="post">
            <!-- attribute 'name' in each input are used as the passing variable from user to server which runs php code -->
            <input type="text" name="title" placeholder="Title" /><br />
            <input type="text" name="description" placeholder="Description" /><br />
            <input type="number" name="year" placeholder="Year" /><br />
            <input type="number" name="length" placeholder="Lenght of the movie" /><br /><br />
            <span><?php if($err){
              echo 'Fill the empty fields pls';
            } ?></span>
            <input type="submit" name="submit" value="Submit" />
        </form>
    </body>
</html>
