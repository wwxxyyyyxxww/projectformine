<?php
session_start();
header("Content-Type: text/html;charset=utf-8");
//导入数据库连接和日志函数
require_once "../classLibrary/mysqlConnect.php";
require_once "../classLibrary/log_handle.php";
require_once "../classLibrary/back_data_base.php";
$db = mysqlConnect::Connect();
$company_serial_number = $_POST['company_serial_number'];
$company_name = $_POST['company_name'];
$company_tel = $_POST['company_tel'];
$company_address = $_POST['company_address'];

//编写查询语句
$sql="UPDATE `customer_company_information` SET `company_serial_number` = '$company_serial_number',`company_name` = '$company_name', `company_tel` = '$company_tel', `company_address` = '$company_address'  WHERE  `company_serial_number` = '$company_serial_number'";

//进行数据库操作和日志表的插入
dataBase::execute($db, $sql, "修改客户:", $company_name);
