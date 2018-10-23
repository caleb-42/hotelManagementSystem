<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

$new_stock = json_decode($_POST["new_stock"], true);

//$test_stock = '{"item": "fanta", "item_id": 2, "category": "drinks", "quantity": 20}';
//$new_stock = json_decode($test_stock, true);

$item = $new_stock["item"];
$item_id = intval($new_stock["item_id"]);
$category = $new_stock["category"];
$quantity = $new_stock["quantity"];


$last_stock_query = "SELECT MAX(txn_id) AS txn_id FROM restaurant_stock WHERE item_id = $item_id";
$last_stock_result = mysqli_query($dbConn, $last_stock_query);

if (mysqli_num_rows($last_stock_result) <= 0) {
	$stock_tnx_id = 1;
	$stock_tnx_ref = $item . "_" . $item_id . "_" . str_pad($stock_tnx_id, 5, '0', STR_PAD_LEFT);
} else {
	$row = mysqli_fetch_assoc($last_stock_result);
	$stock_tnx_id = intval($row["txn_id"]) + 1;
	$stock_tnx_ref = $item . "_" . $item_id . "_" . str_pad($stock_tnx_id, 5, '0', STR_PAD_LEFT);
}

$get_current_stock_query = "SELECT current_stock FROM restaurant_items WHERE item = '$item' AND id = $item_id";
$get_current_stock_result = mysqli_query($dbConn, $get_current_stock_query);

if (mysqli_num_rows($get_current_stock_result) > 0) {
	while ($rows = mysqli_fetch_assoc($get_current_stock_result)) {
		$previous_stock = $rows["current_stock"];
	}
} else {
	$previous_stock = 0;
}

$new_stock = $quantity + intval($previous_stock);

$update_item_stock_query = "UPDATE restaurant_items SET current_stock = $new_stock, last_stock_update = CURRENT_TIMESTAMP WHERE id = $item_id";
$update_item_stock_result = mysqli_query($dbConn, $update_item_stock_query);

if ($update_item_stock_result == true) {
	$update_msg = "$quantity unit(s) of $item successfully added to stock";
} else {
	$update_msg = "$quantity unit(s) of $item not added to stock";
}

$insert_stock_entry_query = "INSERT INTO restaurant_stock (txn_id, txn_ref, item, item_id, category, prev_stock, quantity, route, new_stock) VALUES ($stock_tnx_id, '$stock_tnx_ref', '$item', $item_id, '$category', $previous_stock, $quantity, 'added', $new_stock)";
$insert_stock_entry_result = mysqli_query($dbConn, $insert_stock_entry_query);

if($insert_stock_entry_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESSFULLY ADDED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}

$response_message = json_encode($msg_response);
echo $response_message;
?>