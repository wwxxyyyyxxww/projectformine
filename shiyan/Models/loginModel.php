<?php

//开始session 通过session判断渲染登录界面还是主页
//     每个界面都加载侧边栏和顶部
class loginModel {

    public static function con() {
        //获取数据库链接
        global $db;
        //从数据库中查询数据
        if (!empty($_POST['userName'])) {
            $st = $db->prepare("select * from stock_staff");
            $st->execute();
            $res = $st->fetchAll(PDO::FETCH_ASSOC);
            //循环验证用户名和密码是否匹配
            foreach ($res as $r) {
                if ($r["staff_name"] == $_POST['userName']) {
                    if ($r['staff_password'] == $_POST['passWord']) {
//                    用户名密码匹配成功 则设置 $_SESSION['level']用来区分权限  设置 $_SESSION['state']用来判断加载主页面和登录页面
                        $_SESSION['level'] = $r['level'];
                        $_SESSION['state'] = "success";
                        $_SESSION['name'] = $r['staff_name'];
                        echo '<script>alert("登录成功");location.href="index.php"</script>';
                    }
                }
            }
            echo '<script>alert("登录失败，用户名或密码错误");location.href="index.php"</script>';
        }
    }

}

?>