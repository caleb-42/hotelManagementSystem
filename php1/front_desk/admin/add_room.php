<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

//$new_room = json_decode($_POST["new_room"], true);

$new_room = '{"room_number": 202, "room_rate": 4000, "category": "deluxe"}';
$new_room = json_decode($new_room, true);
// var_dump($new_room);

$room_number = $new_room["room_number"];
$room_rate = $new_room["room_rate"];
$category = $new_room["category"];
$occupancy = 0;
$current_guest_id = "";
$extra_guests = 0;

$rand_id = mt_rand(0, 100000);
$room_id = "RM_" . $rand_id;


$msg_response="";

if ($room_number == "" || $room_rate == "") {
	$msg_response = "The fields 'Room number' and 'Room rate' are compulsory";
	die($msg_response);
}

$duplicate_check_query = "SELECT * FROM frontdesk_rooms WHERE room_number = '$room_number' AND category = '$category'";
$duplicate_check_result = mysqli_query($dbConn, $duplicate_check_query);

if (mysqli_num_rows($duplicate_check_result) > 0) {
	$msg_response = "A listed room_number already exist with the same number and category";
	$row = mysqli_fetch_assoc($duplicate_check_result);
	var_dump($row);
	die($msg_response);
}

	$add_item_query = "INSERT INTO frontdesk_rooms (room_number, room_rate, category, room_id) VALUES ($room_number, room_rate, '$category', '$room_id')";

$add_item_result = mysqli_query($dbConn, $add_item_query);

if ($add_item_result) {
	$msg_response = $room_number . " was successfully added as a hotel room";
} 

echo $msg_response;
?>