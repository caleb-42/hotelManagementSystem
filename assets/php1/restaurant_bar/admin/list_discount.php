<?php
  include "../../settings/connect.php"; //$database handler $dbConn or $conn

  $get_discounts_sql = "SELECT * FROM restaurant_discount";
  $get_discounts_result = mysqli_query($dbConn, $get_discounts_sql);
  $get_discounts_array = [];

  function get_all_restaurant_discounts($discounts_result, $discounts_array) {
    $discounts_array = [];

    if (mysqli_num_rows($discounts_result) > 0){
 	    while($rows = mysqli_fetch_assoc($discounts_result)) {
 		    $discounts_array[] = $rows;
 	    }
 	    $get_discounts_json = json_encode($discounts_array);
 	    return $get_discounts_json;
    }
  }

  $restaurant_discounts = get_all_restaurant_discounts($get_discounts_result, $get_discounts_array);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo $restaurant_discounts;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  }
?>