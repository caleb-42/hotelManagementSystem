<?php
include "../settings/connect.php"; //$database handler $dbConn or $conn

$new_customer = json_decode($_POST["new_customer"], true);

$first_name = $new_customer["first_name"];
$last_name = $new_customer["last_name"];
$customer_type = $new_customer["customer_type"];

if ($customer_type == "LODGER") {
	$customer_type = "LOD";
} else if ($customer_type == "TABBED") {
	$customer_type = "TAB";
} else {
	$customer_type = "WALK IN";
}

$last_cus_id_query = "SELECT MAX(id) AS id FROM restaurant_customers WHERE customer_type = '$customer_type'";
$last_cus_id_result = mysqli_query($dbConn, $last_cus_id_query);

if (mysqli_num_rows($last_cus_id_result) <= 0) {
	$cus_id = 1;
	$cus_ref =  $customer_type . str_pad($cus_id, 5, '0', STR_PAD_LEFT);
} else {
	$row = mysqli_fetch_assoc($last_cus_id_result);
	$cus_id = intval($row["id"]) + 1;
	$cus_ref =  $customer_type . str_pad($cus_id, 5, '0', STR_PAD_LEFT);
}

$add_new_customer_query = "INSERT INTO restaurant_customers (customer_ref, customer_type, first_name, last_name, outstanding_balance, outstanding_ref) VALUES('$cus_ref', '$customer_type', '$first_name', '$last_name', 0, '0000')";
$add_new_customer_result = mysqli_query($dbConn, $add_new_customer_query);
if ($add_new_customer_result) {
	$msg_response = $first_name . " " . $last_name . " successfully added to customer database";
} else {
	$msg_response = "Something went wrong with adding this customer";
}

echo $msg_response;
?>