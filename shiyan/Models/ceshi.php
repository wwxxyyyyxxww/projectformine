<?php
require_once '../classLibrary/mysqlConnect.php';
$db=mysqlConnect::Connect();
            $material_name="FFFF";
            $material_number="222";
                     //新建成功则在新建订单的同时将订单的信息插入到库存表中
            $result = $db->query("select material_name from stock_table WHERE binary material_name='$material_name'");
            $result=$result->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                //在库存表中增加这个原料及数量，如果表中不存在则直接插入
                $db->query("INSERT INTO stock_table  VALUES ('$material_name', '$material_number')");
            } else {
                //如果库存表中存在则只更改数量
                $result1 = $db->query("select number from stock_table where material_name='$material_name'");
                $result1 = $result1->fetchAll(PDO::FETCH_ASSOC);
                $number_add = $result1[0]['number'] + $material_number;
                $db->query("UPDATE stock_table SET number = '$number_add' WHERE material_name='$material_name'");
            }
            
            