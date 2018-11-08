<?php
//添加操作的类
class addHandle {

    public static function Handle($db, $sql, $sql1,$logHandleName,$company_name) {
        try {
            $stmt = $db->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                echo 0;
            } else {
                $result1 = $db->query($sql1);
                if ($result1) {
                    echo 1;
                    log_handle::log_add($db, $logHandleName, $company_name);
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
    }

}