<?php


class User extends Db_object{

    function insert_object($arr){
        /*print_r($arr);
        $tb = "products";
        $checkcol = "product_name";
        $checkval = $arr["product_name"];
        $col = array_keys($arr);
        $val = array_values($arr);

        $confirm_product_in_db = parent::select_object($tb, [$checkcol],[$checkval]);

        if(empty($confirm_product_in_db[3])){
            $users = parent::insert_object($tb,$col,$val);
            if($users[1] == "success"){
                echo $users[2];
                //print_r($users[3]);
            }echo "Customer name added";
        }else{
            echo "Product name already taken";
        }*/
    }

    function update_object(){

    }
    function delete_object($arr){
        $qval = $arr["name"];
        $users = parent::delete_object("users", ["username"], [$qval]);
    }
}

?>