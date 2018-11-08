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
//    if($inputValue == "") {
//        $sql = "select count(*) from customer_company_information";
//        $sql2 = "select company_id,company_name,company_tel,company_address from customer_company_information order by company_id desc limit " . $num_index . ",6";
//    }else{
    if ($type == "all") {
        $sql = "select count(*) from customer_company_information";
        $sql2 = "select company_id,company_name,company_tel,company_address from customer_company_information order by company_id desc limit " . $num_index . ",6";
    }
//查询公司名称名称
      else if ($type == "company_name") {
        $sql = "select count(*) from customer_company_information where 'company_name' ='" . $inputValue . "'";
        $sql2 = "select company_id,company_name,company_tel,company_address from customer_company_information where `company_name` like '%" . $inputValue . "%' order by company_id desc limit " . $num_index . ",6";
    }
//查询公司电话
     else if ($type == "company_tel") {
        $sql = "select count(*) from customer_company_information where 'company_tel' ='" . $inputValue . "'";
        $sql2 = "select company_id,company_name,company_tel,company_address from customer_company_information where `company_tel` like '%" . $inputValue . "%' order by company_id desc limit " . $num_index . ",6";
    }
    //查询公司地址
     else if ($type == "company_address") {
        $sql = "select count(*) from customer_company_information where 'company_address' ='" . $inputValue . "'";
        $sql2 = "select company_id,company_name,company_tel,company_address from customer_company_information where `company_address` like '%" . $inputValue . "%' order by company_id desc limit " . $num_index . ",6";
    }
//根据json传值获取当前所查询内容的条数,
    //如果大于等于前端页面的行数，就搜索接受由当前页面的页数开始向后六行的数据,
    //如果小于前端页面的行数，就搜索所有内容;
    //
    //调用处理类进行查询处理   
    queryHandle::Handle($db, $sql, $sql2, 4);
}catch (Exception $e) {
    die($e);
}
$db = null;
