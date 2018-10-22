<?php
include "../settings/connect.php"; //$database handler $dbConn or $conn

$del_discounts = '{"discounts": [{"discount_item": "sprite", "id": 5, "lower_limit": 1000, "upper_limit": 2000}, {"discount_item": "hot-dog", "id": 4, "lower_limit": 1200, "upper_limit": 3000}, {"discount_item": "sprite", "id": 5, "lower_limit": 2000, "upper_limit": 3000}, {"discount_item": "hot-dog", "id": 5, "lower_limit": 3000, "upper_limit": 5000}]}';

$discounts = json_decode($del_discounts, true);
$del_array = $discounts["discounts"];
$no_of_discounts = count($del_array);

$unique_keys = [];

var_dump($del_array);

for ($i=0; $i < $no_of_discounts; $i++) { 
	if (!(in_array($del_array[$i]["discount_item"], $unique_keys))) {
		$unique_keys[] = $del_array[$i]["discount_item"];
	} 
}

var_dump($unique_keys);

$test_arr = [];
$test_arr[0][0] = 5;
$test_arr[0][1] = 6;
$test_arr[1][0] = 6;
$test_arr[2][0] = 6;
$test_arr[2][1] = 6;
$test_arr[2][2] = 6;
$test_arr[3][0] = 6;
$test_arr[3][1] = 6;
$test_arr[3][2] = 6;

echo count($test_arr[2]);




var_dump($test_arr[0][0]);

//$unique_del_array = array_unique($del_array);

//var_dump($unique_del_array);
?>