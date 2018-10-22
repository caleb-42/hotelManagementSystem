<?php
  include "../../settings/connect.php"; //$database handler $dbConn or $conn

  $get_items_sql = "SELECT * FROM restaurant_items";
  $get_items_result = mysqli_query($dbConn, $get_items_sql);
  $get_items_array = [];

  function get_all_restaurant_items($items_result, $items_array) {
    $items_array = [];

    if (mysqli_num_rows($items_result) > 0){
 	  while($rows = mysqli_fetch_assoc($items_result)) {
 		$items_array[] = $rows;
 	  }
 	  $get_items_json = json_encode($items_array);
 	  return $get_items_json;
    }
  }

  $restaurant_items = get_all_restaurant_items($get_items_result, $get_items_array);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo $restaurant_items;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  }
?>