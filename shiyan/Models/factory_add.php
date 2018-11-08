<?php

session_start();
header("Content-Type: text/html;charset=utf-8"); //转为utf-8编码
require_once "../classLibrary/mysqlConnect.php";
require_once '../classLibrary/log_handle.php';
require_once '../classLibrary/back_add_handle.php';
$db = mysqlConnect::Connect();
//把js的变量获取过来
$finished_factory_name = $_POST['finished_factory_name'];
$factory_responsable_name = $_POST['factory_responsable_name'];
$factory_tel = $_POST['factory_tel'];
$finished_factory_address = $_POST['finished_factory_address'];
//判断加工厂名称是否重复
 $sql = "select * from process_factory where finished_factory_name='$finished_factory_name'";
 $sql1="INSERT INTO process_factory(finished_factory_name,factory_responsable_name,factory_tel,finished_factory_address)"
         . "VALUES ('$finished_factory_name','$factory_responsable_name','$factory_tel','$finished_factory_address')";
 addHandle::Handle($db, $sql, $sql1,"添加加工厂：",$finished_factory_name);
   
