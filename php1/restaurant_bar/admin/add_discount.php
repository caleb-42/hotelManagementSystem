<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

$new_discount = json_decode($_POST["new_discount"], true);

$discount_name = $new_discount["discount_name"];
$lower_limit = $new_discount["lower_limit"];
$lower_limit = intval($lower_limit);
$upper_limit = $new_discount["upper_limit"];
$upper_limit = intval($upper_limit);
$discount_item = $new_discount["discount_item"];
$discount_name = mysqli_real_escape_string($dbConn, $discount_name);
$discount_item = mysqli_real_escape_string($dbConn, $discount_item);
$discount_value = $new_discount["discount_value"];
$discount_value = intval($discount_value);

//$new_discount = '{"discount_name": "Twelve Percent", "lower_limit": 5, "upper_limit": }';


if (($discount_name == "") || (($lower_limit == "") && ($lower_limit != 0)) || (($upper_limit == "") && ($upper_limit != 0)) || ($discount_item == "") || ($discount_value == "")) {	
	$msg_response[0] = "ERROR";
	$msg_response[1] = "The fields 'Discount name', 'Lower limit', 'Upper limit', 'Discount item' and 'Discount value' are all compulsory " . ($lower_limit);
	$response_message = json_encode($msg_response);
	die($response_message);
}

$duplicate_check_query = "SELECT * FROM restaurant_discount WHERE discount_value = $discount_value AND lower_limit = $lower_limit AND upper_limit = $upper_limit AND discount_item = '$discount_item'";
$duplicate_check_result = mysqli_query($dbConn, $duplicate_check_query);

if (mysqli_num_rows($duplicate_check_result) > 0) {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "A similar discount scheme already exists, please adjust your discount parameters";
	$response_message = json_encode($msg_response);
	die($response_message);
}

$duplicate_check_query = "SELECT * FROM restaurant_discount WHERE discount_name = '$discount_name'";
$duplicate_check_result = mysqli_query($dbConn, $duplicate_check_query);

if (mysqli_num_rows($duplicate_check_result) > 0) {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "The name '". $discount_name . "' is already in use for another discount scheme";
	$response_message = json_encode($msg_response);
	die($response_message);
}

$lower_limit_check_query = "SELECT * FROM restaurant_discount WHERE discount_item = '$discount_item' AND lower_limit < $lower_limit ORDER BY lower_limit DESC";
$lower_limit_check_result = mysqli_query($dbConn, $lower_limit_check_query);

if (mysqli_num_rows($lower_limit_check_result) > 0) {
	$row = mysqli_fetch_assoc($lower_limit_check_result);
	$udpate_id = $row["id"];
	$udpate_id = intval($udpate_id);
	$update_upper_limit_query = "UPDATE restaurant_discount SET upper_limit = $lower_limit WHERE id = $udpate_id";
	$update_upper_limit_result = mysqli_query($dbConn, $update_upper_limit_query);
}

$add_discount_query = "INSERT INTO restaurant_discount (discount_name, lower_limit, upper_limit, discount_item, discount_value) VALUES ('$discount_name', $lower_limit, $upper_limit, '$discount_item', $discount_value)";

$add_discount_result = mysqli_query($dbConn, $add_discount_query);

if($add_discount_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESSFULLY ADDED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}

$response_message = json_encode($msg_response);
echo $response_message;
?>