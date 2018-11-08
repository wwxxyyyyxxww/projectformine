<?php
require_once "../classLibrary/mysqlConnect.php";
require_once '../classLibrary/back_detail_handle.php';;
$db=mysqlConnect::Connect();
$company_name= $_POST["company_name"];
$type = $_POST["type"];
//查询所选择的详细信息，建立一个空的数组，把数据库查询出的数据一条一条的放在数组中，
$sql = "select company_id,company_name,company_tel,company_address   from customer_company_information where`company_name` = '" . $company_name . "' ";
detailHandle::Handle($db, $sql, 4);

