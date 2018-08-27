<?php


class Product extends Db_object{
    
    function insert_object($arr){
        $tb = "products";
        $checkcol = "product_name";
        $checkval = $arr["product_name"];
        $col = array_keys($arr);
        $val = array_values($arr);
        
        $confirm_product_in_db = parent::select_object($tb, [$checkcol],[$checkval]);

        if(empty($confirm_product_in_db[3])){
            $users = parent::insert_object($tb,$col,$val);
            if($users[1] == "success"){
                return $users[2];
            }
        }else{
            return "Product name already taken";
        }
    }
    
    function update_object($arr){
        $col = array_keys($arr);
        array_pop($col);
        $val = array_values($arr);
        $wval = array_pop($val);
        $users = parent::update_object("products", $col, $val,["product_name"], [$wval]);
        if($users[1] == "success"){
            return $users[2];
        }
    }
    
    function delete_object($arr){
        $qval = $arr["name"];
        $users = parent::delete_object("products", ["product_name"], [$qval]);
    }

}

?>