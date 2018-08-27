<?php

class Db_object{

    function __autoload($class_name){
        include $class_name . ".php";
    }
    
    function __construct(){
       /* echo "ewere";*/
    }
    static function select_object($tb,$qcol=null,$qval=null,$cond = ["="]){
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

    function insert_object($tb, $col, $val){
        $user = DbHandler::insert_cmd([
            "table" => $tb,
            "col" => $col,
            "val" => $val,
            "cond" => ["="]
        ]);
        return $user;
    }
    
    function update_object($tb,$col,$val,$qcol,$qval){
//        sleep(2);
        $user = DbHandler::update_cmd([
            "table" => $tb,
            "col" => $col,
            "val" => $val,
            "cond" => ["="],
            "qcol" => $qcol,
            "qval" => $qval,
            "conj" => ["AND"]
        ]);
        return $user;
    }
    
    function delete_object($tb,$qcol,$qval){
        $users = DbHandler::delete_cmd([
            "table" => $tb,
            "qcol" => $qcol,
            "qval" => $qval,
            "cond" => ["="]
        ]);
    }

    function find_closest_date($arr, $todays_date,$dir){
        $interval = array();
        $newdates = array();
        foreach ($arr as $day){
            if($dir == "before"){
                if(strtotime($todays_date) >= strtotime($day)){
                    $interval[] = abs(strtotime($todays_date) - strtotime($day));
                    $newdates[] = $day;
                }
            }else{
                if(strtotime($todays_date) <= strtotime($day)){
                    $interval[] = abs(strtotime($todays_date) - strtotime($day));
                    $newdates[] = $day;
                } 
            }
            
            
        }
        $clo ="";
        if(empty($interval)){
            $clo = "0000-00-00" ;
        }else{
            asort($interval);
            $closest = key($interval);
            $clo = $newdates[$closest];
        }

        return $clo;

    }
    
    function get_todays_date(){

        date_default_timezone_set('Africa/Lagos');
        $date = new DateTime();
        $d = $date->getTimestamp();
        $tday = date("Y-m-d", $d);

        return $tday;

    }


}

?>