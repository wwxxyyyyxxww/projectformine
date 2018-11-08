<?php

header("Content-Type: text/html;charset=utf-8"); //转为utf-8编码
require_once "../classLibrary/mysqlConnect.php";
$db = mysqlConnect::Connect();
$year = date("Y");
$prev = date("m", mktime(0, 0, 0, date("m", time()) - 1, date("d", time()), date("Y", time())));
$num1 = $db->query("select count(material_name) from stock_table");
$result1 = $num1->fetch(PDO::FETCH_NUM);
$arr = array();
$i = 0;
$selAll = $db->query("select * from `check` where time = '$year$prev'");
$selAll = $selAll->fetchALL(PDO::FETCH_NUM);
foreach ($selAll as $res) {
        $arr[$i] = $res;
        $i++;
}
//print_r($arr);

$a = array("digit" => $result1[0], "info" => $arr);

echo json_encode($a);
