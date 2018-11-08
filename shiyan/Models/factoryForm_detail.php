<?php
require_once "../classLibrary/mysqlConnect.php";
require_once '../classLibrary/back_detail_handle.php';;
$db=mysqlConnect::Connect();
$finished_factory_name= $_POST["finished_factory_name"];
$type = $_POST["type"];
//查询所选择的详细信息，建立一个空的数组，把数据库查询出的数据一条一条的放在数组中，
$sql = "select factory_id,finished_factory_name,factory_responsable_name,factory_tel,finished_factory_address from process_factory where`finished_factory_name` = '" . $finished_factory_name . "' ";
detailHandle::Handle($db, $sql, 5);



