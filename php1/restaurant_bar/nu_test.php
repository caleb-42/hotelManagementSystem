<?php
include "../settings/connect.php";  //database name = $dbConn
require __DIR__ . '/../autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$printerFile = fopen("assets/printer.txt", "r");
$printName = fgets($printerFile);
fclose($printerFile);

$shop_name_file = fopen("assets/shop_name.txt", "r");
$shop_name = fgets($shop_name_file);
fclose($shop_name_file);

$shop_address_file = fopen("assets/shop_address.txt", "r");
$shop_address = fgets($shop_address_file);
fclose($shop_address_file);

$shop_contact_file = fopen("assets/shop_contact.txt", "r");
$shop_contact = fgets($shop_contact_file);
fclose($shop_contact_file);

$biz_name = $shop_name;
$biz_add = $shop_address . "\n";
$biz_contact = $shop_contact . "\n";

$connector = new WindowsPrintConnector($printName);
$printer = new Printer($connector);

//$sales_details = $_POST["sales_details"];
$sales_details = '{"customer": "Ugonna", "sales_rep": "webplay", "customer_ref": "LOD_001", "transaction_discount": 10, "amount_paid": 5000, "total_cost": 8000, "discounted_total_cost": 7200, "pay_method": "CASH", "item_list": [{"item_name":"heineken", "type":"beer", "quantity": 4, "unit_cost": 300, "net_cost": 1200, "discount_rate": 0, "discounted_net_cost": 1200, "discount_amount": 0, "sold_by":"webplay", "shelf_item":"yes", "new_stock": 12}, {"item_name":"fanta", "type":"soft drink", "quantity": 4, "unit_cost": 200, "net_cost": 800, "discount_rate": 0, "discounted_net_cost": 800, "discount_amount": 0, "sold_by":"webplay", "shelf_item":"yes", "new_stock": 12}, {"item_name":"hot-dog", "type":"beef", "quantity": 6, "unit_cost": 1000, "net_cost": 6000, "discount_rate": 0, "discounted_net_cost": 6000, "discount_amount": 0, "sold_by":"webplay", "shelf_item":"no", "new_stock": 0}]}';
/*sales_details is the json string from the front-end the keys contain aspects of the
transaction */
$sales_details = json_decode($sales_details, true);

$item_list = $sales_details["item_list"];
/*item_list is the key containing the array of items object and associated properties*/
$sales_rep = $sales_details["sales_rep"];
$customer = $sales_details["customer"];
$customer_ref = $sales_details["customer_ref"];
$transaction_discount = $sales_details["transaction_discount"];
$amount_paid = $sales_details["amount_paid"];
$total_cost = $sales_details["total_cost"];
$discounted_total_cost = $sales_details["discounted_total_cost"];
$pay_method = $sales_details["pay_method"];
$amount_balance = $discounted_total_cost - $amount_paid;
$item = "";
$yes = "yes";
$new_stock = 0;
$shelf_item = "";
//$qty = $sales_details["quantity"]

$last_txn_id_query = "SELECT MAX(id) AS id FROM restaurant_txn";
$last_txn_id_result = mysqli_query($dbConn, $last_txn_id_query);

if (mysqli_num_rows($last_txn_id_result) <= 0) {
	$txn_id = 1;
	$txn_ref = str_pad($txn_id, 5, '0', STR_PAD_LEFT);
} else {
	$txn_id_row = mysqli_fetch_array($last_txn_id_result);
	$txn_id = $txn_id_row["id"] + 1;
	$txn_ref = str_pad($txn_id, 5, '0', STR_PAD_LEFT);
}
echo "<br>$txn_ref";

$no_of_items = count($item_list); // Items listed on bill

/* stock check*/
$select_items_query = $conn->prepare("SELECT current_stock, item, shelf_item, id FROM restaurant_items WHERE item = ?");
$select_items_query->bind_param("s", $item); // continue from here

 for ($i=0; $i<$no_of_items; $i++) { 
 	$item = $item_list[$i]["item_name"];
 	$item_qty = $item_list[$i]["quantity"];
 	$select_items_query->execute();
 	$select_items_query->bind_result($item_stock, $item_item, $item_shelf, $item_id);
 	$select_items_query->fetch();
 	if (($item_list[$i]["quantity"] > intval($item_stock)) && ($item_shelf == "yes")) {
 		$select_items_query->close();
 		die("The quantity of " . $item . " requested is more than stock quantity");
 	} else if (($item_list[$i]["quantity"] <= intval($item_stock)) && ($item_shelf == "yes")) {
 		$item_list[$i]["new_stock"] = $item_qty - intval($item_stock);
 	}
 	echo "<br>$item";
 }
 $select_items_query->close();
 /* stock check*/

/*Record sales of individual items*/
$insert_into_sales = $conn->prepare("INSERT INTO restaurant_sales (sales_ref, item, type, quantity, unit_cost, net_cost, discount_rate, discounted_net_cost, discount_amount, sold_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$insert_into_sales->bind_param("sssiiiiiis", $txn_ref, $item, $type, $item_qty, $unit_cost, $net_cost, $discount_rate, $discounted_net_cost, $discount_amount, $sold_by);

// $select_item_stock = $conn->prepare("SELECT current_stock, shelf_item FROM restaurant_items WHERE item = ?");
// $select_item_stock->bind_param("s", $item);

echo "<br>$no_of_items";

for ($i=0; $i <$no_of_items ; $i++) { 
	$item = $item_list[$i]["item_name"];
	$type = $item_list[$i]["type"];
	$item_qty = $item_list[$i]["quantity"];
	$unit_cost = $item_list[$i]["unit_cost"];
	$net_cost = $item_list[$i]["net_cost"];
	$discount_rate = $item_list[$i]["discount_rate"];
	$discounted_net_cost = $item_list[$i]["discounted_net_cost"];
	$discount_amount = $item_list[$i]["discount_amount"];
	$sold_by = $item_list[$i]["sold_by"];
	echo "<br>$item";

	$insert_into_sales->execute();

	// $select_item_stock->execute();
	// $select_item_stock->bind_result($item_stock, $shelf_item);
	// $select_item_stock->fetch();
	// if ($shelf_item == "yes") {
		// $new_stock = $item_stock - $item_qty;
		// echo "<br>$new_stock";
		// $update_stock_query->execute();
		// echo "<br>Update Attempted";
	// }
}
$insert_into_sales->close();

$update_stock_query = $conn->prepare("UPDATE restaurant_items SET current_stock = ? WHERE item = ? AND shelf_item = 'yes'");
$update_stock_query->bind_param("is", $new_stock, $item);
for ($i=0; $i <$no_of_items ; $i++) {
	$item = $item_list[$i]["item_name"];
	$item_qty = $item_list[$i]["quantity"];
	$shelf_item = $item_list[$i]["shelf_item"];
	if ($shelf_item == "yes") {
		$new_stock = $item_list[$i]["new_stock"];
		echo "<br>$new_stock";
		$update_stock_query->execute();
		echo "<br>Update Attempted";
	}
}
// $select_item_stock->close();
$update_stock_query->close();
$printer -> close();
?>