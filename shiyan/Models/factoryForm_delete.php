<?php
session_start();
require_once "../classLibrary/mysqlConnect.php";
//导入日志类和数据操作类
require_once '../classLibrary/log_handle.php';
require_once '../classLibrary/back_data_base.php';
$db=mysqlConnect::Connect();
//从JS获取数据
$factory_name= $_POST["finished_factory_name"];
$type = $_POST["type"];
//数据库删除语句
 $sql = "delete from process_factory where `finished_factory_name` = '" . $factory_name . "'";
 //进行数据库操作和日志表的插入
 dataBase::execute($db,$sql,"删除加工厂:",$factory_name);
