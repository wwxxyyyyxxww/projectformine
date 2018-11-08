
<?php
//获取工厂的名称
require_once '../classLibrary/mysqlConnect.php';
$db = mysqlConnect::Connect();
$sql = "select company_name from customer_company_information";
$sql_company_name = $db->query($sql);
$result = $sql_company_name->fetchAll(PDO::FETCH_BOTH);
$arr = array();
$i = 0;
foreach ($result as $res) {

    for ($j = 0; $j < 1; $j++) {
        $arr[$i] = $res[$j];
        $i++;
    }
}
echo json_encode($arr);
?>
