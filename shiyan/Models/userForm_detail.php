<?php
require_once "../classLibrary/mysqlConnect.php";
require_once '../classLibrary/back_detail_handle.php';;
$db=mysqlConnect::Connect();
$staff_name= $_POST["staff_name"];
//$type = $_POST["type"];
//查询所选择的详细信息，建立一个空的数组，把数据库查询出的数据一条一条的放在数组中，
$sql = "select staff_id,staff_name,staff_password,level from stock_staff where`staff_name` = '" . $staff_name . "' ";
detailHandle::Handle($db, $sql, 4);

