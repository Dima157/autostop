<?php
class DB extends PDO {
    private static $host = '127.0.0.1',
                   $db = 'autostop',
                   $user = 'root',
                   $pass = '';
     private $pdo;
    static function PDO(){
        return new DB();
    }
    function __construct(){
        $connect = "mysql:host=".self::$host.";dbname=".self::$db;
        $this->pdo = new PDO($connect, self::$user, self::$pass);
    }

    function select($table, $param = null, $property = null){
        if(!empty($param) && isset($param) && !empty($property) && isset($property) && $param != null && $property != null){
            if(is_array($param) && is_array($property)){
                $str = "WHERE";
                for($i = 0; $i < count($param); $i++){
                    if($i != count($param) - 1){
                        $str .= " $param[$i]='$property[$i]' and";
                    }else{
                        $str .= " $param[$i]='$property[$i]'";
                    }
                }
                $query = "select*from $table $str";
                $res = $this->pdo->query($query);
                if($res){
                    $res = $res->fetchAll();
                    return $res;
                }
            }else{
                $query = "select*from $table WHERE $param='$property'";
                $res = $this->pdo->query($query);
                if($res){
                    $res = $res->fetchAll();
                    return $res;
                }
            }
        }
        $query = "select*from $table";
        $res = $this->pdo->query($query);
        if($res){
            $res = $res->fetchAll();
            return $res;
        }
        return false;
    }

    function insert($table, $param){
        $arrayKey = array_keys($param);
        $arrayVal = array_values($param);
        $arrayKey = implode(',', $arrayKey);
        $arrayVal = "'".implode("', '", $arrayVal)."'";
        $query = "insert into $table($arrayKey)values($arrayVal)";
        $this->pdo->query($query);
    }

    function selectLastElement($table, $nameId){
        $query = "select*from $table ORDER BY $nameId DESC LIMIT 1";
        $res = $this->pdo->query($query);
        if($res){
            return $res->fetchAll();
        }
        return false;
    }

    function update($table, $param, $idName, $id){
        $key = array_keys($param);
        $val = array_values($param);
        $str = '';
        for($i = 0; $i < count($key); $i++){
            if($i != count($key) - 1) {
                $str .= "$key='$val', ";
            }else{
                $str .= "$key='$val'";
            }
        }
        $query = "update $table SET $str WHERE $idName='$id'";
        $this->pdo->query($query);
    }

    function delete($table, $param, $property){
        $str = "WHERE ";
        if(is_array($param)) {
            for ($i = 0; $i < count($param); $i++) {
                if ($i != count($param) - 1) {
                    $str .= "$param[$i]='$property[$i]' and ";
                } else {
                    $str .= "$param[$i]='$property[$i]'";
                }
            }
        }else{
            $str .= "$param='$property'";
        }
        echo $str;
        $query = "delete from $table $str";
        $this->pdo->query($query);
    }

    function selectLimit($table ,$start, $limit){
        $query = "select*from $table LIMIT $start, $limit";
        $res = $this->pdo->query($query);
        if($res){
            return $res->fetchAll();
        }
        return false;
    }
}