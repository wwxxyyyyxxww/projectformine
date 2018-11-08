<?php
session_start();
header("Content-Type: text/html;charset=utf-8"); //转为utf-8编码
require_once "../classLibrary/mysqlConnect.php";
//导入日志函数
require_once '../classLibrary/back_add_handle.php';
require_once '../classLibrary/log_handle.php';
$db = mysqlConnect::Connect();
//把js的代码获取到后端

$company_name = $_POST['company_name'];
$company_tel = $_POST['company_tel'];
$company_address = $_POST['company_address'];
//判断公司名称是否重复
$sql = "select * from customer_company_information where company_name='$company_name'";
$sql1 = "INSERT INTO customer_company_information(company_name,company_tel,company_address)VALUES ('$company_name','$company_tel','$company_address')";
//执行添加类中的函数
addHandle::Handle($db, $sql, $sql1,"添加客户：",$company_name);
