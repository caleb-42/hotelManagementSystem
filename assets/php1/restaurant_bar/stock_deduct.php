<?php
 include "../settings/connect.php";  //database name = $dbConn
 $items_string = $_POST["items"];
 $item_list = json_decode($stock_deduct, true);

 $no_of_items = count($item_list);

 $select_item = $conn->prepare("SELECT current_stock FROM restaurant_items WHERE item = ? ");

 $select_item->bind_param("s", $item);

 for ($i=0; $i < $no_of_items; $i++) { 
 	# code...
 }
?>