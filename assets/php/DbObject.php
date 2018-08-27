<?php

class DbObject{

    function __autoload($class_name){
        include $class_name . ".php";
    }
    
    function __construct(){
        echo "ewd";
    }
    
    function select_object($tb,$qcol,$qval,$cond = ["="]){
        if(isset($tb,$qcol,$qval,$cond)){
            $users = DbHandler::select_cmd([
                "table" => $tb,
                "qcol" => $qcol,
                "qval" => $qval,
                "cond" => $cond,
                "conj" => ["AND"],
            ]);
        }else{
            $users = DbHandler::select_cmd([
                "table" => $tb
            ]);
        }
        return $users;
        
    }
    
    function insert(){

    }
    function update(){

    }
    function delete($tb,$qcol,$qval){
        $users = DbHandler::delete_cmd([
            "table" => $tb,
            "qcol" => [$qcol],
            "qval" => [$qval],
            "cond" => ["="]
        ]);
    }

    function find_closest_date($arr, $date, $drt){

        foreach ($arr as $day){
            if(strtotime($date) > strtotime($day) && $drt == "back"){
                $interval[] = abs(strtotime($date) - strtotime($day));
            }else if(strtotime($date) < strtotime($day) && $drt == "fro"){
                $interval[] = abs(strtotime($date) - strtotime($day));
            }
        }
        $clo ="";
        if(empty($interval)){
            $clo = "0000-00-00" ;
        }else{
            asort($interval);
            $closest = key($interval);
            $clo = $arr[$closest];
        }

        return $clo;

    }
    function get_todays_date($arr, $date, $drt){

        date_default_timezone_set('Africa/Lagos');
        $date = new DateTime();
        $d = $date->getTimestamp();
        $tday = date("Y-m-d H:i:s", $d);

        return $tday;

    }


}

?>