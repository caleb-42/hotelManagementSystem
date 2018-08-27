<?php


class Stock extends Db_object{


    function calc_stock_inventory($read, $stk,$exp,$entryclosestdate,$numentr,$arithmetic = "add",$newqty = 0){
        $stkbought = $read[3][0]["stockbought"];
        $stkremain = $read[3][0]["stockremain"];

        if($arithmetic == "add"){
            $stkbought = $stkbought + $stk;
            $stkremain = $stkremain + $stk;
        }elseif($arithmetic == "upd"){
            $stkbought = $stkbought - $stk + $newqty;
            $stkremain = $stkremain - $stk + $newqty;
        }else{
            $stkbought = $stkbought - $stk;
            $stkremain = $stkremain - $stk;
        }
        
        if($stkremain < 0){
            $fail = array("failed","success", "values cause negative stock");
            return $fail;
        }

        $user = parent::update_object("stock", ["stockbought", "stockremain","entry_date","entries"], [$stkbought,$stkremain,$entryclosestdate,$numentr], ["expirydate"], [$exp]); 
        return $user;
    }

    function sum_product_stock($pro,$closestdate, $stock_edit = "true"){
        $product_stocks = parent::select_object("stock",["productname"],[$pro]);

        $total_product_stocks = 0;

        foreach($product_stocks[3] as $stock){
            //echo $s["stockremain"];
            $total_product_stocks += intval($stock["stockremain"]);
        }
        
        $user = $stock_edit ? parent::update_object("products", ["stock", "expiry_date"], [$total_product_stocks, $closestdate], ["product_name"], [$pro]) : parent::update_object("products", ["stock"], [$total_product_stocks], ["product_name"], [$pro]);
    }

    function find_closest_expiry_date($pro, $exp = "none"){
        //$expiry_dates = parent::select_object("stockentry",["product","stocktype"],[$pro, "new"]);
        $expiry_dates = parent::select_object("stock",["productname"],[$pro]);
        $expiry_dates  = $expiry_dates[3];
        $con = 0;
        $arr = array();

        foreach($expiry_dates as $date){
            $arr[$con] = intval($date["stockremain"]) > 0 ? $date["expirydate"] : "0000-00-00";
            $con++;
        }
        $exp != "none" ? array_push($arr, $exp) : null;
        

        $todays_date = parent::get_todays_date();
        $closestdate = parent::find_closest_date($arr, $todays_date,"after");
        return $closestdate;
    }

    function find_closest_entry_date($pro, $exp){
        $entry_dates = parent::select_object("stockentry",["product","stocktype"],[$pro, "new"]);
        $entry_dates = $entry_dates[3];
        $con = 0;
        $entryarr = array();
        foreach($entry_dates as $edate){
            $entryarr[$con]=$edate["entry_date"];
            $con++;
        }

        $todays_date = parent::get_todays_date();

        $entryclosestdate = parent::find_closest_date($entryarr, $todays_date,"before");
        return $entryclosestdate;
    }

    function get_stockentry_no($exp, $pro){
        $users = parent::select_object("stockentry",["stockexpiry_date","product"],[$exp, $pro]);
        $number_of_entries = count($users[3]);
        return $number_of_entries;
    }
    
    function insert_object($arr){

        $pro = $arr["product"];
        $etr = $arr["entry_date"];
        $stk = $arr["stockno"];
        $exp = $arr["stockexpiry_date"];
        $col = array_keys($arr);
        $val = array_values($arr);
        $col[] = "stocktype";
        $val[] = "new";
        
        $checkcol = ["expirydate","productname"];
        $checkval = [$exp,$pro];
        
        $users = parent::insert_object("stockentry", $col, $val);

        $number_of_entries = $this->get_stockentry_no($exp, $pro);
                
        $closest_expiry_date = $this->find_closest_expiry_date($pro, $exp);
        
        $closest_entry_date = $this->find_closest_entry_date($pro, $exp);
        
        $confirm_stock_in_db = parent::select_object("stock", $checkcol,$checkval);
        
        if(!empty($confirm_stock_in_db[3])){
            
            $user = $this->calc_stock_inventory($confirm_stock_in_db, $stk, $exp, $closest_entry_date, $number_of_entries);
            if($user[1] == "success"){
                $this->sum_product_stock($pro,$closest_expiry_date);
                return $users[2];
            }
            
        }else{
            $user = parent::insert_object("stock", ["productname","expirydate","stockbought","stocksold","stockremain", "entry_date","entries"], [$pro, $exp, $stk, 0, $stk, $etr, $number_of_entries]);
            if($user[1] == "success"){
                $this->sum_product_stock($pro,$closest_expiry_date);
                return $users[2];
            }
        }

    }


