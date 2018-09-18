<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

$del_users = json_decode($_POST["del_users"], true);
//$del_users = '{"users": [{"user_name": "vivian", "id": 1}, {"user_name": "wendy", "id": 2}]}';

$deleted = [];

//$del_users = json_decode($del_users, true);
$del_array = $del_users["users"];
//var_dump($del_array);
$no_of_users = count($del_array);

$delete_users_query = $conn->prepare("DELETE FROM restaurant_users WHERE user_name = ? AND id = ?");
$delete_users_query->bind_param("si", $user_name, $user_name_id);

for ($i=0; $i < $no_of_users; $i++) { 
 	$user_name = $del_array[$i]["user_name"];
 	$user_name_id = $del_array[$i]["id"];
 	$delete_users_query->execute();
 	$deleted[] = $user_name;
}
$delete_users_query->close();
$deleted_users = json_encode($deleted);
echo $deleted_users;

?>