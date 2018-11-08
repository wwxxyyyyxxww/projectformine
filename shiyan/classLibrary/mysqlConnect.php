<?php
header("Content-Type: text/html;charset=utf-8");
//Connect类为数据库连接类
class mysqlConnect{

   public static function Connect() {
    $user="root";
    $pwd="";
    $host="localhost";
    $protocol="mysql";
    $dbname="stocksystem";
    
    try{$db=new PDO("$protocol://host=$host;dbname=$dbname",$user,$pwd);
     //设置PDO错误模式为异常
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e){
    echo $e->getMessage();}
    
    $db->exec("set names utf8");
    
//    echo '数据库连接成功';
    return $db;
}
} 
