<?php
sleep(2);
include "../settings/connect.php"; //$database handler $dbConn or $conn

$update_customer = json_decode($_POST["update_customer"], true);

//$update_customer = '{"customer_id": "RES_99116", "new_full_name": "Ryan", "new_gender": "male", "new_phone_number": "09098407743", "new_contact_address": "25 Adesuwa Rd. Benin", "full_name": "Ryan", "gender": "female", "phone_number": "08023456789", "contact_address": "plastic (33cl)"}';
 //$update_customer = json_decode($update_customer, true);
// var_dump($update_customer);

$customer_id = $update_customer["customer_id"];
$gender = $update_customer["new_gender"] ? $update_customer["new_gender"] : $update_customer["gender"];
$fullname = $update_customer["new_full_name"] ? $update_customer["new_full_name"] : $update_customer["full_name"];
$full_name = mysqli_real_escape_string($dbConn, $fullname);
$phone_number = $update_customer["new_phone_number"] ? $update_customer["new_phone_number"] : $update_customer["phone_number"];
$contact_address = $update_customer["new_contact_address"] ? $update_customer["new_contact_address"] : $update_customer["contact_address"];
$contact_address = mysqli_real_escape_string($dbConn, $contact_address);

$msg_response="";
$update_customer_query = "UPDATE restaurant_customers SET full_name = '$fullname', gender = '$gender', phone_number = '$phone_number', contact_address = '$contact_address' WHERE customer_id = '$customer_id'";
//var_dump($customer_id);

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