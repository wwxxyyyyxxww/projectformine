<?php

session_start();
header("Content-Type: text/html;charset=utf-8"); //转为utf-8编码
require_once "../classLibrary/mysqlConnect.php";
require_once '../classLibrary/log_handle.php';
$db = mysqlConnect::Connect();
date_default_timezone_set('Asia/Shanghai');
$date = date("YmdHis");
$sql = "select count(*) from customer_company_order";
$stmt = $db->query($sql);
$result = $stmt->fetch(PDO::FETCH_BOTH);

$order_id = $result[0];
$order_serial_number = $date;
$material_name = $_POST['material_name'];
$material_number = $_POST['material_number'];
$product_name = $_POST['product_name'];
$select_name = $_POST['select_name'];
$responsable_name = $_POST['responsable_name'];
$responsable_tel = $_POST['responsable_tel'];
$end_time = htmlspecialchars($_POST['end_time']);
$dead_time = htmlspecialchars($_POST['dead_time']);
$status_code = 0;
$order_note = $_POST['order_note'];
$time = date("Y-m-d");

try {
    //检测订单编号是否重复
    $sql = "select * from customer_company_order where order_serial_number=:order_serial_number";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':order_serial_number', $order_serial_number);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($result) {
        echo 0;  //该账户已存在  
    } else {

        //使用预处理SQL并绑定参数
        //将订单信息插入到数据库中
        $stmt = $db->prepare("INSERT INTO customer_company_order(order_id,order_serial_number,material_name,material_number,product_name,company_name,responsable_name,responsable_tel,end_time,dead_time,status_code,note)
    VALUES (:order_id,:order_serial_number,:material_name,:material_number,:product_name,:select_name,:responsable_name,:responsable_tel,'" . $end_time . "','" . $dead_time . "',:status_code,:order_note)");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':order_serial_number', $order_serial_number);
        $stmt->bindParam(':material_name', $material_name);
        $stmt->bindParam(':material_number', $material_number);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':select_name', $select_name);
        $stmt->bindParam(':responsable_name', $responsable_name);
        $stmt->bindParam(':responsable_tel', $responsable_tel);
        $stmt->bindParam(':status_code', $status_code);
        $stmt->bindParam(':order_note', $order_note);
        // $stmt->bindParam(':addtime',$addtime);  //第二个参数只能是一个变量，不能直接写date("Y-m-d")
        $num = $stmt->execute();

        if ($num > 0) {
            //在新建订单成功的同时将此操作插入到日志表中去
    
            log_handle::log_add($db,"新增订单：", $order_serial_number);
            

            //在新建订单成功时将订单的信息插入到库存表中
            $result = $db->query("select material_name from stock_table WHERE binary material_name='$material_name'");
            $result = $result->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                //在库存表中增加这个原料、成品及数量，如果表中不存在则直接插入
                $db->query("INSERT INTO stock_table VALUES (NULL,'$material_name', '$material_number')");
                $db->query("INSERT INTO stock_table VALUES (NULL,'$product_name', '0')");
//                $db->query("INSERT INTO real_time VALUES (NULL,'$material_name', '0', '0', '$time')");
//                $db->query("INSERT INTO stock_table VALUES (NULL,'$product_name', '0', '0', '$time')");

            } else {
                //如果库存表中存在则只更改数量
                $result1 = $db->query("select number from stock_table where material_name='$material_name'");
                $result1 = $result1->fetchAll(PDO::FETCH_ASSOC);
                $number_add = $result1[0]['number'] + $material_number;
                $db->query("UPDATE stock_table SET number = '$number_add' WHERE material_name='$material_name'");
            }

            //插入实时库存表
            $insertRealRable = "insert into real_time_table values(NULL,'$material_name','$material_number','$order_serial_number','yesMaterialin')";
            $db->query($insertRealRable);
            
            //在新建订单成功时将订单的信息插入到待分配表中
            $db->query("INSERT INTO to_be_distribute VALUES('$order_serial_number','$material_name','$product_name','$material_number','$material_number')");


            echo 1;
        }  //数据库操作成功
        else {
            echo 3;
        }  //数据库操作失败
    }

    $db = null;
} catch (PDOException $e) {
    die("Error!: " . $e->getMessage() . "<br/>");
    echo 2;
}