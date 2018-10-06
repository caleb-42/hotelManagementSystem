<?php
include "../settings/connect.php"; //$database handler $dbConn or $conn

$new_customer = json_decode($_POST["new_customer"], true);

//$new_entry = '{"full_name": "Harvey Reynolds", "gender": "male", "phone_number": "08023456789", "contact_address": "20 adesuwa rd. benin"}';
//$new_customer = json_decode($new_entry, true);


$full_name = mysqli_real_escape_string($dbConn, $new_customer["full_name"]);
$gender = $new_customer["gender"];
$phone_number = $new_customer["phone_number"];
$contact_address = mysqli_real_escape_string($dbConn, $new_customer["contact_address"]);

$rand_ref = mt_rand(0, 100000);
$cus_ref = "RES_" . $rand_ref;

$duplicate_ref_query = "SELECT * FROM restaurant_customers WHERE customer_id = '$cus_ref'";
$duplicate_ref_result = mysqli_query($dbConn, $duplicate_ref_query);

while (mysqli_num_rows($duplicate_ref_result) > 0) {
	$rand_ref = mt_rand(0, 100000);
    $cus_ref = "RES_" . $rand_ref;

    $duplicate_ref_query = "SELECT * FROM restaurant_customers WHERE customer_id = '$cus_ref'";
    $duplicate_ref_result = mysqli_query($dbConn, $duplicate_check_query);
}
$add_new_customer_query = "INSERT INTO restaurant_customers (customer_id, full_name, gender, phone_number, contact_address, outstanding_balance) VALUES('$cus_ref', '$full_name', '$gender', '$phone_number', '$contact_address', 0)";
$add_new_customer_result = mysqli_query($dbConn, $add_new_customer_query);

if($add_new_customer_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = $full_name . " SUCCESSFULLY ADDED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG" . mysqli_error($dbConn);
}

$response_message = json_encode($msg_response);
echo $response_message;

?>