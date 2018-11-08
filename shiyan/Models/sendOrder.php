<?php

require_once '../classLibrary/mysqlConnect.php';
$db = mysqlConnect::Connect();
$date = date("Ymd");
$time = date("Y-m-d");
$order_serial_number = $_POST["order_serial_number"];
$product_name = $_POST["product_name"];
//echo $order_serial_number.$material_name.$material_num;
//将订单状态改为2，表示已发出
$sql = "UPDATE `customer_company_order` SET `status_code` = '2' WHERE  `order_serial_number` = '$order_serial_number'";
$db->query($sql);
//从库存表中查询现有的符合成品名称的数量
$sql1 = "select number from stock_table where material_name = '$product_name'";
$stock_product_num = $db->query($sql1);
$stock_product_num = $stock_product_num->fetch(PDO::FETCH_NUM);
//echo $stock_product_num[0];
//查询相同订单编号的订单数量
$num = $db->query("select count(*) from work where `order_serial_number` like '%$order_serial_number%'");
$num = $num->fetchAll(PDO::FETCH_NUM);
//print_r($num);
//从加工表中获取期望数量，在发送回可会订单的时候，从库存中减去相应的数量
$sql2 = "select expect_number from work where `order_serial_number` like '%$order_serial_number%'";
$finish_product_num = $db->query($sql2);
$result = $finish_product_num->fetchAll(PDO::FETCH_NUM);

//由于加工表中订单数量可能不唯一，所以要对所有同一订单的期望值求和
$arr = array();
$i = 0;
$sum = 0;
for ($j = 0; $j < $num[0][0]; $j++) {
    $i++;
    $arr[$i] = $result[$j][0];
    $sum = $sum + $arr[$i];
}
//echo $sum;
//print_r($finish_product_num);
//$finish_product_num = array_sum($finish_product_num);
//判断库存中数量是否大于所需期望数量，若大于则执行成功，否则失败
if ($stock_product_num[0] >= $sum) {
    $new_material_num = $stock_product_num[0] - $sum;
    $sql3 = "UPDATE `stock_table` SET `number` = '$new_material_num' WHERE  material_name = '$product_name'";
    $res = $db->query($sql3);
    $db->query("INSERT INTO `real_time_table`  VALUES (null,'$product_name', '$sum', '$time', 'yesProductout')");
    if ($res) {
        echo 1;
    }
}
//echo $stock_product_num[0] . "a" . $sum . "a" . $new_material_num;

//  echo $number;