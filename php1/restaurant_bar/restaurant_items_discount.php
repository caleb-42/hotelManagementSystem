<?php
include "../settings/connect.php";  //database name = $dbConn


$items = json_decode($_POST['items'], true);

$discount_array = [];

foreach ($items as $obj){
    $item = $obj["item"];
    $net_cost = intval($obj["current_price"]) * intval($obj["quantity"]);
    $discount_query = "SELECT * FROM restaurant_discount WHERE discount_item = '$item' AND ((lower_limit < $net_cost AND upper_limit > $net_cost) OR (lower_limit < $net_cost AND upper_limit = 0))";
    $discount_result = mysqli_query($dbConn, $discount_query);
    
    if (mysqli_num_rows($discount_result) > 0 ) {
        while($rows = mysqli_fetch_assoc($discount_result)) {
            $discount_array[] = $rows;
        }
    } else {
        $discount_array[] = "nil";
    }
}

$discount_json = json_encode($discount_array);
echo $discount_json;


?>