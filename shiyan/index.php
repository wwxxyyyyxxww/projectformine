<html>
    <head>
    </head>
    <body>
     <?PHP
     //开始session 通过session判断渲染登录界面还是主页
      session_start();
      
      //导入数据库连接类并获取数据库连接
      require_once 'classLibrary/mysqlConnect.php';
      $db=mysqlConnect::Connect();
      
      if(!isset($_SESSION['state'])){
          require_once 'View/loginView.php';
          require_once 'Models/loginModel.php';
          //进行登录验证
          loginModel::con();
      }
       else if($_SESSION['state']=="success"){
           //在此判断加载相应的页面
       if(!empty($_GET['page'])){
           //注意添加管理员特有功能时需要判断他的级别在进行require
           if($_GET['page']=="orderForm"){
               require_once 'View/orderFormView.php';
           }else if($_GET['page']=="workView"){
               require_once 'View/workView.php';
           }
           else if($_GET['page']=="log"){
               require_once 'View/logView.php';
           }else if($_GET['page']=="stock"){
               require_once 'View/stockView.php';
           }
           else if($_GET['page']=="companyView"){
               require_once 'View/companyView.php';
           } else if($_GET['page']=="userView"){
               require_once 'View/userView.php';
           }else if($_GET['page']=="factoryView"){
               require_once 'View/factoryView.php';
           }
       }
       else {
               require_once 'View/homePage.php';
             
          }

        }
?>
        
    </body>
</html>