<?php

require_once '../classLibrary/mysqlConnect.php';
//导入数据处理类
require_once '../classLibrary/back_query_handle.php';
$db = mysqlConnect::Connect();
$num_index = $_POST["num_index"];
$type = $_POST["type"];
$inputValue = $_POST["input"];
try {
    //加载全部内容
    if($inputValue==""){
        $sql = "select count(*) from process_factory";
        $sql2 = "select factory_id,finished_factory_name,factory_responsable_name,factory_tel,finished_factory_address from process_factory order by factory_id desc limit " . $num_index . ",6";
    }else{
    if ($type == "all") {
        $sql = "select count(*) from process_factory";
        $sql2 = "select factory_id,finished_factory_name,factory_responsable_name,factory_tel,finished_factory_address from process_factory order by factory_id desc limit " . $num_index . ",6";
    }
//查询加工厂名称编号
    else if ($type == "finished_factory_name") {
        $sql = "select count(*) from process_factory where 'finished_factory_name' ='" . $inputValue . "'";
        $sql2 = "select factory_id,finished_factory_name,factory_responsable_name,factory_tel,finished_factory_address from process_factory where `finished_factory_name` like '%" . $inputValue . "%' order by factory_id desc limit " . $num_index . ",6";
    }
//查询加工厂负责人姓名名称 
    else if ($type == "factory_responsable_name") {
        $sql = "select count(*) from process_factory where 'factory_responsable_name' ='" . $inputValue . "'";
        $sql2 = "select factory_id,finished_factory_name,factory_responsable_name,factory_tel,finished_factory_address from process_factory where `factory_responsable_name` like '%" . $inputValue . "%' order by factory_id desc limit " . $num_index . ",6";
    }
//查询加工厂电话名称
    else if ($type == "factory_tel") {
        $sql = "select count(*) from process_factory where 'factory_tel' ='" . $inputValue . "'";
        $sql2 = "select factory_id,finished_factory_name,factory_responsable_name,factory_tel,finished_factory_address from process_factory where `factory_tel` like '%" . $inputValue . "%' order by factory_id desc limit " . $num_index . ",6";
    }
//查询加工厂地址
    else if ($type == "finished_factory_address") {
        $sql = "select count(*) from process_factory where 'finished_factory_address' ='" . $inputValue . "'";
        $sql2 = "select factory_id,finished_factory_name,factory_responsable_name,factory_tel,finished_factory_address from process_factory where `finished_factory_address` like '%" . $inputValue . "%' order by factory_id desc limit " . $num_index . ",6";
    }}
//根据json传值获取当前所查询内容的条数,
    //如果大于等于前端页面的行数，就搜索接受由当前页面的页数开始向后六行的数据,
    //如果小于前端页面的行数，就搜索所有内容;

    //调用处理类进行查询处理
    queryHandle::Handle($db, $sql, $sql2, 5);
} catch (Exception $e) {
    die($e);
}
$db = null;


