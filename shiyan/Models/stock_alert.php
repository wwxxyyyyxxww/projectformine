<?php
session_start();
require_once "../classLibrary/mysqlConnect.php";
$db=mysqlConnect::Connect();
//导入日志类和操作类
require_once '../classLibrary/log_handle.php';
require_once '../classLibrary/back_data_base.php';
$name=$_POST['name'];
$number=$_POST['number'];

//查询语句
$sql="UPDATE `stock_table` SET `number` = '$number' WHERE `material_name` = '$name'";
 dataBase::execute($db,$sql,"修改库存:",$name);