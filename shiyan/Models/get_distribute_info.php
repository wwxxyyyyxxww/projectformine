<?php
require_once '../classLibrary/mysqlConnect.php';
$db = mysqlConnect::Connect();
$order_serial_number=$_POST['order_serial_number'];
$sql = "select order_serial_number,material_name,product_name,material_number,leave_number from to_be_distribute where order_serial_number='$order_serial_number'";
$result1 = $db->query($sql);
$result = $result1->fetchAll(PDO::FETCH_BOTH);
$arr = array();
$i = 0;
foreach ($result as $res) {

    for ($j = 0; $j < 5; $j++) {
        $arr[$i] = $res[$j];
        $i++;
    }
}
echo json_encode($arr);