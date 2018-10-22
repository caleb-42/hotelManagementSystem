<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

<<<<<<< HEAD
$new_room = json_decode($_POST["new_room"], true);

// $new_room = '{"room_number": "sprite", "type": "soft-drink", "category": "drinks", "description": "plastic (33cl)", "current_price": 200, "discount_rate": 0, "discount_criteria":0, "discount_available":"no", "shelf_item": "yes", "current_stock": 50}';
// $new_room = json_decode($new_room, true);
=======
//$new_room = json_decode($_POST["new_room"], true);

$new_room = '{"room_number": 202, "room_rate": 4000, "category": "deluxe"}';
$new_room = json_decode($new_room, true);
>>>>>>> github/master
// var_dump($new_room);

$room_number = $new_room["room_number"];
$room_rate = $new_room["room_rate"];
$category = $new_room["category"];
$occupancy = 0;
$current_guest_id = "";
$extra_guests = 0;
<<<<<<< HEAD
$booked = "NO";
$booked_on = TIMESTAMP("0000-00-00",  "00:00:00");
$booked_expires = TIMESTAMP("0000-00-00",  "00:00:00");
$reserved = "NO";
$reserved_date = DATE("0000-00-00");
$reserved_expiry = DATE("0000-00-00");
=======

$rand_id = mt_rand(0, 100000);
$room_id = "RM_" . $rand_id;

>>>>>>> github/master

$msg_response="";

if ($room_number == "" || $room_rate == "") {
	$msg_response = "The fields 'Room number' and 'Room rate' are compulsory";
	die($msg_response);
}

$duplicate_check_query = "SELECT * FROM frontdesk_rooms WHERE room_number = '$room_number' AND category = '$category'";
$duplicate_check_result = mysqli_query($dbConn, $duplicate_check_query);

if (mysqli_num_rows($duplicate_check_result) > 0) {
<<<<<<< HEAD
	$msg_response = "A menu room_number already exist with the same name, type and description";
	die($msg_response);
}

if ($current_stock) {
	$add_item_query = "INSERT INTO frontdesk_rooms (room_number, type, category, description, current_price, discount_rate, discount_available, shelf_item, current_stock, last_stock_update) VALUES ('$room_number', '$type', '$category', '$description', $current_price, $discount_rate, '$discount_available', '$shelf_item', $current_stock, CURRENT_TIMESTAMP)";
} else {
	$add_item_query = "INSERT INTO frontdesk_rooms (room_number, type, category, description, current_price, discount_rate, discount_available, shelf_item, current_stock) VALUES ('$room_number', '$type', '$category', '$description', $current_price, $discount_rate, '$discount_available', '$shelf_item', $current_stock)";
}
=======
	$msg_response = "A listed room_number already exist with the same number and category";
	$row = mysqli_fetch_assoc($duplicate_check_result);
	var_dump($row);
	die($msg_response);
}

	$add_item_query = "INSERT INTO frontdesk_rooms (room_number, room_rate, category, room_id) VALUES ($room_number, room_rate, '$category', '$room_id')";
>>>>>>> github/master

$add_item_result = mysqli_query($dbConn, $add_item_query);

if ($add_item_result) {
<<<<<<< HEAD
	$msg_response = $room_number . " was successfully added to menu database";
=======
	$msg_response = $room_number . " was successfully added as a hotel room";
>>>>>>> github/master
} 

echo $msg_response;
?>