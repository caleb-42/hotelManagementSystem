<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

//$edit_discounts = json_decode($_POST["edit_discounts"], true);

$edit_discounts = '{"discount_name": "sprite+45", "discount_item": "sprite", "discount_id":10, "lower_limit":4500, "upper_limit":8000, "discount_value":50}';

$edit_discounts = json_decode($edit_discounts, true);

$discount_name = $edit_discounts["discount_name"];
echo $discount_name . "<br>";
$lower_limit = $edit_discounts["lower_limit"];
echo $lower_limit . "<br>";
$lower_limit = intval($lower_limit);
$upper_limit = $edit_discounts["upper_limit"];
$upper_limit = intval($upper_limit);
echo $upper_limit . "<br>";
$discount_item = $edit_discounts["discount_item"];
echo $discount_item . "<br>";
$discount_value = $edit_discounts["discount_value"];
$discount_value = intval($discount_value);
echo $discount_value . "<br>";
$discount_id = $edit_discounts["discount_id"];
$discount_id = intval($discount_id);
echo $discount_id . "<br>";

/*Deleting obsolete discounts*/

$delete_in_between_discounts_query = "DELETE FROM restaurant_discount WHERE lower_limit >= $lower_limit AND upper_limit <= $upper_limit AND upper_limit != 0 AND discount_item = '$discount_item' AND id != $discount_id";
$delete_in_between_discounts_result = mysqli_query($dbConn, $delete_in_between_discounts_query);

/*Deleting obsolete discounts*/

/*Carrying out actual update*/

$update_discount_query = "UPDATE restaurant_discount SET upper_limit = $upper_limit, lower_limit = $lower_limit, discount_name = '$discount_name', discount_item = '$discount_item', discount_value = $discount_value  WHERE id = $discount_id";

$update_discount_result = mysqli_query($dbConn, $update_discount_query);

/*Carrying out actual update*/

/*Creating Array for Rationalizing table*/

$select_discount_query = "SELECT id, lower_limit, upper_limit FROM restaurant_discount WHERE discount_item = '$discount_item' ORDER BY lower_limit";
$select_discount_result = mysqli_query($dbConn, $select_discount_query);
$ux =0;
	while ($row = mysqli_fetch_assoc($select_discount_result)) {
		$updated_discounts[$ux]["id"] = intval($row["id"]);
		$updated_discounts[$ux]["lower_limit"] = intval($row["lower_limit"]);
		$updated_discounts[$ux]["upper_limit"] = intval($row["upper_limit"]);
		if ($ux > 0) {
			if (($updated_discounts[$ux - 1]["id"] != $discount_id)) {
			     $updated_discounts[$ux - 1]["upper_limit"] = $updated_discounts[$ux]["lower_limit"];
		    }  else if ($updated_discounts[$ux - 1]["id"] == $discount_id) {
			     $updated_discounts[$ux]["lower_limit"] = $updated_discounts[$ux - 1]["upper_limit"];
		    }

		}
		$ux++;
	}

/*Creating Array for Rationalizing table*/

/*Updating the discount table to match with updated discounts*/

$update_discount_query = $conn->prepare("UPDATE restaurant_discount SET upper_limit = ?, lower_limit = ? WHERE id = ?");
$update_discount_query->bind_param("iii", $update_upper, $update_lower, $update_id);

	$no_of_updates = count($updated_discounts);
	for ($i=0; $i <$no_of_updates; $i++) { 
		$update_upper = $updated_discounts[$i]["upper_limit"];
		$update_lower = $updated_discounts[$i]["lower_limit"];
	    $update_id = $updated_discounts[$i]["id"];
	    $update_discount_query->execute();
	}
	echo "<br>SUCCESSFULLY UPDATED";
$update_discount_query->close();

/*Updating the discount table to match with updated discounts*/

?>