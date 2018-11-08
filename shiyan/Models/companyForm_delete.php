<?php
session_start();
//导入数据库连接
require_once "../classLibrary/mysqlConnect.php";
//导入日志类和数据操作类
require_once '../classLibrary/log_handle.php';
require_once '../classLibrary/back_data_base.php';
//从JS获取数据
$db=mysqlConnect::Connect();
$company_serial_number = $_POST["company_serial_number"];
$company_name=$_POST['company_name'];
//删除语句
$sql = "delete from customer_company_information where `company_serial_number` = '" . $company_serial_number . "'";
//进行数据库操作和日志表的插入
 dataBase::execute($db,$sql,"删除客户:",$company_name);