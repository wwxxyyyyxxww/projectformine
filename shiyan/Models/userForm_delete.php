<?php
session_start();
require_once "../classLibrary/mysqlConnect.php";
//导入日志类和数据操作类
require_once '../classLibrary/log_handle.php';
require_once '../classLibrary/back_data_base.php';
$db=mysqlConnect::Connect();
//从JS获取数据
$staff_name = $_POST["staff_name"];
//数据库删除语句
 $sql = "delete from stock_staff where `staff_name` = '" . $staff_name . "'";
  //进行数据库操作和日志表的插入
dataBase::execute($db,$sql,"删除用户:",$staff_name);