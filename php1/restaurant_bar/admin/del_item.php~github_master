<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

$items = json_decode($_POST["del_items"], true);
//$del_items = '{"items": [{"item": "sprite", "id": 5}, {"item": "hot-dog", "id": 4}]}';
//$items = json_decode($del_items, true);

$deleted = [];

$del_array = $items["items"];
$no_of_items = count($del_array);
$msg_response=["OUTPUT", "NOTHING HAPPENED"];


$delete_items_query = $conn->prepare("DELETE FROM restaurant_items WHERE item = ? AND id = ?");
$delete_items_query->bind_param("si", $item, $item_id);
print_r($del_array);
for ($i=0; $i < $no_of_items; $i++) { 
 	$item = $del_array[$i]["item"];
 	$item_id = $del_array[$i]["id"];
 	$delete_items_query->execute();
 	$deleted[] = $item;
}
$deleted_items = json_encode($deleted);

if(count($deleted)){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESSFULLY DELETED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}

$response_message = json_encode($msg_response);
echo $response_message;
?>