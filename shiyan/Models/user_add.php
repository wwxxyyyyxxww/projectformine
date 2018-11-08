<?php
session_start();
header("Content-Type: text/html;charset=utf-8"); //转为utf-8编码
require_once "../classLibrary/mysqlConnect.php";
require_once '../classLibrary/log_handle.php';
require_once '../classLibrary/back_add_handle.php';
//把js的变量获取到后端
$db = mysqlConnect::Connect();
$staff_name = $_POST['staff_name'];
$staff_password = $_POST['staff_password'];
$level = $_POST['level'];
//检测用户名是否存在，否则插入信息
 $sql = "select * from stock_staff where staff_name='$staff_name'";
 $sql1="INSERT INTO stock_staff(staff_name,staff_password,level) VALUES ('$staff_name','$staff_password','$level')";
 addHandle::Handle($db, $sql, $sql1,"添加用户：",$staff_name);
   
