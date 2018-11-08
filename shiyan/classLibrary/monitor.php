<?php
//将每个操作的执行人 进行的具体操作插入数据库中
require_once 'classLibrary/mysqlConnect.php';
$db=mysqlConnect::Connect();
//监测类 记录函数
class monitor{
    public static function record($a){
        global $db;
        $dt = new DateTime();
        $time=$dt->format('Y-m-d H:i:s');
        $operationName=$_SESSION['name'];
        $operation=$a;
        $db->query("INSERT INTO `log` (`time`, `operationName`, `operation`) VALUES ('".$time."', '".$operationName."', '". $operation."') ");
    }
}