    function update_object($arr){
        isset($arr["stockno"]) ? $newqty = intval($arr["stockno"]) : $newqty = 0;
        $col = array_keys($arr);
        array_pop($col);
        array_pop($col);
        array_pop($col);
        $val = array_values($arr);
        $wval = array_pop($val);
        $frmqty = intval(array_pop($val));
        $exp = array_pop($val);
        $newqty = $newqty == 0 ? $frmqty : $newqty;
        
        $confirm_stockentry_in_db = parent::select_object("stockentry", ["id"],[$wval]);
        
        $oldcol = ["entry_date","stockno"];
        $oldval = [$confirm_stockentry_in_db[3][0]["entry_date"],$confirm_stockentry_in_db[3][0]["stockno"]];
        
        $product_name = $confirm_stockentry_in_db[3][0]["product"];
        
        $checkcol = ["expirydate","productname"];
        $checkval = [$exp,$product_name];
        
        $users = parent::update_object("stockentry", $col, $val, ["id"], [$wval]);
        
        $closest_entry_date = $this->find_closest_entry_date($product_name, $exp);
        
        $confirm_stock_in_db = parent::select_object("stock", $checkcol,$checkval);
        
        $number_of_entries = $this->get_stockentry_no($exp, $product_name);
        
        $user = $this->calc_stock_inventory($confirm_stock_in_db, $frmqty, $exp, $closest_entry_date, $number_of_entries, "upd", $newqty);
        
	    $closest_expiry_date = $this->find_closest_expiry_date($product_name);

        $this->sum_product_stock($product_name,$closest_expiry_date);
        
        if($user[1] == "success"){
            $user[0] == "failed" ? parent::update_object("stockentry", $oldcol, $oldval, ["id"], [$wval]) : null;
            return $user[2];
        }
    }
    
    function delete_object($arr){
        $arr["del"] == "Stock" ? $this->delete_stock($arr) : $this->delete_stockentry($arr);
    }
    
    function delete_stock($arr){
        $qval = $arr["id"];
        $product_stocks = parent::select_object("stock",["id"],[$qval]);
        $product_name = $product_stocks[3][0]["productname"];
        $expiry_date = $product_stocks[3][0]["expirydate"];

        $users = parent::delete_object("stock", ["id"], [$qval]);

        $closest_expiry_date = $this->find_closest_expiry_date($product_name);

        $this->sum_product_stock($product_name,$closest_expiry_date);
        parent::update_object("stockentry", ["stocktype"], ["old"], ["product","stockexpiry_date"], [$product_name, $expiry_date]); 
    }
    
    function delete_stockentry($arr){
        $qval = $arr["id"];
        $product_stockentry = parent::select_object("stockentry",["id"],[$qval]);
        
        $stkq = intval($product_stockentry[3][0]["stockno"]);
        $product_name = $product_stockentry[3][0]["product"];
        $expiry_date = $product_stockentry[3][0]["stockexpiry_date"];
        
        $users = parent::delete_object("stockentry", ["id"], [$qval]);
        
        $closest_entry_date = $this->find_closest_entry_date($product_name, $expiry_date);

        $number_of_entries = $this->get_stockentry_no($expiry_date, $product_name);
        
        $stk = parent::select_object("stock", ["expirydate","productname"],[$expiry_date,$product_name]);
        
        $this->calc_stock_inventory($stk, $stkq, $expiry_date, $closest_entry_date, $number_of_entries, "minus");
        
	   $closest_expiry_date = $this->find_closest_expiry_date($product_name);

        $this->sum_product_stock($product_name,$closest_expiry_date);
    }
    
}

?>