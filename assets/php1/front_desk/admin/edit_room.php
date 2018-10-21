<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

$update_room = json_decode($_POST["update_room"], true);

// $update_room = '{"room": "sprite", "type": "soft-drink", "category": "drinks", "description": "plastic (33cl)", "current_price": 200, "discount_rate": 0, "discount_criteria":0, "discount_available":"no", "shelf_room": "yes", "current_stock": 50}';
// $update_room = json_decode($update_room, true);
// var_dump($update_room);

$room_id = $update_room["room_id"];
$old_num = $update_room["room_number"];
$room_number = $update_room["new_room_number"] ? $update_room["new_room_number"] : $update_room["room_number"];
$room_rate = $update_room["new_room_rate"] ? $update_room["new_room_rate"] : $update_room["room_rate"];
$category = $update_room["new_category"] ? $update_room["new_category"] : $update_room["category"];

if ($old_num != $room_number) {
	$duplicate_check_query = "SELECT * FROM frontdesk_rooms WHERE room_number = '$room_number' AND category = '$category'";
    $duplicate_check_result = mysqli_query($dbConn, $duplicate_check_query);

    if (mysqli_num_rows($duplicate_check_result) > 0) {
    	$msg_response[0] = "ERROR";
	    $msg_response[1] = "This room has details conflicting with an already listed room";
	    $response_message = json_encode($msg_response);
	   die($response_message);
    }
}

$update_room_query = "UPDATE frontdesk_rooms SET room_number = $room_number, room_rate = $room_rate, category = '$category' WHERE room_id = '$room_id'";

$update_room_result = mysqli_query($dbConn, $update_room_query);

if($update_room_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESSFULLY UPDATED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}

$response_message = json_encode($msg_response);
echo $response_message;
?>