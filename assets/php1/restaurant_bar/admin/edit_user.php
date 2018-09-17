<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

$update_user = json_decode($_POST["update_user"], true);

// $update_user = '{"user": "sprite", "type": "soft-drink", "category": "drinks", "description": "plastic (33cl)", "current_price": 200, "discount_rate": 0, "discount_criteria":0, "discount_available":"no", "shelf_user": "yes", "current_stock": 50}';
// $update_user = json_decode($update_user, true);
// var_dump($update_user);

$id = $update_user["id"];
$old_name = $update_user["old_name"];
$user = $update_user["user"];
$user_name = $update_user["user_name"];
$category = $update_user["category"];
$description = $update_user["description"];
$current_price = $update_user["current_price"];
$discount_rate = $update_user["discount_rate"];
$discount_criteria = $update_user["discount_criteria"];
$discount_available = $update_user["discount_available"];
$shelf_user = $update_user["shelf_user"];
$current_stock = $update_user["current_stock"];

$msg_response="";

if ($user == "" || $type == "" || $category == "" || $description == "" || $current_price == "") {
	$msg_response = "The fields 'user name', 'Type', 'Category', 'Description' and 'Current Price' are all compulsory";
	die($msg_response);
}

if ($old_name != $user) {
	$duplicate_check_query = "SELECT * FROM restaurant_users WHERE user = '$user' AND type = '$type' AND description = '$description'";
    $duplicate_check_result = mysqli_query($dbConn, $duplicate_check_query);

    if (mysqli_num_rows($duplicate_check_result) > 0) {
	   $msg_response = "This name conflicts with a name already in use";
	   die($msg_response);
    }
}


	$update_user_query = "UPDATE restaurant_users SET user = '$user', type = '$type', category = '$category', description = '$description', current_price = $current_price, discount_rate = $discount_rate, discount_available = '$discount_available', shelf_user = '$shelf_user' WHERE id = $id";

$update_user_result = mysqli_query($dbConn, $update_user_query);

if ($update_user_result) {
	$msg_response = $user . " was successfully updated";
} 

echo $msg_response;
?>