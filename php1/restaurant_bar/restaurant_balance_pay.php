<?php
include "../settings/connect.php";  //database name = $dbConn

$payment_details = json_decode($_POST["payment_details"], true);

$trasaction_ref = $payment_details["trasaction_ref"];
$means_of_payment = $payment_details["means_of_payment"];
$amount_paid = $payment_details["amount_paid"];

$last_payment_id_query = "SELECT MAX(id) AS id FROM restaurant_payments WHERE restaurant_txn = '$trasaction_ref'";
$last_payment_id_result = mysqli_query($dbConn, $last_payment_id_query);

$payment_id_row = mysqli_fetch_array($last_payment_id_result);
$payment_id = intval($payment_id_row["id"]);

$last_payment = "SELECT * FROM restaurant_payments WHERE id = $payment_id";
$last_payment_result = mysqli_query($dbConn, $last_payment);

$last_payment_details = mysqli_fetch_assoc($last_payment_result);
$new_balance = intval($last_payment_details["amount_balance"]) - $amount_paid;

$txn_date = $last_payment_details["txn_date"];
$net_paid = intval($last_payment_details["net_paid"]) + $amount_paid;

$txn_worth = intval($last_payment_details["txn_worth"]);
$customer_id = $last_payment_details["customer_id"];

// echo $customer_id;
// exit;


$udpate_payment = "INSERT INTO restaurant_payments (restaurant_txn, txn_date, amount_paid, date_of_payment, amount_balance, net_paid, txn_worth, customer_id, means_of_payment) VALUES ('$trasaction_ref', '$txn_date', $amount_paid, CURRENT_TIMESTAMP, $new_balance, $net_paid, $txn_worth, '$customer_id', '$means_of_payment')";

$update_payment_result = mysqli_query($dbConn, $udpate_payment);

if (!($new_balance)) {
	$payment_status = "PAID FULL";
} else {
	$payment_status = "UNBALANCED";
}

$update_txn = "UPDATE restaurant_txn SET payment_status = '$payment_status', deposited = $net_paid, balance = $new_balance WHERE txn_ref ='$trasaction_ref'";
$update_txn_result = mysqli_query($dbConn, $update_txn);

$get_outstanding_query = "SELECT * FROM restaurant_customers WHERE customer_id = '$customer_id'";
$get_outstanding_result = mysqli_query($dbConn, $get_outstanding_query);

$get_outstanding_details = mysqli_fetch_assoc($get_outstanding_result);
$new_outstanding = intval($get_outstanding_details["outstanding_balance"]) - $amount_paid;

if (substr($customer_id, 0, 3) == "LOD") {
	$update_customer_outstanding = "UPDATE frontdesk_guests SET restaurant_outstanding = restaurant_outstanding - $amount_paid WHERE guest_id  = '$customer_id'";
    $update_outstanding_result = mysqli_query($dbConn, $update_customer_outstanding);
} else {
	$update_customer_outstanding = "UPDATE restaurant_customers SET outstanding_balance = $new_outstanding WHERE customer_id = '$customer_id'";
    $update_outstanding_result = mysqli_query($dbConn, $update_customer_outstanding);
}

$msg_response="";

if($update_txn_result && $update_payment_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "PAYMENT RECORDS SUCCESSFULLY UPDATED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}

$response_message = json_encode($msg_response);
echo $response_message;
?>