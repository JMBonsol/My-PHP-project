<?php
//main connection file for both admin & front end
$hostname = "localhost"; //server
$username = "u854359985_username"; //username
$password = "Plppasigcihm2023"; //password
$dbname = "u854359985_inventory";  //databases

// Create connection
$con = mysqli_connect($hostname, $username, $password, $dbname); // connecting 
// Check connection

if ($con) {       //checking connection to DB	
  // echo "connection successful";

} else {

  die("Connection failed: " . mysqli_connect_error());
}

?>
