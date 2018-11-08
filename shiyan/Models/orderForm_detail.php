<?php

require_once "../classLibrary/mysqlConnect.php";
require_once '../classLibrary/back_detail_handle.php';;
$db=mysqlConnect::Connect();
$order_serial_number = $_POST["order_serial_number"];
$type = $_POST["type"];
//查询所选择的详细信息，建立一个空的数组，把数据库查询出的数据一条一条的放在数组中，
$sql = "select order_serial_number,material_name,material_number,product_name,company_name,responsable_name,responsable_tel,end_time,dead_time,status_code,note from customer_company_order where`order_serial_number` = '" . $order_serial_number . "' ";
//执行详情操作类
detailHandle::Handle($db, $sql, 11);
