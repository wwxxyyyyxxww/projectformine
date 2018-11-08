<?php
session_start();
header("Content-Type: text/html;charset=utf-8"); 
require_once "../classLibrary/mysqlConnect.php";
//导入日志类和数据操作类
require_once '../classLibrary/log_handle.php';
require_once '../classLibrary/back_data_base.php';
$db=mysqlConnect::Connect();
//从JS获取数据
$staff_id= $_POST['staff_id'];
$staff_name = $_POST['staff_name'];
$staff_password = $_POST['staff_password'];
$level = $_POST['level'];
//要执行的sql语句
$sql="UPDATE `stock_staff` SET`staff_name` = '$staff_name', `staff_password` = '$staff_password', `level` = '$level'  WHERE  `staff_id` = '$staff_id'";
 //进行数据库操作和日志表的插入
 dataBase::execute($db,$sql,"修改用户:",$staff_name);