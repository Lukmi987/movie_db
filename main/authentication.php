<?php
class authentication {

  public  function testInput(){

  if(!empty($_POST)){
    // var_dump($_POST);
    $err = false;
    if(empty(trim($_POST['title']))){
        $err = TRUE;
    }elseif(empty(trim($_POST['description']))){
        $err = TRUE;
    }elseif(empty(trim($_POST['year']))){
        $err = TRUE;
    }elseif(empty(trim($_POST['length']))){
        $err = TRUE;
    }
    return $err;
  }
}
  public function test_input($data){
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
    }
}

?>
