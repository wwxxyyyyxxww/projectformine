<?php
session_start();
header("Content-Type: text/html;charset=utf-8"); //转为utf-8编码
require_once "../classLibrary/mysqlConnect.php";
require_once '../classLibrary/log_handle.php';
require_once '../classLibrary/back_add_handle.php';
$db=mysqlConnect::Connect();
//把js的变量获取到后端
$material_name=$_POST['name'];
$number=$_POST['number'];

$sql = "select * from stock_table where material_name='$material_name'";
$sql1="INSERT INTO `stock_table` (`material_name`, `number`) VALUES ('$material_name', '$number')";
 addHandle::Handle($db, $sql, $sql1,"添加原料：",$material_name);



