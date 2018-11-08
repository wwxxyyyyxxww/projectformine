
<?php

header("Content-Type: text/html;charset=utf-8");
require_once "../classLibrary/mysqlConnect.php";
$db = mysqlConnect::Connect();
//批次订单
$order_serial_number = $_POST['order_serial_number'];
//所有同一批次订单
$all_order_serial_number = substr($_POST["order_serial_number"], 0, -1);
$date = date("Ymd");
$num = $db->query("select count(*) from work where order_serial_number like '%" . $order_serial_number . "%'");

$product_name = $_POST['product_name'];
$finish_number = $_POST['finish_number'];
try {
    $result = $db->query("UPDATE `work` SET `completion_status` = '1'  WHERE  `order_serial_number` = '$order_serial_number'");
    if ($result) {
        //插入实时库存表
//        $result2 = $db->query("insert into real_time_table values(null,'$product_name','$finish_number','$order_serial_number','yes')");
//        if ($result2) {
            $finish = $db->query("select count(*) from work where completion_status = '0'");
            $finish = $finish->fetch(PDO::FETCH_NUM);
            if ($finish[0] == 0) {

                $num = $db->query("select count(*) from `work` where order_serial_number like '%" . $all_order_serial_number . "%'");
                $num = $num->fetch(PDO::FETCH_NUM);
                $product = $db->query("select expect_number from `work` where order_serial_number like '%" . $all_order_serial_number . "%'");
                $result = $product->fetchAll(PDO::FETCH_NUM);
                $arr = array();
                $i = -1;
                $sum = 0;
                for ($j = 0; $j < $num[0]; $j++) {
                    $i++;
                    $arr[$i] = $result[$j][0];
                    $sum = $sum + $arr[$i];
                }
//            echo $sum;
//            print_r($arr);
                    $res = $db->query("insert into producted values(NULL,'$all_order_serial_number','$product_name','$sum','$date')");
                if ($res) {
//                    $db->query("DELETE FROM `work` where order_serial_number like '%" . $all_order_serial_number . "%'");
//                    $db->query("DELETE FROM `customer_company_order` where order_serial_number =" . $all_order_serial_number);
//                    $db->query("DELETE FROM `to_be_distribute` where order_serial_number =" . $all_order_serial_number);
                    $db->query("update customer_company_order set status_code = 1 where order_serial_number = '$all_order_serial_number'");
                    
                } else {
                    echo 0;
                }
            }
            echo 1;
//        }
//    } else {
//        echo 2;
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
?>