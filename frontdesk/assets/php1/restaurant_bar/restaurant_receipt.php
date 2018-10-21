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

$sales_details = $_POST["sales_details"];
//$sales_details = '{"customer": "Ugonna", "sales_rep": "webplay", "customer_ref": "LOD_001", "transaction_discount": 10, "amount_paid": 5000, "total_cost": 8000, "discounted_total_cost": 7200, "pay_method": "CASH", "item_list": [{"item":"heineken", "type":"beer", "quantity": 4, "unit_cost": 300, "net_cost": 1200, "discount_rate": 0, "discounted_net_cost": 1200, "discount_amount": 0, "sold_by":"webplay", "shelf_item":"yes", "new_stock": 12}, {"item":"fanta", "type":"soft drink", "quantity": 4, "unit_cost": 200, "net_cost": 800, "discount_rate": 0, "discounted_net_cost": 800, "discount_amount": 0, "sold_by":"webplay", "shelf_item":"yes", "new_stock": 12}, {"item":"hot-dog", "type":"beef", "quantity": 6, "unit_cost": 1000, "net_cost": 6000, "discount_rate": 0, "discounted_net_cost": 6000, "discount_amount": 0, "sold_by":"webplay", "shelf_item":"no", "new_stock": 0}]}';
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

$no_of_items = count($item_list); // Items listed on bill

/* stock check*/
$select_items_query = $conn->prepare("SELECT current_stock, item, shelf_item, id FROM restaurant_items WHERE item = ?");

$select_items_query->bind_param("s", $item); // continue from here

 for ($i=0; $i<$no_of_items; $i++) { 
 	$item = $item_list[$i]["item"];
 	$item_qty = $item_list[$i]["quantity"];
 	$select_items_query->execute();
 	$select_items_query->bind_result($item_stock, $item_item, $item_shelf, $item_id);
 	$select_items_query->fetch();
 	if (($item_list[$i]["quantity"] > intval($item_stock)) && ($item_shelf == "yes")) {
 		$select_items_query->close();
 		die("The quantity of " . $item . " requested is more than stock quantity");
 	} else if (($item_list[$i]["quantity"] <= intval($item_stock)) && ($item_shelf == "yes")) {
 		$item_list[$i]["new_stock"] = intval($item_stock) - $item_qty;
 	}
 }
 $select_items_query->close();
 /* stock check*/

