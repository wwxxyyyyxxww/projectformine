<?php
session_start();
require_once "../classLibrary/mysqlConnect.php";
//导入日志函数
require_once '../classLibrary/log_handle.php';

$db = mysqlConnect::Connect();
$order_serial_number = $_POST["order_serial_number"];
$material_name = $_POST['material_name'];
$material_number = $_POST['material_number'];
$type = $_POST["type"];
if ($type == "delete") {
    try {
        //删除订单表中数据
        $sql = "delete from customer_company_order where `order_serial_number` = '" . $order_serial_number . "'";
         //删除实时库存表中数据
        $insertRealRable = "delete from real_time_table where enter_time='$order_serial_number'";
        //删除待分配表中数据
        $distribute="delete from to_be_distribute where order_serial_number='$order_serial_number'";

        //查询库存表中原料数量
        $result1 = $db->query("select number from stock_table where material_name='$material_name'");
        $result1 = $result1->fetchAll(PDO::FETCH_ASSOC);
        //判断库存表中的剩余数量够不够删除
        if ($result1[0]['number'] > $material_number) {
            $number_delete = $result1[0]['number'] - $material_number;
            $db->query("UPDATE stock_table SET number = '$number_delete' WHERE material_name='$material_name'");
            $db->query($sql);
             //准备在删除订单成功的同时将此操作插入到日志表中去
            log_handle::log_add($db,"删除订单：", $order_serial_number);
            $db->query($insertRealRable);
            $db->query($distribute);
            echo 1;
        } else if ($result1[0]['number'] == $material_number) {
            $db->query("delete from stock_table where material_name='$material_name'");
            $db->query($sql);
            //准备在删除订单成功的同时将此操作插入到日志表中去
            log_handle::log_add($db,"删除订单：", $order_serial_number);
            $db->query($insertRealRable);
             $db->query($distribute);
            echo 1;
        } else {
            echo 'lack';
        }
    } catch (Exception $e) {
        die($e);
    }
}