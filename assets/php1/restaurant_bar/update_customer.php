<?php
sleep(2);
include "../settings/connect.php"; //$database handler $dbConn or $conn

$update_customer = json_decode($_POST["update_customer"], true);

// $update_customer = '{"customer": "sprite", "type": "soft-drink", "category": "drinks", "description": "plastic (33cl)", "current_price": 200, "discount_rate": 0, "discount_criteria":0, "discount_available":"no", "shelf_item": "yes", "current_stock": 50}';
// $update_customer = json_decode($update_customer, true);
// var_dump($update_customer);

$customer_id = $update_customer["customer_id"];
$gender = $update_customer["new_gender"] ? $update_customer["new_gender"] : $update_customer["gender"];
$fullname = $update_customer["new_full_name"] ? $update_customer["new_full_name"] : $update_customer["full_name"];
$phone_number = $update_customer["new_phone_number"] ? $update_customer["new_phone_number"] : $update_customer["phone_number"];
$contact_address = $update_customer["contact_address"] ? $update_customer["new_contact_address"] : $update_customer["contact_address"];

$msg_response="";
$update_customer_query = "UPDATE restaurant_customers SET customer = '$fullname', gender = '$gender', phone_number = '$phone_number', contact_address = '$contact_address' WHERE customer_id = '$customer_id'";

$update_customer_result = mysqli_query($dbConn, $update_customer_query);

if($update_customer_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "CUSTOMER INFO SUCCESSFULLY UPDATED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}

$response_message = json_encode($msg_response);
echo $response_message;
?>