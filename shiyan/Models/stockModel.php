<?php

require_once '../classLibrary/mysqlConnect.php';
//导入数据处理类
require_once '../classLibrary/back_query_handle.php';
$db = mysqlConnect::Connect();
$num_index = $_POST["num_index"];
$inputValue = $_POST["input"];

try {
    //加载全部内容
    if ($inputValue == "") {
        $sql = "select count(*) from stock_table";
        $sql2 = "select material_name,number from stock_table limit " . $num_index . ",6";
    } else {
//        $num_index=0;
////        $num_index=1;
        $sql = "select count(*) from stock_table where material_name like '%". $inputValue ."%' order by id desc limit " . $num_index . ",6";
        $sql2 = "select material_name,number from stock_table where material_name like '%". $inputValue ."%' order by id desc limit " . $num_index . ",6";
    }

//传值获取当前所查询内容的条数,
    //如果大于等于前端页面的行数，就搜索接受由当前页面的页数开始向后六行的数据,
    //如果小于前端页面的行数，就搜索所有内容;

    //调用处理类进行查询处理
    queryHandle::Handle($db, $sql, $sql2, 2);
} catch (Exception $e) {
    die($e);
}

$db = null;
