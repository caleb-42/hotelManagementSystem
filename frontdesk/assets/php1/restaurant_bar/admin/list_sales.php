<?php
  include "../../settings/connect.php"; //$database handler $dbConn or $conn
  //print_r($_POST["sales_ref"]);
  $sales_ref = $_POST["sales_ref"];

  $get_sales_sql = "SELECT * FROM restaurant_sales WHERE sales_ref = '$sales_ref'";
  $get_sales_result = mysqli_query($dbConn, $get_sales_sql);
  $get_sales_array = [];

  function get_all_restaurant_items($sales_result, $sales_array) {
    $sales_array = [];

    if (mysqli_num_rows($sales_result) > 0){
 	  while($rows = mysqli_fetch_assoc($sales_result)) {
 		$sales_array[] = $rows;
 	  }
 	  $get_sales_json = json_encode($sales_array);
 	  return $get_sales_json;
    }
  }

  $restaurant_sales = get_all_restaurant_items($get_sales_result, $get_sales_array);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	    echo $restaurant_sales;
  } else {
  	  echo "UNAUTHORIZED ACCESS";
  }
?>