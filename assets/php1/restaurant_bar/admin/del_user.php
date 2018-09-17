<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

$del_users = json_decode($_POST["del_users"], true);
//$del_users = '{"user_names": [{"user_name": "sprite", "id": 5}, {"user_name": "hot-dog", "id": 4}]}';

$deleted = [];

$users = json_decode($del_users, true);
$del_array = $users["users"];
var_dump($del_array);
$no_of_users = count($del_array);

$delete_users_query = $conn->prepare("DELETE FROM restaurant_users WHERE user_name = ? AND id = ?");
$delete_users_query->bind_param("si", $user_name, $user_name_id);

for ($i=0; $i < $no_of_user_names; $i++) { 
 	$user_name = $del_array[$i]["user_name"];
 	$user_name_id = $del_array[$i]["id"];
 	$delete_users_query->execute();
 	$deleted[] = $user_name;
}
$delete_users_query->close();
$deleted_users = json_encode($deleted);
echo $deleted_users;

?>