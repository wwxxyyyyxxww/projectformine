<?php

header("Content-Type: text/html;charset=utf-8"); //转为utf-8编码
require_once "../classLibrary/mysqlConnect.php";
$db = mysqlConnect::Connect();

$name = $_POST["name"];
//echo $name;
$num = $_POST["num"];
//echo $num;
$difnum = $_POST["difnum"];
//echo $difnum;
$time = date("Ymd");
try {
    if ($difnum >0) {

        $sql1 = "UPDATE `stock_table` SET `number` = '$num' WHERE `material_name` = '$name'";
        $db->query($sql1);
        $sql2 = "insert into `real_time_table` values(NULL,'$name','$difnum','$time','yes')";
        $db->query($sql2);
        echo 1;
    } else if ($difnum < 0) {
        $difnum = -$difnum;
        $sql1 = "UPDATE `stock_table` SET `number` = '$num' WHERE `material_name` = '$name'";
        $db->query($sql1);
        $sql2 = "insert into `real_time_table` values(NULL,'$name','$difnum','$time','no')";
        $db->query($sql2);
        echo 2;
    }
} catch (Exception $e) {
    die($e);
}