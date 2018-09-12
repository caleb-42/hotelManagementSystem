<?php
include "../../settings/connect.php"; //$database handler $dbConn or $conn

$del_items = json_decode($_POST["del_items"], true);
//$del_items = '{"items": [{"item": "sprite", "id": 5}, {"item": "hot-dog", "id": 4}]}';

$deleted = [];

$items = json_decode($del_items, true);
$del_array = $items["items"];
var_dump($del_array);
$no_of_items = count($del_array);

$delete_items_query = $conn->prepare("DELETE FROM restaurant_items WHERE item = ? AND id = ?");
$delete_items_query->bind_param("si", $item, $item_id);

for ($i=0; $i < $no_of_items; $i++) { 
 	$item = $del_array[$i]["item"];
 	$item_id = $del_array[$i]["id"];
 	$delete_items_query->execute();
 	$deleted[] = $item;
}
$deleted_items = json_encode($deleted);
echo $deleted_items;

?>