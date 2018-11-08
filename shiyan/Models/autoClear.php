<?php

require_once '../classLibrary/mysqlConnect.php';
$db = mysqlConnect::Connect();
$year = date("Y");
//echo $time;
$prev = date("m", mktime(0, 0, 0, date("m", time()) - 1, date("d", time()), date("Y", time())));
//echo $prev;
$pprev = date("m", mktime(0, 0, 0, date("m", time()) - 2, date("d", time()), date("Y", time())));
$selAll = $db->query("select material_name from stock_table");
$selAll = $selAll->fetchALL(PDO::FETCH_BOTH);
//echo $selAll[0][0];

$num1 = $db->query("select count(*) from stock_table");
$result1 = $num1->fetch(PDO::FETCH_NUM);
$arr = array();
$i = 0;
foreach ($selAll as $res) {

    for ($j = 0; $j < 1; $j++) {
        $arr[$i] = $res[$j];
        $i++;
    }
}
for ($i = 0; $i < sizeof($arr); $i++) {
    $num2 = $db->query("select sum(number) from real_time_table where YEAR(real_time_table.enter_time) =  '$year' and month(real_time_table.enter_time) = '$pprev' and name = '$arr[$i]' and first like '%in%'");
    $result2 = $num2->fetch(PDO::FETCH_NUM);
    $num3 = $db->query("select sum(number) from real_time_table where YEAR(real_time_table.enter_time) =  '$year' and month(real_time_table.enter_time) = '$prev' and name = '$arr[$i]' and first like '%in%'");
    $result3 = $num3->fetch(PDO::FETCH_NUM);
    if ($result2[0] == "") {
        $result2[0] = 0;
    }
    if ($result3[0] == "") {
        $result3[0] = 0;
    }
    $num4 = $db->query("select sum(number) from real_time_table where YEAR(real_time_table.enter_time) =  '$year' and month(real_time_table.enter_time) = '$pprev' and name = '$arr[$i]' and first like '%out%'");
    $result4 = $num4->fetch(PDO::FETCH_NUM);
    $num5 = $db->query("select sum(number) from real_time_table where YEAR(real_time_table.enter_time) =  '$year' and month(real_time_table.enter_time) = '$prev' and name = '$arr[$i]' and first like '%out%'");
    $result5 = $num5->fetch(PDO::FETCH_NUM);
    if ($result4[0] == "") {
        $result4[0] = 0;
    }
    if ($result5[0] == "") {
        $result5[0] = 0;
    }
    $arrayout[0] = $result2[0] + $result3[0];
    $arrayin[0] = $result4[0] + $result5[0];
    $name = "select material_name from `check` where time = '$year$prev' and material_name = '$arr[$i]'";
    $name = $db->query($name);
    $name = $name->fetch(PDO::FETCH_NUM);
//    echo $name[0];
    if (!empty($name[0])) {
        $update = $db->query("UPDATE `check` SET `insert_number` = '$arrayin[0]',`out_number` = '$arrayout[0]' where  `check`.`material_name` = '$arr[$i]' and time = '$year$prev'");
    } else {
        $insert = $db->query("insert into `check` values('$arr[$i]','$arrayin[0]','$arrayout[0]','$year$prev')");
//        echo $arr[$i];
    }
//    echo $result2[0]."<br>";
}
// $arraya[$i] = $result2[0];
// print_r($arraya);
//echo 1;
