<?php
sleep(2);
include "../../settings/connect.php"; //$database handler $dbConn or $conn

$update_item = json_decode($_POST["update_item"], true);

// $update_item = '{"item": "sprite", "type": "soft-drink", "category": "drinks", "description": "plastic (33cl)", "current_price": 200, "discount_rate": 0, "discount_criteria":0, "discount_available":"no", "shelf_item": "yes", "current_stock": 50}';
// $update_item = json_decode($update_item, true);
// var_dump($update_item);

$id = $update_item["id"];
$old_name = $update_item["item"];
$item = $update_item["new_item"] ? $update_item["new_item"] : $update_item["item"];
$type = $update_item["new_type"] ? $update_item["new_type"] : $update_item["type"];
$category = $update_item["new_category"] ? $update_item["new_category"] : $update_item["category"];
$description = $update_item["new_description"] ? $update_item["new_description"] : $update_item["description"];
$current_price = $update_item["new_current_price"] ? $update_item["new_current_price"] : $update_item["current_price"];
/* $discount_rate = !$update_item["new_discount_rate"] ? $update_item["new_discount_rate"] : $update_item["discount_rate"];
$discount_criteria = !$update_item["new_discount_criteria"] ? $update_item["new_discount_criteria"] : $update_item["discount_criteria"];
$discount_available = !$update_item["new_discount_available"] ? $update_item["new_discount_available"] : $update_item["discount_available"]; */
$shelf_item = $update_item["new_shelf_item"] ? $update_item["new_shelf_item"] : $update_item["shelf_item"];
$current_stock = $update_item["new_current_stock"] ? $update_item["new_current_stock"] : $update_item["current_stock"];

$item = mysqli_real_escape_string($dbConn, $item);
$type = mysqli_real_escape_string($dbConn, $type);
$category = mysqli_real_escape_string($dbConn, $category);
$description = mysqli_real_escape_string($dbConn, $description);
$shelf_item = mysqli_real_escape_string($dbConn, $shelf_item);

$msg_response=["OUTPUT", "NOTHING HAPPENED"];


if ($item == "" || $type == "" || $category == "" || $description == "" || $current_price == "") {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "The fields 'Item name', 'Type', 'Category', 'Description' and 'Current Price' are all compulsory";
	$response_message = json_encode($msg_response);
	die($response_message);
}

if ($old_name != $item) {
	$duplicate_check_query = "SELECT * FROM restaurant_items WHERE item = '$item' AND type = '$type' AND description = '$description'";
    $duplicate_check_result = mysqli_query($dbConn, $duplicate_check_query);

    if (mysqli_num_rows($duplicate_check_result) > 0) {
    	$msg_response[0] = "ERROR";
	    $msg_response[1] = "This name conflicts with a name already in use";
	    $response_message = json_encode($msg_response);
	   die($response_message);
    }
}


	$update_item_query = "UPDATE restaurant_items SET item = '$item', type = '$type', category = '$category', description = '$description', current_price = $current_price, shelf_item = '$shelf_item' WHERE id = $id";

$update_item_result = mysqli_query($dbConn, $update_item_query);

if($update_item_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESSFULLY UPDATED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}

$response_message = json_encode($msg_response);
echo $response_message;
?>