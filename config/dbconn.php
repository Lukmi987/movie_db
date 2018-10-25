<?php
/*
 * this file are used to make a database connection between php file and mysql db
 */

// include any necessary file to use variables/constants in those files.
include "config.php";

/*
 * mysqli_connect() will return the connection's instance.
 * you should store the connection instance inside a variable, so that you can reuse the variable every time you wanted to connect.
 *
 * variables are defined with the '$' symbol.
 * There are no datatype declaration in php.
 */

/*
 * get connection instance and store it inside $conn variable
 * mysqli_connect(host_name, user_name, password, db_name);
 *
 * It is recommended (but not vital) for you to include the 'die()' command in order to detect the error
 * that are caused by connection with the database.
*/
$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME) or die(mysqli_error($conn));
?>