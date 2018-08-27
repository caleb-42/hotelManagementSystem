<?php


class Customer extends Db_object{

    function insert_object($arr){
        $tb = "customers";
        $checkcol = "customer_name";
        $checkval = $arr["customer_name"];
        $col = array_keys($arr);
        $val = array_values($arr);
        array_push($col, "account_created_on");
        array_push($val, parent::get_todays_date());
        $confirm_customer_in_db = parent::select_object($tb, [$checkcol],[$checkval]);

        if(empty($confirm_customer_in_db[3])){
            $users = parent::insert_object($tb,$col,$val);
            if($users[1] == "success"){
                return $users[2];
            }
        }else{
            return "Customer name already taken";
        }
    }

    function update_object($arr){
        $col = array_keys($arr);
        array_pop($col);
        $val = array_values($arr);
        $wval = array_pop($val);
        $users = parent::update_object("customers", $col, $val,["customer_name"], [$wval]);
        if($users[1] == "success"){
            return $users[2];
        }
    }
    
    function delete_object($arr){
        $qval = $arr["name"];
        $users = parent::delete_object("customers", ["customer_name"], [$qval]);
    }

}

?>