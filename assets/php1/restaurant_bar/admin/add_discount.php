<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

$new_discount = json_decode($_POST["new_discount"], true);

$discount_name = $new_discount["discount_name"];
$lower_limit = $new_discount["lower_limit"];
$lower_limit = intval($lower_limit);
$upper_limit = $new_discount["upper_limit"];
$upper_limit = intval($upper_limit);
$discount_item = $new_discount["discount_item"];
$discount_value = $new_discount["discount_value"];
$discount_value = intval($discount_value);


if ($discount_name == "" || $lower_limit == "" || $upper_limit == "" || $discount_item == "" || $discount_value == "") {
	$msg_response = "The fields 'Discount name', 'Lower limit', 'Upper limit', 'Discount item' and 'Discount value' are all compulsory";
	die($msg_response);
}

$duplicate_check_query = "SELECT * FROM restaurant_discount WHERE discount_value = $discount_value AND lower_limit = $lower_limit AND upper_limit = $upper_limit AND discount_item = '$discount_item'";
$duplicate_check_result = mysqli_query($dbConn, $duplicate_check_query);

if (mysqli_num_rows($duplicate_check_result) > 0) {
	$msg_response = "A similar discount scheme already exists, please adjust your discount parameters";
	die($msg_response);
}

$add_discount_query = "INSERT INTO restaurant_discount (discount_name, lower_limit, upper_limit, discount_item, discount_value) VALUES ('$discount_name', $lower_limit, $upper_limit, '$discount_item', $discount_value)";

$add_discount_result = mysqli_query($dbConn, $add_discount_result);

if ($add_discount_result) {
	$msg_response = $discount_name ." was successfully added as a discount scheme";
}

echo $msg_response;
?>