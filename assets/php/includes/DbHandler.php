<?php
class DbHandler{
    const HOST = "localhost";
    /*const DB = "webplayg_mgxdb";
    const USER = "webplayg_root";
    const PASS = "webplay";*/
    const DB = "pricepoint";
    const USER = "root";
    const PASS = "ewere";
    public static $con;

    
    /*
    ..........keywords.......
    db
    table
    col
    val
    qcol
    qval
    conj
    cond
    
    */
    
    static function makeConnection($data){
        if(!DbHandler::$con){
            if(array_key_exists('db', $data)){
                $db = $data['db'];
                DbHandler::$con =  new mysqli(DbHandler::HOST, DbHandler::USER, DbHandler::PASS, $db);
            }else{
                DbHandler::$con = new mysqli(DbHandler::HOST, DbHandler::USER, DbHandler::PASS, DbHandler::DB);
            }
            if(!DbHandler::$con) {
                $assoc = array('0' => 'output', '1' => 'error', '2' => 'connection unsuccessful');
                return $assoc;
                exit();
            }
        }
        return DbHandler::$con;
    }
    
    static function checkkeys($key, $data){
       
        switch ($key){
            case "table":
                if(array_key_exists('table', $data)){
                    return $data;
                }else{
                    return false;
                }
            break;
            case "col":
                if(array_key_exists('col', $data) && is_array($data['col'])){
                    
                    return $data;
                    
                }else{
                    return false;
                }
            break;
            case "val":
                if(array_key_exists('val', $data) && is_array($data['val'])){
                    
                    if(count($data['col']) == 1 && count($data['val']) > 1){
                        for($i = 1; $i < count($data['val']); $i++){
                            $data['col'][$i] = $data['col'][0];
                        }
                    }
                    return $data;
                    
                }else{
                    return false;
                }
            break;
            case "qcol":
                if(array_key_exists('qcol', $data) && array_key_exists('qval', $data) && 
                   is_array($data['qcol']) && is_array($data['qval'])){
                    
                    if(count($data['qcol']) == 1 && count($data['qval']) > 1){
                        for($i = 1; $i < count($data['qval']); $i++){
                            $data['qcol'][$i] = $data['qcol'][0];
                        }
                    }
                    if(count($data['qcol']) ==  count($data['qval'])){
                        return $data;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            break;
            case "conj":
                if(array_key_exists('conj', $data) && is_array($data['conj'])){
                    if(count($data['conj']) == 1 && count($data['qval']) > 2){
                        for($i = 1; $i < count($data['qval'])-1; $i++){
                            $data['conj'][$i] = $data['conj'][0];
                        }
                    }
                    return $data;
                }else{
                    return false;
                }
            break;
            case "cond":
                if(array_key_exists('cond', $data) && is_array($data['cond'])){
                    if(count($data['cond']) == 1 && count($data['qval']) > 1){
                        for($i = 1; $i < count($data['qval']); $i++){
                            $data['cond'][$i] = $data['cond'][0];
                        }
                    }
                    return $data;
                }else{
                    return false;
                }
                
            break;
        }
    }
    
    static function makeref(&$a){
        return $a;
    }

    static function makeRefArr($arr){
        $type = "";
        //$arr = array_values($arr);
        foreach($arr as $q){
            if(is_string($q)){
                $type .= "s";
            }elseif(is_int($q)){
                $type .= "i";
            }
        }
        array_unshift($arr, $type);
        return $arr;
    }
    
    static function runQuery($query, $data){
        $db = DbHandler::makeConnection($data);
        //$res    = $db->prepare("SELECT * FROM tb WHERE name=? AND age=?");
        $res    = $db->prepare($query); 
        $crud = substr($query, 0, 6);
        $refA = array();
        switch($crud){
            case "INSERT":
                $arr = DbHandler::makeRefArr($data["val"]);
                break;
            case "SELECT":
                if(DbHandler::checkkeys("qcol", $data)){
                    $arr = DbHandler::makeRefArr($data["qval"]);
                }else{
                    $query .= " WHERE ID=?";
                    $ref    = new ReflectionClass('mysqli_stmt');
                    $res->execute();
                    $assoc = array();
                    if($res){
                        $data = array();
                        $dataarr = $res->get_result();
                        while($row = $dataarr->fetch_assoc()){
                            array_push($data, $row);
                        }
                        $assoc = array('0' => 'output', '1' => 'success',  '2' => 'values have been selected', '3' => $data);
                    }else{
                        $assoc = array('0' => 'output', '1' => 'error', '2' => 'sql operation was not carried out');
                    }
                    return $assoc;
                    exit();
                }
                break;
            case "UPDATE":
                $arr = DbHandler::makeRefArr(array_merge($data["val"], $data["qval"]));
                break;
            case "DELETE":
                $arr = DbHandler::makeRefArr($data["qval"]);
                break;
        }

        foreach($arr as $y){
            array_push($refA, DbHandler::makeref($y));
        }
        //$refArr = array("si",makeref($_POST["name"]),makeref($_POST["age"]));
        $ref    = new ReflectionClass('mysqli_stmt');
        $method = $ref->getMethod("bind_param");
        $method->invokeArgs($res,$refA);
        $res->execute();
        $assoc = array();
        if($res){
            switch($crud){
                case "INSERT":
                    $assoc = array('0' => 'output', '1' => 'success', '2' => 'values have been inserted');
                    break;
                case "SELECT":
                    $data = array();
                    $dataarr = $res->get_result();
                    while($row = $dataarr->fetch_assoc()){
                        array_push($data, $row);
                    }
                    if(!empty($data)){
                        $assoc = array('0' => 'output', '1' => 'success',  '2' => 'values have been selected', '3' => $data);
                    }else{
                        $assoc = array('0' => 'output', '1' => 'empty',  '2' => 'values where not found', '3' => $data);
                    }
                    break;
                case "UPDATE":
                    $assoc = array('0' => 'output', '1' => 'success',  '2' => 'values have been updated');
                    break;
                case "DELETE":
                    $assoc = array('0' => 'output', '1' => 'success',  '2' => 'values have been deleted');
                    break;
            }
        }else{
            $assoc = array('0' => 'output', '1' => 'error', '2' => 'sql operation was not carried out');
        }
        return $assoc;
        
    }
    
    static function select_cmd($data = array()){
        if(is_array($data)){ //data is an array
            
            //make connection with sql database
            
            $adjdata = array();
            $query = "SELECT";
            $adjdata = DbHandler::checkkeys('table', $data);
            if($adjdata){ //table keyword was used
                $mdata = DbHandler::checkkeys('col', $data);
                if($mdata){//col keyword was used
                    $adjdata = $mdata;
                        for($col = 0; $col < count($data['col']); $col++ ){
                            if($col == 0){
                                $query .= " {$data['col'][$col]}";
                            }else{
                                $query .= ", {$data['col'][$col]}";
                            }
                            
                        }//fill column names into query
                }else{//col keyword was not used
                        $query .= " *";
                }
                $query .= " FROM {$data['table']} ";
            }else{//table keyword does not exist
                
            }
            
            $mdata = DbHandler::checkkeys("qcol", $data);
            if($mdata){//where columns exist
                $adjdata = $mdata;
                $adjdata = DbHandler::checkkeys("cond", $adjdata);
                if($adjdata){//where conditions exist
                    $query.= "WHERE ";
                    $wcol = $adjdata["qcol"];
                    $wcon = $adjdata["cond"];
                
                    $query.= "{$wcol[0]} {$wcon[0]} ? ";
                    
                    $mdata = DbHandler::checkkeys("conj", $adjdata);
                    $wcoj = $mdata["conj"];
                    if($wcoj){//if where conjunction adjust where conjuction array
                        for($col = 1; $col < count($wcol); $col++){
                            $query.= "{$wcoj[$col - 1]} {$wcol[$col]} {$wcon[$col]} ? ";
                           
                        }
                        $adjdata = $mdata;
                    }
                }
            }else{//no where columns or conditions
                        
            }

            //echo $query;
            if($adjdata){
            return DbHandler::runQuery($query, $adjdata);
            }
            /*$assoc = array('0' => 'error', '1' => $query);
            return $assoc;*/
                        //DbHandler::getArrayCol($con,$data['table']);
                        //return DbHandler::runQuery($con,$query, $data['table']);
            
        }else{//data is not an array

        }
    }
    static function update_cmd($data = array()){
        if(is_array($data)){
            
            $adjdata = array();
            $con = DbHandler::makeConnection($data);

            if(DbHandler::checkkeys('table', $data)){ //table keyword was used
                $query = "UPDATE {$data['table']} SET ";
            
                if(DbHandler::checkkeys('col', $data)){//col keyword was used

                    $adjdata = DbHandler::checkkeys("val", $data);
                    if($adjdata){//f where value adjustments return true
                    
                        $adjdata = DbHandler::checkkeys("qcol", $adjdata);
                        if($adjdata){//if where column adjustments return true
                            
                            $condno = count($adjdata['cond']);

                            $adjdata = DbHandler::checkkeys("cond", $adjdata);
                            if($adjdata){//if where condition adjustments return true
                            
                                $columns = $adjdata['col'];
                                $values = $adjdata['val'];
                                $wval = $adjdata['qval'];
                                $wcol = $adjdata['qcol'];
                                $wcon = $adjdata['cond'];
                                
                                if($condno == 1){
                                    foreach($columns as $colmn){
                                        array_unshift($wcon, "=");
                                    }
                                }
                                
                                $query.= $columns[0] . " " . array_shift($wcon) . " ?";
                                for($col = 1; $col < count($columns); $col++){
                                    $query.= ", {$columns[$col]} " . array_shift($wcon) . " ?";
                                }
                            
                                $query .= " WHERE (";
                                $query.= "{$wcol[0]} {$wcon[0]} ?";
                                
                                $mdata = DbHandler::checkkeys("conj", $adjdata);
                                $wcoj = $mdata["conj"];
                                if($wcoj){//if where conjunction is an array
                                    for($col = 1; $col < count($wcol); $col++){
                                        $query.= " {$wcoj[$col-1]} {$wcol[$col]} {$wcon[$col]} ?";
                                    }
                                    $adjdata = $mdata;
                                }
                                $query .= ");";
                                //echo $query;
                                return DbHandler::runQuery($query, $adjdata);
                            }
                        }
                    
                    }
                
                }
                    //return DbHandler::runInputQuery($con,$query);
            }else{

            }
        }else{
                //return DbHandler::runQuery($con,$query);
        }
    }
    static function insert_cmd($data = array()){
        if(is_array($data)){

            $adjdata = array();
            $con = DbHandler::makeConnection($data);

            if(DbHandler::checkkeys('table', $data)){ //table keyword was used
                $query = "INSERT INTO {$data['table']} ";

                if(DbHandler::checkkeys('col', $data)){//col keyword was used

                    $adjdata = DbHandler::checkkeys("val", $data);
                    if($adjdata){//f where value adjustments return true
                                
                        $columns = $adjdata['col'];
                                $values = $adjdata['val'];

                        $query.= "({$columns[0]}" ;

                        
                        for($num = 1; $num < count($columns); $num++){
                            $query.= ", {$columns[$num]}";
                        }
                          
                        $query.= ") VALUES (?" ;
                        
                        for($nu = 1; $nu < count($values); $nu++){
                            $query.= ", ?";
                        }
                        
                        $query.= ")" ;
                        //echo $query;
                        return DbHandler::runQuery($query, $adjdata);
                    }
                }

            }
        }
    }
    static function delete_cmd($data = array()){
        if(is_array($data)){

            $adjdata = array();
            $con = DbHandler::makeConnection($data);

            if(DbHandler::checkkeys('table', $data)){ //table keyword was used
                $query = "DELETE FROM {$data['table']} ";

                $adjdata = DbHandler::checkkeys('qcol', $data);
                if($adjdata){//col keyword was used$adjdata = DbHandler::checkkeys('qcol', $data);
                    $adjdata = DbHandler::checkkeys('cond', $adjdata);
                    if($adjdata){//col keyword was used
                    
                    $wcol = $adjdata['qcol'];
                    $wval = $adjdata['qval'];
                    $wcon = $adjdata['cond'];
                        
                        $query .= "WHERE {$wcol[0]} {$wcon[0]} ?";

                        $mdata = DbHandler::checkkeys("conj", $adjdata);
                        if($mdata){//if where value adjustments return true
                        
                            $wcoj = $mdata['conj'];
                        
                            for($num = 1; $num < count($wcol); $num++){
                                $query.= " {$wcoj[$num - 1]} {$wcol[$num]} {$wcon[$num]} ?";
                            }
                            $adjdata = $mdata;
                        }
                        //echo $query;
                        return DbHandler::runQuery($query, $adjdata);
                    }
                }
            }
    }
}
    
}

?>
