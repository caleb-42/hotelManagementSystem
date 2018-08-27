<?php


class Inventory extends Db_object{



    function get_stockentry_no($exp, $pro){
        /*$users = parent::select_object("stockentry",["stockexpiry_date","product"],[$exp, $pro]);
        $number_of_entries = count($users[3]);
        return $number_of_entries;*/
    }

    function insert_object($arr){

    }


    function update_object($arr){
        /*paidamt=0&paymethod=Cash&cust=AUSTIN PHARMACY&class=Inventory*/
        
        $this->debtpayment($arr);
        /*return udpdatecustumerinvoice($arr);*/
    }
    
    function debtpayment($arr){
        $upd = "values failed to update";
       /* print_r($arr);*/
        $cust_name = $arr["cust"];
        $invoice = "debtpay";
        $todays_date = parent::get_todays_date();
        $paid = intval($arr["paidamt"]);
        $oldoutbal = intval($arr["debt_read"]);
        $newoutbal = $oldoutbal - $paid;
        $category = "customer";
        $adminref = $arr["adminref"];
        $paymeth= $arr["paymethod"];
        $users = parent::insert_object("customerinvoice", ["customer","date","invno","totalamt","totalpaid","outbalance","category","salesref","paymeth"], [$cust_name,$todays_date,$invoice,0,$paid,$newoutbal,$category,$adminref,$paymeth]);

        if($users[1] == "success"){
            $updval = parent::update_object("customers", ["outstanding_balance"], [$newoutbal], ["customer_name"], [$cust_name]);
            $upd = $users[2];
        }
        echo $upd;
        return $upd;
    }

    function udpdatecustumerinvoice($arr){
        $upd = "values failed to update";
        $monies = [];
        $customers = parent::select_object("customerinvoice", ["customer"],[$arr["cust"]]);
        /*print_r($customers[3]);*/
        if(!empty($customers[3])){
            foreach($customers[3] as $cust){
                if($cust["id"] >= $arr["wherecol"]){
                    $mon["total"] = $cust["totalamt"];
                    $mon["paid"] = $cust["totalpaid"];
                    $mon["outbal"] = $cust["outbalance"];
                    $mon["id"] = $cust["id"];
                    $mon["salesdate"] = $cust["date"];
                    $mon["invno"] = $cust["invno"];
                    $mon["ref"] = $cust["salesref"];
                    $monies[] = $mon;
                }
            }
            $custname = $arr["cust"];
            $salesdate = DateTime::createFromFormat('d/m/Y', $monies[0]["salesdate"])->format('Y-m-d');
            $totalamt = $monies[0]["total"];
            $invno = $monies[0]["invno"];
            $ref = $monies[0]["ref"];
            $custid = $monies[0]["id"];
            $extra = intval($arr["paidamt"]);
            $oldpaid = intval($monies[0]["paid"]);
            $paid = $oldpaid + $extra;
            $todays_date = parent::get_todays_date();
            parent::update_object("customerinvoice", ["totalpaid"], [$paid], ["id"], [$custid]);
            $count = 0;
            foreach($monies as $mon){
                $outbal = intval($mon["outbal"]) - intval($arr["paidamt"]);
                if($count==0){
                    $users = parent::insert_object("customerupdate", ["customer_name","invoice","sales_date","update_date","totalamt","oldpaid","added_amt","newpaid","old_outbal","new_outbal","user_update", "cust_id"], [$custname,$invno,$salesdate,$todays_date,$totalamt,$oldpaid,$extra,$paid,$mon["outbal"],$outbal,$ref,$custid]);
                }
                $updval = parent::update_object("customerinvoice", ["outbalance"], [$outbal], ["id"], [$mon["id"]]);
                if($updval[1] == "success"){
                    $upd = $updval[2];
                    $updval = parent::update_object("customers", ["outstanding_balance"], [$outbal], ["customer_name"], [$arr["cust"]]);
                }
                $count++;
            }
        }

        return $upd;
    }


    function delete_object($arr){
        $qval = intval($arr["id"]);
        $customer_Inventory = parent::select_object("customerinvoice",["id"],[$qval]);
        $users = parent::delete_object("customerinvoice", ["id"], [$qval]);
        $cust_name = $customer_Inventory[3][0]["customer"];
        $paid = intval($customer_Inventory[3][0]["totalpaid"]);
        $newoutbal = intval($customer_Inventory[3][0]["outbalance"]);
        $oldoutbal = $newoutbal + $paid;
        echo $oldoutbal;
        $monies = [];
        $customers = parent::select_object("customerinvoice", ["customer"],[$cust_name]);
        /*print_r($customers[3]);*/
        $outbal = $oldoutbal;
        if(!empty($customers[3])){
            foreach($customers[3] as $cust){
                if($cust["id"] > $qval){
                    $mon["outbal"] = $cust["outbalance"];
                    $mon["id"] = $cust["id"];
                    $monies[] = $mon;
                }
            }
            foreach($monies as $mon){
                $outbal = intval($mon["outbal"]) + intval($paid);
                $updval = parent::update_object("customerinvoice", ["outbalance"], [$outbal], ["id"], [$mon["id"]]);
            }
            $updval = parent::update_object("customers", ["outstanding_balance"], [$outbal], ["customer_name"], [$cust_name]);
        }
    }

}

?>