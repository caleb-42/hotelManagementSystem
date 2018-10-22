<?php
sleep(2);
include "../../settings/connect.php"; //$database handler $dbConn or $conn
$new_item = json_decode($_POST["new_item"], true);
//print_r($new_item);
// $new_item = '{"item": "sprite", "type": "soft-drink", "category": "drinks", "description": "plastic (33cl)", "current_price": 200, "discount_rate": 0, "discount_criteria":0, "discount_available":"no", "shelf_item": "yes", "current_stock": 50}';
// $new_item = json_decode($new_item, true);
// var_dump($new_item);

$item = $new_item["item"];
$type = $new_item["type"];
$category = $new_item["category"];
$description = $new_item["description"];
$current_price = $new_item["current_price"];
$discount_rate = $new_item["discount_rate"];
$discount_criteria = $new_item["discount_criteria"];
$discount_available = $new_item["discount_available"];
$shelf_item = $new_item["shelf_item"];
$current_stock = $new_item["current_stock"];

if (!($current_stock)) {
	$current_stock = "";
}

$item = mysqli_real_escape_string($dbConn, $item);
$type = mysqli_real_escape_string($dbConn, $type);
$category = mysqli_real_escape_string($dbConn, $category);
$description = mysqli_real_escape_string($dbConn, $description);
$shelf_item = mysqli_real_escape_string($dbConn, $shelf_item);

$msg_response="";

if ($item == "" || $current_price == "") {
	$msg_response = "The fields 'Item name' and 'Current Price' are compulsory";
	die($msg_response);
}

$duplicate_check_query = "SELECT * FROM restaurant_items WHERE item = '$item' AND type = '$type' AND description = '$description'";
$duplicate_check_result = mysqli_query($dbConn, $duplicate_check_query);

if (mysqli_num_rows($duplicate_check_result) > 0) {
	$msg_response = "A menu item already exist with the same name, type and description";
	die($msg_response);
}

if ($current_stock) {
	$add_item_query = "INSERT INTO restaurant_items (item, type, category, description, current_price, discount_rate, discount_available, shelf_item, current_stock, last_stock_update) VALUES ('$item', '$type', '$category', '$description', $current_price, $discount_rate, '$discount_available', '$shelf_item', $current_stock, CURRENT_TIMESTAMP)";
} else {
	$add_item_query = "INSERT INTO restaurant_items (item, type, category, description, current_price, discount_rate, discount_available, shelf_item) VALUES ('$item', '$type', '$category', '$description', $current_price, $discount_rate, '$discount_available', '$shelf_item')";
}

$add_item_result = mysqli_query($dbConn, $add_item_query);

if($add_item_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESSFULLY ADDED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}

$response_message = json_encode($msg_response);
echo $response_message;
?>