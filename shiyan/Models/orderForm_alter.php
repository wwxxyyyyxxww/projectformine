<?php
session_start();
header("Content-Type: text/html;charset=utf-8"); 
require_once "../classLibrary/mysqlConnect.php";
//导入日志类和操作类
require_once '../classLibrary/log_handle.php';
require_once '../classLibrary/back_data_base.php';
$db=mysqlConnect::Connect();


$order_serial_number = $_POST['order_serial_number'];
$material_name = $_POST['material_name'];
$material_number = $_POST['material_number'];
$product_name = $_POST['product_name'];
$select_name = $_POST['select_name'];
$responsable_name = $_POST['responsable_name'];
$responsable_tel = $_POST['responsable_tel'];
$end_time = htmlspecialchars($_POST['end_time']);
//htmlspecialchars($_POST['dead_time'])
$dead_time =htmlspecialchars($_POST['dead_time']);
//htmlspecialchars($_POST['order_note'])
 $status_code=$_POST['status_code'];
 $order_note=$_POST['order_note'];
 
 $sql="UPDATE `customer_company_order` SET `material_name` = '$material_name',`material_number` = '$material_number', `product_name` = '$product_name', `company_name` = '$select_name', `responsable_name` = '$responsable_name', `end_time` = '$end_time', `dead_time` = '$dead_time', `status_code` = '$status_code', `note` = '$order_note' WHERE  `order_serial_number` = '$order_serial_number'";
 //进行数据库操作和日志表的插入
 dataBase::execute($db,$sql,"修改订单:",$order_serial_number);