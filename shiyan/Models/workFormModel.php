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
        $sql = "select count(*) from work";
         $sql2 = "select * from work order by order_serial_number desc limit " . $num_index . ",6";
    }else{
    if ($type == "all") {
        $sql = "select count(*) from work";
        $sql2 = "select * from work order by order_serial_number desc limit " . $num_index . ",6";
    }
//查询订单编号
    else if ($type == "order_serial_number") {
        $sql = "select count(*) from work where 'order_serial_number' ='" . $inputValue . "'";
        $sql2 = "select * from work where `order_serial_number` like '%" . $inputValue . "%' order by order_serial_number desc limit " . $num_index . ",6";
    }
//查询产品名称 
    else if ($type == "finished_factory_name") {
        $sql = "select count(*) from work where finished_factory_name ='" . $inputValue . "'";
        $sql2 = "select * from work where `finished_factory_name` like '%" . $inputValue . "%' order by order_serial_number desc limit " . $num_index . ",6";
    }
//查询原材料名称
    else if ($type == "material_name") {
        $sql = "select count(*) from work where material_name ='" . $inputValue . "'";
        $sql2 = "select * from work where `material_name` like '%" . $inputValue . "%' order by order_serial_number desc limit " . $num_index . ",6";
    }
//查询状态码
    else if ($type == "product_name") {
        $sql = "select count(*) from work where product_name ='" . $inputValue . "'";
        $sql2 = "select * from work where `product_name` like '%" . $inputValue . "%' order by order_serial_number desc limit " . $num_index . ",6";
    } else if ($type == "completion_status") {
        $sql = "select count(*) from work where completion_status ='" . $inputValue . "'";
        $sql2 = "select * from work where `completion_status` like '%" . $inputValue . "%' order by order_serial_number desc limit " . $num_index . ",6";
    }
    }
//根据json传值获取当前所查询内容的条数,
    //如果大于等于前端页面的行数，就搜索接受由当前页面的页数开始向后六行的数据,
    //如果小于前端页面的行数，就搜索所有内容;

//调用处理类进行查询处理
    queryHandle::Handle($db, $sql, $sql2, 9);
} catch (Exception $e) {
    die($e);
}
$db = null;
