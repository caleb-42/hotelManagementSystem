<?php
include "../settings/connect.php";  //database name = $dbConn
$net_cost = $_POST["net_cost"];
$net_cost = intval($net_cost);
$discount_array = [];
$discount_json = "";

$discount_query = "SELECT * FROM restaurant_discount WHERE discount_item = 'all' AND lower_limit < $net_cost AND upper_limit > $net_cost";
$discount_result = mysqli_query($dbConn, $discount_query);

if (mysqli_num_rows($discount_result) > 0 ) {
	while($rows = mysqli_fetch_assoc($discount_result)) {
		$discount_array[] = $rows;
	}
	$discount_json = json_encode($discount_array);
}
echo  $discount_json;
?>