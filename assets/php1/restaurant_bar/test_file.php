<?php
 include "../settings/connect.php";  //database name = $dbConn
$item_list = ["sharwama", "heineken", "hot-dog", "fanta"];

 $no_of_items = count($item_list); // Items listed on bill
 for ($i=0; $i <$no_of_items; $i++) { 
	$stock_items[$i] = $item_list[$i];
 }
 $stock_items = '("' . implode('","' , $stock_items) . '")';

/* stock check*/
 $select_items_query = "SELECT current_stock, item, id FROM restaurant_items WHERE item IN " . $stock_items . " ORDER BY item";
//$select_items_query = "SELECT current_stock FROM restaurant_items WHERE item = 'fanta'";


 $select_items_result = mysqli_query($dbConn, $select_items_query);

 for ($i=0; $row = mysqli_fetch_array($select_items_result); $i++) { 
 	echo $row["current_stock"] ." ". $row["item"] . " $i <br>";
 }

 /* stock check*/
?>