<?php
  include "../settings/connect.php"; //$database handler $dbConn or $conn

  $get_customers_sql = "SELECT * FROM restaurant_customers";
  $get_customers_result = mysqli_query($dbConn, $get_customers_sql);
  $get_customers_array = [];

  function get_all_customers($customers_result, $customers_array) {
    $customers_array = [];

    if (mysqli_num_rows($customers_result) > 0){
 	  while($rows = mysqli_fetch_assoc($customers_result)) {
 		$customers_array[] = $rows;
 	  }
 	  $get_customers_json = json_encode($customers_array);
 	  return $get_customers_json;
    }
  }

  $customer_list = get_all_customers($get_customers_result, $get_customers_array);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo $customer_list;
  } else {
  	echo "UNAUTHORIZED ACCESS";
  }
?>