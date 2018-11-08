<?php

header("Content-Type: text/html;charset=utf-8");
require_once "../classLibrary/mysqlConnect.php";
$db = mysqlConnect::Connect();

$order_serial_number = $_POST['order_serial_number'];
$finished_factory_name = $_POST['finished_factory_name'];
$material_name = $_POST['material_name'];
$distribute_number = $_POST['distribute_number'];
$product_name = $_POST['product_name'];
$expect_number = $_POST['expect_number'];
$finish_number = $_POST['finish_number'];
$time = date("Y-m-d");
try {
    //查询加工表中实际数量
    $old_number = $db->query("select finish_number from work where `order_serial_number` = '$order_serial_number'");
    $old_number = $old_number->fetch(PDO::FETCH_NUM);
//    根据修改之后的信息修改数据库中的值
    $result = $db->query("UPDATE `work` SET `finished_factory_name` = '$finished_factory_name',`material_name` = '$material_name', `distribute_number` = '$distribute_number', `product_name` = '$product_name',`expect_number` = '$expect_number',`finish_number` = '$finish_number'  WHERE  `order_serial_number` = '$order_serial_number'");
    if ($result){
//        如果修改成功，查询库存表中相应成品名的数量
        $num = $db->query("select number from stock_table where `material_name` = '$product_name'");
        $num = $num->fetchAll(PDO::FETCH_NUM);
        if ($old_number[0] == "0") {
//            如果加工表中的实际数量为0，则直接修改库存表中的值
            $num = $finish_number + $num[0][0];
            $db->query("UPDATE `stock_table` SET number = '$num' WHERE  `material_name` = '$product_name'");
            $db->query("INSERT INTO `real_time_table`  VALUES (null,'$product_name', '$num', '$time', 'yesProductin')");
        } else {
            if ($old_number[0] < $finish_number) {
//                如果加工表中原有成品数量少于前端修改的实际数量，则将新添加的部分更改库存表的值
                $new_num = $finish_number - $old_number[0];
                $num = $new_num + $num[0][0];
                $db->query("UPDATE `stock_table` SET number = '$num' WHERE  `material_name` = '$product_name'");
                $db->query("INSERT INTO `real_time_table`  VALUES (null,'$product_name', '$new_num', '$time', 'yesProductin')");
                if($finish_number>$expect_number){
                    echo 3;
                }
            } else {
//                如果加工表中原有成品数量多于前端修改的实际数量，则将失去的部分更改库存表的值
                $new_num = $old_number[0] - $finish_number;
                $num = $num[0][0] - $new_num;
                $db->query("UPDATE `stock_table` SET number = '$num' WHERE  `material_name` = '$product_name'");
                $db->query("INSERT INTO `real_time_table`  VALUES (null,'$product_name', '$num', '$time', 'noProductout')");
            }
        }
        echo 1;
    } else {
        echo 2;
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

