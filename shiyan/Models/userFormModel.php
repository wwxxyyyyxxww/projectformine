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
   if ($inputValue == "") {
        $sql = "select count(*) from stock_staff";
        $sql2 = "select staff_id,staff_name,staff_password,level from stock_staff order by staff_id desc limit " . $num_index . ",6";
    }else{
    if ($type == "all") {
        $sql = "select count(*) from  stock_staff";
        $sql2 = "select staff_id,staff_name,staff_password,level from stock_staff order by staff_id desc limit " . $num_index . ",6";
    }
//查询用户名称 
    else if ($type == "staff_name") {
        $sql = "select count(*) from stock_staff where 'staff_name' ='" . $inputValue . "'";
        $sql2 = "select staff_id,staff_name,staff_password,level from stock_staff where `staff_name` like '%" . $inputValue . "%' order by staff_id desc limit " . $num_index . ",6";
    }
//查询用户密码
    else if ($type == "staff_password") {
        $sql = "select count(*) from stock_staff where 'staff_password' ='" . $inputValue . "'";
        $sql2 = "select staff_id,staff_name,staff_password,level from stock_staff where `staff_password` like '%" . $inputValue . "%' order by staff_id desc limit " . $num_index . ",6";
    }
//查询级别
    else if ($type == "level") {
        $sql = "select count(*) from stock_staff where 'level' ='" . $inputValue . "'";
        $sql2 = "select staff_id,staff_name,staff_password,level from stock_staff where `level` like '%" . $inputValue . "%' order by staff_id desc limit " . $num_index . ",6";
    }}
//根据json传值获取当前所查询内容的条数,
    //如果大于等于前端页面的行数，就搜索接受由当前页面的页数开始向后六行的数据,
    //如果小于前端页面的行数，就搜索所有内容;

    //调用处理类进行查询处理
 queryHandle::Handle($db,$sql, $sql2, 4);
} catch (Exception $e) {
    die($e);
}
$db = null;

