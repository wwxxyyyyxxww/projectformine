<?php
require_once '../classLibrary/mysqlConnect.php';
//导入操作类
require_once '../classLibrary/back_query_handle.php';
$db = mysqlConnect::Connect();
$num_index = $_POST["num_index"];
$type = $_POST["type"];
$inputValue = $_POST["input"];

try {
    //判断条件是否为空
    if ($inputValue == "") {
        $sql = "select count(*) from log";
        $sql2 = "select time,name,operation from log order by id desc limit " . $num_index . ",6";
    } else {
        //条件不为空则判断选择了那个搜索条件
        if ($type == "operate_time") {
//            查询此种类的数据一共多少条 用来进行分页
            $sql = "select count(*) from log where time='$inputValue'";
//            模糊查询数据
            $sql2 = "select time,name,operation from log where  time like '%$inputValue%' order by id desc limit " . $num_index . ",6";
        } else if ($type == "operate_user") {
            $sql = "select count(*) from log where name='$inputValue'";
            $sql2 = "select time,name,operation from log where name like  '%$inputValue%' order by id desc  limit " . $num_index . ",6";
        } else if ($type == "operate") {
            $sql = "select count(*) from log where operation='$inputValue'";
            $sql2 = "select time,name,operation from log where  operation like '%$inputValue%' order by id desc  limit " . $num_index . ",6";
        } else if ($type == "all") {
            $sql = "select count(*) from log";
            $sql2 = "select time,name,operation from log order by id desc limit " . $num_index . ",6";
        }
    }

//调用处理类进行查询处理
     queryHandle::Handle($db,$sql, $sql2, 3);
} catch (Exception $e) {
    die($e);
}

$db = null;

