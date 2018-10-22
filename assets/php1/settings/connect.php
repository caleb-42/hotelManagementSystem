<?php
$dbConn = mysqli_connect('localhost', 'root', '','hotel_management');
  if(!$dbConn){
  	die('Could not connect: ' . mysqli_error($dbConn));
  }

$conn = new mysqli("localhost", "root", "", "hotel_management");

  if ($conn->connect_error) {
	  die("Connection failed: " .  $conn->connect_error);
  }
?>