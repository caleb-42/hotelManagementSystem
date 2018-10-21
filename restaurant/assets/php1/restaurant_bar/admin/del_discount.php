<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

$del_discounts = json_decode($_POST["del_discounts"], true);
// $del_discounts = '{"discounts": [{"discount_item": "sprite", "id": 6, "lower_limit": 2500, "upper_limit": 3000}, {"discount_item": "sprite", "id": 9, "lower_limit": 4000, "upper_limit": 4500}]}';

$deleted = [];
$unique_keys = [];

$discounts = $del_discounts;
$del_array = $discounts["discounts"];
$no_of_discounts = count($del_array);

$delete_discounts_query = $conn->prepare("DELETE FROM restaurant_discount WHERE id = ?");
//var_dump($delete_discounts_query);
$delete_discounts_query->bind_param("i", $discount_id);

for ($i=0; $i < $no_of_discounts; $i++) { 
 	$discount = $del_array[$i]["discount_item"];
 	$discount_id = $del_array[$i]["id"];
 	$delete_discounts_query->execute();
 	$deleted[] = $discount;
}
$delete_discounts_query->close();

/*Getting the unique keys in the collection*/
for ($i=0; $i < $no_of_discounts; $i++) { 
	if (!(in_array($del_array[$i]["discount_item"], $unique_keys))) {
		$unique_keys[] = $del_array[$i]["discount_item"];
	} 
}
$no_of_items = count($unique_keys);
/*Getting the unique keys in the collection*/

/*creating an array of discount updates to make*/
$select_discount_query = $conn->prepare("SELECT id, lower_limit, upper_limit FROM restaurant_discount WHERE discount_item = ? ORDER BY lower_limit");
$select_discount_query->bind_param("s", $discount_item);

$updated_discounts = [];

for ($i=0; $i < $no_of_items; $i++) { 
	$discount_item = $unique_keys[$i];
	$select_discount_query->execute();
	$select_discount_query->bind_result($row_id, $row_lower_limit, $row_upper_limit);
	$ux = 0;
	while ($select_discount_query->fetch()) {
		$updated_discounts[$i][$ux]["id"] = intval($row_id);
		$updated_discounts[$i][$ux]["lower_limit"] = intval($row_lower_limit);
		$updated_discounts[$i][$ux]["upper_limit"] = intval($row_upper_limit);
		if ($ux > 0) {
			$updated_discounts[$i][$ux - 1]["upper_limit"] = $updated_discounts[$i][$ux]["lower_limit"];
		}
		$ux++;
	}
	$updated_discounts[$i][$ux - 1]["upper_limit"] = 0;
}
$select_discount_query->close();
/*creating an array of discount updates to make*/

/*Updating the discount table to match with deleted discounts*/

$no_of_items = count($updated_discounts);

$update_discount_query = $conn->prepare("UPDATE restaurant_discount SET upper_limit = ? WHERE id = ?");
$update_discount_query->bind_param("ii", $update_upper, $update_id);

for ($i=0; $i < $no_of_items; $i++) { 
	$no_of_updates = count($updated_discounts[$i]);
	for ($ux=0; $ux <$no_of_updates; $ux++) { 
		$update_upper = $updated_discounts[$i][$ux]["upper_limit"];
	    $update_id = $updated_discounts[$i][$ux]["id"];
	    $update_discount_query->execute();
	}
}
$update_discount_query->close();

/*Updating the discount table to match with deleted discounts*/

$deleted_discounts = json_encode($deleted);
if(count($deleted)){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESSFULLY DELETED";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}

$response_message = json_encode($msg_response);
echo $response_message;
?>