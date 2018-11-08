<?php

class dataBase {
    public static function execute($db, $sql, $handle, $finished_factory_name) {
        try {
            $result = $db->query($sql);
            if ($result) {
                echo 1;
                log_handle::log_add($db, $handle, $finished_factory_name);
            } else {
                echo 2;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
