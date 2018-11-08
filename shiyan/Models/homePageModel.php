<?php
//导入数据库连接
 require_once '../classLibrary/mysqlConnect.php';
 $db=mysqlConnect::Connect();
 //查询数量to_be_distribute
 $orderNumber=$db->query("select count(*) from customer_company_order");
 $distribute=$db->query("select count(*) from to_be_distribute");
 $userNumber=$db->query("select count(*) from stock_staff");
 $customerNumber=$db->query("select count(*) from customer_company_information");
 $plantNumber=$db->query("select count(*) from process_factory");
 //将查询结果变成数组
 $orderNumber=$orderNumber->fetch(PDO::FETCH_BOTH);
 $distribute=$distribute->fetch(PDO::FETCH_BOTH);
 $userNumber = $userNumber->fetch(PDO::FETCH_BOTH);
 $customerNumber = $customerNumber->fetch(PDO::FETCH_BOTH);
 $plantNumber= $plantNumber->fetch(PDO::FETCH_BOTH);
 //新建数组 将所有查询结果集合起来用json返回
 $array=array("orderNumber"=>$orderNumber[0],"distribute"=>$distribute[0],"userNumber"=>$userNumber[0],"customerNumber"=>$customerNumber[0],"plantNumber"=>$plantNumber[0]);
 echo json_encode($array);