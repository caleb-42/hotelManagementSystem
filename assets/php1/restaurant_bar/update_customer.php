<?php
sleep(2);
include "../settings/connect.php"; //$database handler $dbConn or $conn

$update_customer = json_decode($_POST["update_customer"], true);

// $update_customer = '{"customer": "sprite", "type": "soft-drink", "category": "drinks", "description": "plastic (33cl)", "current_price": 200, "discount_rate": 0, "discount_criteria":0, "discount_available":"no", "shelf_item": "yes", "current_stock": 50}';
// $update_customer = json_decode($update_customer, true);
// var_dump($update_customer);

$customer_id = $update_customer["customer_id"];
$customer_type = $update_customer["new_customer_type"] ? $update_customer["new_customer_type"] : $update_customer["customer_type"];
$first_name = $update_customer["new_first_name"] ? $update_customer["new_first_name"] : $update_customer["first_name"];
$last_name = $update_customer["new_last_name"] ? $update_customer["new_last_name"] : $update_customer["last_name"];
$outstanding_balance = $update_customer["new_outstanding_balance"] ? $update_customer["new_outstanding_balance"] : $update_customer["outstanding_balance"];
$lodged_in = $update_customer["new_lodged_in"] ? $update_customer["new_lodged_in"] : $update_customer["lodged_in"];

$msg_response="";

if ($customer == "" || $type == "" || $category == "" || $description == "" || $current_price == "") {
	$msg_response = "The fields 'customer name', 'Type', 'Category', 'Description' and 'Current Price' are all compulsory";
	die($msg_response);
}

if ($old_name != $customer) {
	$duplicate_check_query = "SELECT * FROM restaurant_items WHERE customer = '$customer' AND type = '$type' AND description = '$description'";
    $duplicate_check_result = mysqli_query($dbConn, $duplicate_check_query);

    if (mysqli_num_rows($duplicate_check_result) > 0) {
	   $msg_response = "This name conflicts with a name already in use";
	   die($msg_response);
    }
}


	$update_item_query = "UPDATE restaurant_items SET customer = '$customer', type = '$type', category = '$category', description = '$description', current_price = $current_price, shelf_item = '$shelf_item' WHERE id = $id";

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