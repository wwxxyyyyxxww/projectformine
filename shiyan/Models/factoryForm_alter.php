<?php

session_start();
header("Content-Type: text/html;charset=utf-8");
require_once "../classLibrary/mysqlConnect.php";
//导入日志类和操作类
require_once '../classLibrary/log_handle.php';
require_once '../classLibrary/back_data_base.php';
$db = mysqlConnect::Connect();
//获取JS传过来的数据
$finished_factory_id = $_POST['finished_factory_id'];
$finished_factory_name = $_POST['finished_factory_name'];
$factory_responsable_name = $_POST['factory_responsable_name'];
$factory_tel = $_POST['factory_tel'];
$finished_factory_address = $_POST['finished_factory_address'];
//编写查询语句
$sql = "UPDATE `process_factory` SET `finished_factory_name` = '$finished_factory_name',`factory_responsable_name` = '$factory_responsable_name',`factory_tel` = '$factory_tel ', `finished_factory_address` = '$finished_factory_address'  WHERE  `factory_id` = '$finished_factory_id'";
//进行数据库操作和日志表的插入
dataBase::execute($db, $sql, "修改加工厂:", $finished_factory_name);
