<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

$del_discounts = json_decode($_POST["del_discounts"], true);
//$del_discounts = '{"discounts": [{"discount_item": "sprite", "id": 5, "lower_limit": 1000}, {"discount_item": "hot-dog", "id": 4, "lower_limit": 1200}]}';

$deleted = [];

$discounts = json_decode($del_discounts, true);
$del_array = $discounts["discounts"];
$no_of_discounts = count($del_array);

$select_discount_query = $conn->prepare("SELECT id, lower_limit, upper_limit FROM restaurant_discounts WHERE discount_item = ? AND upper_limit = ?");
$select_discount_query->bind_param("s", $discount_item);

for ($i=0; $i < $no_of_discounts; $i++) { 
	# code...
}

$delete_discounts_query = $conn->prepare("DELETE FROM restaurant_discounts WHERE discount_item = ? AND id = ?");
$delete_discounts_query->bind_param("si", $discount, $discount_id);

for ($i=0; $i < $no_of_discounts; $i++) { 
 	$discount = $del_array[$i]["discount_item"];
 	$discount_id = $del_array[$i]["id"];
 	$delete_discounts_query->execute();
 	$deleted[] = $discount;
}
$deleted_discounts = json_encode($deleted);
echo $deleted_discounts;

?>