/*Record sales of individual items*/
$insert_into_sales = $conn->prepare("INSERT INTO restaurant_sales (sales_ref, item, type, quantity, unit_cost, net_cost, discount_rate, discounted_net_cost, discount_amount, sold_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$insert_into_sales->bind_param("sssiiiiiis", $tx_ref, $item, $type, $item_qty, $unit_cost, $net_cost, $discount_rate, $discounted_net_cost, $discount_amount, $sold_by);

for ($i=0; $i <$no_of_items ; $i++) { 
	$tx_ref = $txn_ref;
	$item = $item_list[$i]["item"];
	$type = $item_list[$i]["type"];
	$item_qty = $item_list[$i]["quantity"];
	$unit_cost = $item_list[$i]["current_price"];
	$net_cost = $item_list[$i]["net_cost"];
	$discount_rate = $item_list[$i]["discount_rate"];
	$discounted_net_cost = $item_list[$i]["discounted_net_cost"];
	$discount_amount = $item_list[$i]["discount_amount"];
	$sold_by = $item_list[$i]["sold_by"];
	$insert_into_sales->execute();
}
$insert_into_sales->close();

$update_stock_query = $conn->prepare("UPDATE restaurant_items SET current_stock = ? WHERE item = ? AND shelf_item = 'yes'");
$update_stock_query->bind_param("is", $new_stock, $item);
for ($i=0; $i <$no_of_items ; $i++) {
	$item = $item_list[$i]["item"];
	$item_qty = $item_list[$i]["quantity"];
	$shelf_item = $item_list[$i]["shelf_item"];
	if ($shelf_item == "yes") {
		$new_stock = $item_list[$i]["new_stock"];
		$update_stock_query->execute();
	}
}
$update_stock_query->close();

/*Record sales of individual items*/

/*Record Transaction*/
if ($amount_paid) {
	$payment_record_query = "INSERT INTO restaurant_payments (restaurant_txn, amount_paid, amount_balance, net_paid, txn_worth, customer_id, means_of_payment ,date_of_payment) VALUES('$txn_ref', $amount_paid, $amount_balance, $amount_paid, $discounted_total_cost, '$customer_ref', '$pay_method', CURRENT_TIMESTAMP)";
} else {
	$payment_record_query = "INSERT INTO restaurant_payments (restaurant_txn, amount_paid, net_paid, amount_balance, txn_worth, customer_id) VALUES('$txn_ref', $amount_paid, $amount_paid, $amount_balance, $discounted_total_cost, '$customer_ref')";
}

if ($amount_balance == 0) {
	$payment_status = "PAID FULL";
} else {
	$payment_status = "UNBALANCED";
}

$payment_record_result = mysqli_query($dbConn, $payment_record_query);

//var_dump($customer_ref);
$txn_insert_query = "INSERT INTO restaurant_txn (txn_ref, total_items, total_cost, transaction_discount, discounted_total_cost, deposited, balance, customer_ref, pay_method, payment_status, sales_rep) VALUES('$txn_ref', $no_of_items, $total_cost, $transaction_discount, $discounted_total_cost, $amount_paid, $amount_balance, '$customer_ref', '$pay_method', '$payment_status', '$sales_rep')";
$txn_insert_result = mysqli_query($dbConn, $txn_insert_query);

if ($customer != "") {
	if (substr($customer_ref, 0, 3) == "LOD") {
	   $customer_txn_query = "INSERT INTO frontdesk_customer_transactions (customer_ref, section, transaction_ref) VALUES('$customer_ref', 'RESTAURANT', '$txn_ref')";
	   $customer_txn_result = mysqli_query($dbConn, $customer_txn_query);

	   $guest_outstanding_query = "UPDATE frontdesk_guests SET restaurant_outstanding = restaurant_outstanding + $amount_balance WHERE guest_id = '$customer_ref'";
	   $guest_outstanding_result = mysqli_query($dbConn, $guest_outstanding_query);
    } else {
    	$customer_outstanding_query = "UPDATE restaurant_customers SET outstanding_balance = outstanding_balance + $amount_balance WHERE customer_id = '$customer_ref'";
	   $customer_outstanding_result = mysqli_query($dbConn, $customer_outstanding_query);
    }

}

//var_dump($txn_insert_result);

/*Receipt printer initialization, initial parameters set*/

$fp = fopen("receipt.txt", "w+");

$highSeparator = "-------------------------------\n";
$separator =     "_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ \n";
$separatorSolid = "________________________________\n";
$doubleSeparator = "= = = = = = = = = = = = = = = = \n";

$receiptNo = "RECEIPT NO.:" . $txn_ref ."               ";
$current_date = date("D M d, Y g:i a");
$receipt_time = "Receipt Generated on:\n" . $current_date . "\n";

$header = $biz_add . $biz_contact;

/*Receipt printer initialization, initial parameters set*/
$logo = "assets/logo.png";

function receipt_header($fprinter, $org_name, $header_msg, $receipt_no, $high_separator){
    if (!$fprinter) {
       echo "$errstr ($errno)<br />\n";
    } else {
    fwrite($fprinter, "\033\100");
    fwrite($fprinter, "\x1B\x61\x01");
    fwrite($fprinter, "\x1B\x45\x31");
    fwrite($fprinter, "\n");
    fwrite($fprinter, $org_name);
    fwrite($fprinter, "\x1B\x45\x30");
    fwrite($fprinter, "\n");
    fwrite($fprinter, $header_msg);
    fwrite($fprinter, "\x1B\x61\x00");
    fwrite($fprinter, "\x0A");
    fwrite($fprinter, "\x1B\x45\x31");
    fwrite($fprinter, $receipt_no);
    fwrite($fprinter, "\x1B\x45\x30");
    fwrite($fprinter, $high_separator);
   }
}

function receipt_body($fprinter, $items_arr, $item_arr_count, $cost_due, $paid_amount, $normal_separator, $two_line_separator, $paid_with, $time_of_issue, $discount_rate) {
	fwrite($fprinter, "\x1B\x2D\x01");
	fwrite($fprinter, "Item(s)");
	fwrite($fprinter, "\x1B\x2D\x00");
	fwrite($fprinter, "           ");
	fwrite($fprinter, "\x1B\x2D\x01");
	fwrite($fprinter, "Qty.");
	fwrite($fprinter, "\x1B\x2D\x00");
	fwrite($fprinter, "   ");
	fwrite($fprinter, "\x1B\x2D\x01");
	fwrite($fprinter, "Cost(N)");
	fwrite($fprinter, "\x1B\x2D\x00");
	fwrite($fprinter, "\x0A");

	for ($i=0; $i<$item_arr_count; $i++) {
		$item = $items_arr[$i]["item"];
		if(strlen($item) < 17) {
		  fwrite($fprinter, $item);
		  for ($x=0; $x<(17-strlen($item)); $x++){
			fwrite($fprinter, " ");
		  }
	    } elseif (strlen($item) < 33) {
	    	$item = wordwrap($item, 16, "\n", true);
	    	$array_items = explode("\n", $item);
	    	fwrite($fprinter, $item);
	    	for ($x=0; $x<(17-strlen($array_items[count($array_items) - 1])); $x++){
			fwrite($fprinter, " ");
		  }
	    } elseif (strlen($products) < 49) {
	    	$products = wordwrap($products, 16, "\n", true);
	    	$array_items = explode("\n", $products);
	    	fwrite($fprinter, $item);
	    	for ($x=0; $x<(17-strlen($array_items[count($array_items) - 1])); $x++){
			fwrite($fprinter, " ");
		  }
	    } 

	    $quantity = "x" . $items_arr[$i]["quantity"];
	    if (strlen($quantity) < 5) {
	    	for ($x=0; $x<(5-strlen($quantity)); $x++){
	    		fwrite($fprinter, " ");
	    	}
	    	fwrite($fprinter, $quantity);
	    }

	    $cost_of_item = $items_arr[$i]["discounted_net_cost"];
	    if(strlen(number_format($cost_of_item)) < 10) {
		  for ($x=0; $x<(10-strlen(number_format($cost_of_item))); $x++){
			fwrite($fprinter, " ");
		  }
		  fwrite($fprinter, number_format($cost_of_item));
		  fwrite($fprinter, "\n");
	    }
	}

	$balance_amount = $cost_due - $paid_amount;
    $paid_string = "Amt. Paid: N". number_format($paid_amount) . "\n";
    $balance_string  = "Balance:   N" . number_format($balance_amount) . "\n";
    $total_items = "Total Items: " . $item_arr_count . "\n";
    $receipt_paid_with = "Paid: $paid_with\n";
    $receipt_discount = "Discount: $discount_rate"."%\n";

    fwrite($fprinter, $normal_separator);
    fwrite($fprinter, $total_items);
    fwrite($fprinter, "\x1B\x45\x31");
    fwrite($fprinter, $paid_string);
    fwrite($fprinter, "\x1B\x45\x30");
    fwrite($fprinter, $receipt_paid_with);
    fwrite($fprinter, $balance_string);
    fwrite($fprinter, $receipt_discount);
    fwrite($fprinter, "\x1D\x34\x01");
    fwrite($fprinter, "Cost Total: ");
    fwrite($fprinter, "\x1D\x34\x00");
    fwrite($fprinter, "\x1D\x21\x11");
    if ($cost_due) {
	  fwrite($fprinter, "N");
    }

    if ($cost_due) {
	   fwrite($fprinter, number_format($cost_due));
    } else {
	   fwrite($fprinter, $cost_due);
    }

    fwrite($fprinter, "\x1D\x21\x00");
    fwrite($fprinter, "\x0A");
    fwrite($fprinter, $two_line_separator);
    fwrite($fprinter, $time_of_issue);
    fwrite($fprinter, "\x0A");
}

$partingMsg = "Thanks for your patronage.\nPls call again.\nServiced by: $sales_rep\n";
if ($customer) {
  $customer_msg = "CUSTOMER: " . $customer . "\n";
} else {
  $customer_msg = "";
}
$poweredBy = "Powered by: WEBPLAY ePOS.\nwww.epos.ng | 2348139097050\n";

function receipt_footer($fprinter, $solid_separator, $parthian, $cus_msg, $powered_msg){
    $footer = $parthian . $cus_msg . $solid_separator . $powered_msg;
	fwrite($fprinter, "\x1B\x61\x01");
    fwrite($fprinter, $footer);
    fwrite($fprinter, "\x1B\x61\x00");
    fwrite($fprinter, "\012\012\012\033\151\010\004\001");
    fclose($fprinter);
}

// function receipt_logo($fprinter, $pic){
//   try {
//     $tux = EscposImage::load($pic, false);
//     $fprinter -> setJustification(Printer::JUSTIFY_CENTER);    
//     $fprinter -> bitImageColumnFormat($tux);
//     $fprinter -> setJustification(Printer::JUSTIFY_LEFT);
//   } catch (Exception $e) {
//      /* Images not supported on your PHP, or image file not found */
//      $fprinter -> text($e -> getMessage() . "\n");
//   }
//   $fprinter -> close();
// }
//receipt_logo($printer, $logo);  //Print receipt logo
  try {
    $tux = EscposImage::load($logo, false);
    $printer -> setJustification(Printer::JUSTIFY_CENTER);    
    $printer -> bitImageColumnFormat($tux);
    $printer -> setJustification(Printer::JUSTIFY_LEFT);
  } catch (Exception $e) {
     /* Images not supported on your PHP, or image file not found */
     $printer -> text($e -> getMessage() . "\n");
  }
  $printer -> close();

/* Complete Receipt Printing */
receipt_header($fp, $biz_name, $header, $receiptNo, $highSeparator);
receipt_body($fp, $item_list, $no_of_items, $discounted_total_cost, $amount_paid, $separator, $doubleSeparator, $pay_method, $receipt_time, $transaction_discount);
receipt_footer($fp, $separatorSolid, $partingMsg, $customer_msg, $poweredBy);

$printData = file_get_contents("receipt.txt");
$print_buffer[] = $printData;
$device = "\\\\" . gethostname() . "\\" . $printName;
$filename = tempnam(sys_get_temp_dir(), "webpos");
file_put_contents($filename, $printData);

copy($filename, $device);       //Print receipt contents
unlink($filename);

$msg_response="";

if($txn_insert_result && $payment_record_result){
	$msg_response[0] = "OUTPUT";
	$msg_response[1] = "SUCCESS";
} else {
	$msg_response[0] = "ERROR";
	$msg_response[1] = "SOMETHING WENT WRONG";
}

$response_message = json_encode($msg_response);
echo $response_message;
/* Complete Receipt Printing */
?>