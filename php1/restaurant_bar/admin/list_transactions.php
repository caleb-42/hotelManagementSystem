<?php
  include "../../settings/connect.php"; //$database handler $dbConn or $conn

  if (isset($_POST["customer_ref"])) {
    $customer_ref = $_POST["customer_ref"];
  } else {
    $customer_ref = "";
  }

  $get_txn_sql = $customer_ref ? "SELECT * FROM restaurant_txn WHERE customer_ref = '$customer_ref'" : "SELECT * FROM restaurant_txn";

  $get_txn_result = mysqli_query($dbConn, $get_txn_sql);
  $get_txn_array = [];

  function get_all_restaurant_items($txn_result, $txn_array) {
    $txn_array = [];

    if (mysqli_num_rows($txn_result) > 0){
 	  while($rows = mysqli_fetch_assoc($txn_result)) {
 		$txn_array[] = $rows;
 	  }
 	  $get_txn_json = json_encode($txn_array);
 	  return $get_txn_json;
    }
  }

  $restaurant_txn = get_all_restaurant_items($get_txn_result, $get_txn_array);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
	    echo $restaurant_txn;
  } else {
  	  echo "UNAUTHORIZED ACCESS";
  }
  
?>