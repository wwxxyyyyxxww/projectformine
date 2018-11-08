<?php

header("Content-Type: text/html;charset=utf-8"); //转为utf-8编码
require_once "../classLibrary/mysqlConnect.php";
$db = mysqlConnect::Connect();
$inputValue = $_POST["input"];
$num_index = $_POST["num_index"];
$selAll = $db->query("select material_name from stock_table where `material_name` like '%" . $inputValue . "%'  limit " . $num_index . ",6");
$selAll = $selAll->fetchALL(PDO::FETCH_BOTH);
//echo $selAll[0][0];
$num1 = $db->query("select count(material_name) from stock_table");
$result1 = $num1->fetch(PDO::FETCH_NUM);
$arr = array();
$i = 0;
foreach ($selAll as $res) {

    for ($j = 0; $j < 1; $j++) {
        $arr[$i] = $res[$j];
        $i++;
    }
}
//print_r($arr);
//本月
for ($i = 0; $i < sizeof($arr); $i++) {
    $num = $db->query("select number from stock_table   limit " . $num_index . ",6");
    $result = $num->fetchALL(PDO::FETCH_NUM);
    if ($result[0] == "") {
        $result[0] = "0";
    }
//    echo $result[1][0];
    $array[$i] = $result[$i][0];
//    echo $array[0];
}
$a = array("digit" => $result1[0], "currentNum" => $array, "materialName" => $arr);
echo json_encode($a);
