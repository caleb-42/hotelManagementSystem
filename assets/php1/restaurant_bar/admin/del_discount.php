<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

$del_discounts = json_decode($_POST["del_discounts"], true);
//$del_discounts = '{"discounts": [{"discount": "sprite", "id": 5}, {"discount": "hot-dog", "id": 4}]}';

$deleted = [];

$discounts = json_decode($del_discounts, true);
$del_array = $discounts["discounts"];
var_dump($del_array);
$no_of_discounts = count($del_array);

$delete_discounts_query = $conn->prepare("DELETE FROM restaurant_discounts WHERE discount = ? AND id = ?");
$delete_discounts_query->bind_param("si", $discount, $discount_id);

for ($i=0; $i < $no_of_discounts; $i++) { 
 	$discount = $del_array[$i]["discount"];
 	$discount_id = $del_array[$i]["id"];
 	$delete_discounts_query->execute();
 	$deleted[] = $discount;
}
$deleted_discounts = json_encode($deleted);
echo $deleted_discounts;

?>