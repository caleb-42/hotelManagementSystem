<?php
  include "../../settings/connect.php"; //$database handler $dbConn or $conn

  $get_stock_sql = "SELECT * FROM restaurant_stock";
  $get_stock_result = mysqli_query($dbConn, $get_stock_sql);
  $get_stock_array = [];

  function get_all_restaurant_items($stock_result, $stock_array) {
    $stock_array = [];

    if (mysqli_num_rows($stock_result) > 0){
 	  while($rows = mysqli_fetch_assoc($stock_result)) {
 		$stock_array[] = $rows;
 	  }
 	  $get_stock_json = json_encode($stock_array);
 	  return $get_stock_json;
    }
  }

  $restaurant_stock = get_all_restaurant_items($get_stock_result, $get_stock_array);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	    echo $restaurant_stock;
  } else {
  	  echo "UNAUTHORIZED ACCESS";
  }
?>