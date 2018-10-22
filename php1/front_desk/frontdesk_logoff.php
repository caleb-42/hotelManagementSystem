<?php
include "../settings/connect.php";  //database name = $dbConn

session_start();
$user_name = $_SESSION['user_name'];
$role = $_SESSION['role'];

$sql_getID = "SELECT MAX(id) AS id FROM frontdesk_sessions WHERE user_name='$user_name' AND role = '$role'";
$getID_result = mysqli_query($dbConn, $sql_getID);
$max_ID = mysqli_fetch_array($getID_result);
$ID = $max_ID["id"];
$ID = intval($ID);

$sql_logout = "UPDATE frontdesk_sessions SET logged_off_time = CURRENT_TIMESTAMP , logged_on_state = 'LOGGED OFF' WHERE user_name='$user_name' AND id = $ID";
$sql_logout_result = mysqli_query($dbConn, $sql_logout);
unset($_SESSION['user_name']);
unset($_SESSION['role']);
session_unset();
session_destroy();
 
header("Location:  ../../frontdesk/logIn.php"); 
exit();
?>