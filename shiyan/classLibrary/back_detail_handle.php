<?php
//详情操作类
class detailHandle {

    public static function Handle($db, $sql, $length) {
        try {
            $stmt = $db->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_BOTH);
            $arr = array();
            $i = 0;
            foreach ($result as $res) {
                for ($j = 0; $j < $length; $j++) {
                    $arr[$i] = $res[$j];
                    $i++;
                }
            }
//    将查询出来的结果数组放到一个数组中,json_encode传回js
            $a = array('error' => 0, 'info' => '查询成功!', "data" => $arr);
            echo json_encode($a);
        } catch (Exception $e) {
            echo json_encode(['error' => 1, 'info' => '查询失败!' . $e]);
        }
    }

}
