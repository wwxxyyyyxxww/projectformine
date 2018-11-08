<?php

require_once '../classLibrary/mysqlConnect.php';
$db = mysqlConnect::Connect();
$distribute_order_serial_number = $_POST["distribute_order_serial_number"];
$select_name1 = $_POST['select_name1'];
$num = $_POST["num"];
$time = date("Y-m-d");
//echo $select_name1[1];
//对传来的数组求和
$input_num = $_POST['input_num'];
$input_num_sum = array_sum($input_num);

$expect_num = $_POST['expect_num'];
$distribute_meterial_name = $_POST["distribute_meterial_name"];
$distribute_product_name = $_POST["distribute_product_name"];
//print_r($expect_num);
for ($i = 0; $i < $num; $i++) {
    $a = $distribute_order_serial_number . $i;
    $b = $select_name1[$i];
    $c = $input_num[$i];
    $d = $expect_num[$i];
    //将前端传来的数组拆分插入到加工表中
    $sql = "INSERT INTO `work` (`process_id`, `order_serial_number`, `finished_factory_name`, `material_name`, `distribute_number`, `product_name`, `expect_number`, `finish_number`, `completion_status`) VALUES (null, '$a', '$b','$distribute_meterial_name', '$c','$distribute_product_name', '$d', 0,0) ";
    $result = $db->query($sql);
}
//分配原料的时候同时将原料名，数量，时间插入到实时表中，以便月结
$db->query("INSERT INTO `real_time_table`  VALUES (null,'$distribute_meterial_name', '$input_num_sum', '$time', 'yesMaterialout')");
if ($result) {
//    查询待分配表剩余数量
    $sql2 = "select leave_number from to_be_distribute where order_serial_number ='$distribute_order_serial_number'";
    $leavel_number = $db->query($sql2);
    $leavel_number = $leavel_number->fetch(PDO::FETCH_BOTH);
    $leavel_number = $leavel_number[0] - $input_num_sum;
    if ($leavel_number >= 0) {
//        修改待分配表、库存表中相应的
        $sql3 = "UPDATE `to_be_distribute` SET `leave_number` = '$leavel_number' where order_serial_number ='$distribute_order_serial_number'";
        $db->query($sql3);
//        $sql4 = "UPDATE `real_time_table` SET `number` = '$leavel_number' where enter_time ='$distribute_order_serial_number'";
//        $db->query($sql4);
        $db->query("UPDATE `stock_table` SET `number` = '$leavel_number' where `material_name` ='$distribute_meterial_name'");
//        与sql4相对应，如果实时库存表相应订单编号的值为0，则将该记录从表中删除
//        if ($leavel_number == 0) {
//            $sql5 = "DELETE FROM `real_time_table` WHERE `enter_time` = '$distribute_order_serial_number'";
//            $db->query($sql5);
//        }
        echo 1;
    }
} else {
    echo 0;
}
?>
