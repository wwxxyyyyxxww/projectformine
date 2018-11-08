<?php

class queryHandle {

    public static function Handle($db,$sql,$sql2,$length) {
        $stmt = $db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_BOTH);
        $stmt2 = $db->query($sql2);
        $result2 = $stmt2->fetchAll(PDO::FETCH_BOTH);
        $arr = array();
        $i = 0;
        foreach ($result2 as $res) {
            for ($j = 0; $j < $length; $j++) {
                $arr[$i] = $res[$j];
                $i++;
            }
        }
//    将查询出来的行数以及结果数组放到一个数组中,json_encode传回js
        $a = array("digit" => $result[0], "outputArrays" => $arr);
        echo json_encode($a);
}}
    