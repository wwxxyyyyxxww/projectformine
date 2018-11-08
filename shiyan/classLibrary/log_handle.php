<?php
class log_handle{
    public static function log_add($db,$handle,$value){
        //将时间变为上海时间
           date_default_timezone_set('Asia/Shanghai');
            $time = date("Y-m-d H:i:s");
            $name = $_SESSION['name'];
            $operation = $handle.$value;
            $db->query("insert into log values(NULL,'$time','$name','$operation')");

    }
}