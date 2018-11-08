<html>
    <head>
        <link rel = "stylesheet" href = "assets/css/head.css" />
        <link rel = "stylesheet" href = "assets/css/amazeui.min.css" />
        <link rel = "stylesheet" href = "assets/css/admin.css">
        <link rel = "stylesheet" href = "assets/css/factory.css">
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/amazeui.min.js"></script>
        <script src="assets/js/app.js"></script>
        <script type="text/javascript" src="assets/js/jquery-2.2.3.min.js"></script>
        <script src="assets/js/autoClear.js"></script>
        <script language="javascript" type="text/javascript" src="assets/js/My97DatePicker/WdatePicker.js"></script>
    </head>

    <body>
        <header id="header" class="header">SWY库存系统</header>
        <div id="leftMenu" class="leftMenu">
            <ul class="am-list admin-sidebar-list">
                <li><a  href="?" ><span class="am-icon-home"></span> 首页</a></li>
                <li><a href="?page=orderForm" ><span class="am-icon-plus">订单管理</span></a></li>
                <li><a href="?page=workView"  id="workView"><span class="am-icon-users"></span> 加工中</a></li>
                <?php
                if ($_SESSION['level'] == 2) {
                    echo<<< EOT
                     <li><a href="?page=companyView" id="companyView" ><span class="am-icon-table"></span>客户管理</a></li>
                     <li><a href="?page=factoryView" id="factoryView" ><span class="am-icon-pencil-square-o"></span>代加工厂管理</a></li>
                    <li><a href="?page=userView"  id="userView"><span class="am-icon-users"></span> 用户管理</a></li>
                    <li><a href="?page=stock" id="stock" ><span class="am-icon-star"></span> 库存管理</a></li>
                    <li><a href="?page=log" id="log"><span class="am-icon-gear"></span> 系统日志</a></li>
                    <li><a href="?page=closeView" onclick="close()"><span class="am-icon-power-off"></span> 注销</a></li>
                    </ul>
EOT;
                } else {
                    echo "</ul>";
                }
                ?>
                <script>
                    function close() {
                        if(confirm("您确定要退出吗？")) {
                            window.opener = null;
                            window.open('', '_self');
                            window.close();
                        } else {
                        }
                    }
                </script>
        </div>
        <div id="rightMenu" class="rightMenu">


