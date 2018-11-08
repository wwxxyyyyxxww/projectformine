<?php

header("Content-Type: text/html;charset=utf-8"); //转为utf-8编码
require_once "../classLibrary/mysqlConnect.php";
$db = mysqlConnect::Connect();
$all_order_serial_number = $_POST["order_serial_number"];
//在分配的时候给每个订单分配一个值用于区分批次
$order_serial_number = substr($_POST["order_serial_number"], 0, -1);
$num = $db->query("select count(*) from work where order_serial_number like '%" . $order_serial_number . "%'");
$result = $num->fetch(PDO::FETCH_BOTH);
$order_serial_number = $order_serial_number . $result[0];
$finished_factory_name = $_POST["finished_factory_name"];
$material_name = $_POST["material_name"];
$material_num = $_POST["material_num"];
$product_name = $_POST["product_name"];
$product_num = $_POST["product_num"];
$time = date("Y-m-d");

$sql1 = "INSERT INTO `work` (`process_id`, `order_serial_number`, `finished_factory_name`, `material_name`, `distribute_number`, `product_name`, `expect_number`, `finish_number`, `completion_status`) VALUES (null, '$order_serial_number', '$finished_factory_name','$material_name', '$material_num','$product_name', '$product_num', 0,0) ";
$res1 = $db->query($sql1);
$sql2 = "INSERT INTO `real_time_table`  VALUES (null,'$material_name', '$material_num', '$time', 'noMaterialout') ";
$res2 = $db->query($sql2);
$sql3 = "select number from stock_table where material_name ='$all_order_serial_number'";
$leavel_number = $db->query($sql3);
$leavel_number = $leavel_number->fetch(PDO::FETCH_BOTH);
$leavel_number = $leavel_number[0] - $material_num;
$sql4 = "UPDATE `stock_table` SET `number` = '$leavel_number' where material_name ='$material_name'";
$res=$db->query($sql4);
if ($res) {
    echo 1;
} else {
    echo 0;
}


