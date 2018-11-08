<!doctype html>
<?php require_once 'View/head.php'; ?>
<!--<div id="homepage" style="position: absolute;height: 100%;width: 100%;background-color: green;overflow: hidden" >-->
<div class="admin-content">
    <div class="admin-content-body">
        <ul class="am-avg-sm-1 am-avg-md-4 am-margin am-padding am-text-center admin-content-list">
            <li><span class="am-icon-btn am-icon-file-text"></span><br/>订单总数量<br/><input class="orderNumber  am-badge-secondary am-round am-text-default" disabled="disabled" value="" style="text-align: center"/></li>
            <li><span class="am-icon-btn am-icon-briefcase"></span><br/>待分配订单数量<br/>30</li>
            <li><span class="am-icon-btn am-icon-recycle"></span><br/>待发出订单数量<br/>8008</li>
            <li><span class="am-icon-btn am-icon-user-md"></span><br/>已完成订单数量<br/>3000</li>
        </ul>
        
        
        <ul class="am-avg-sm-1 am-avg-md-4 am-margin am-padding am-text-center admin-content-list ">
             <li><span class="am-icon-btn am-icon-user-md"></span><br/>用户数量<br/><input class="userNumber  am-badge-secondary am-round am-text-default" disabled="disabled" value="" style="text-align: center"/></li>  
             <li><span class="am-icon-btn am-icon-briefcase"></span><br/>客户数量<br/><input class="customerNumber  am-badge-secondary am-round am-text-default" disabled="disabled" value="" style="text-align: center"/></li>
             <li><span class="am-icon-btn  am-icon-user-md"></span><br/>代加工厂数量<br/><input class="plantNumber  am-badge-secondary am-round am-text-default" disabled="disabled" value="" style="text-align: center"/></li>
            <li><span class="am-icon-btn am-icon-user-md"></span><br/>上次登录时间<br/>2018.5.1</li>
        </ul>
        <ul class="am-avg-sm-1 am-avg-md-4 am-margin am-padding am-text-center admin-content-list ll" style="display: none">
            <li style="font-size: 18px;font-family: 华文行楷">已经到了新的一个月份<br>请尽快去库存管理界面<br>对上个月的库存进行结算</li>
        </ul>
    </div>
</div>
<script type="text/javascript" src="assets/js/homepage.js"></script>
<?php
require_once 'View/footer.php';
?>
