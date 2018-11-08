<!doctype html>
<?php
require_once 'View/head.php';
?>

<link rel = "stylesheet" href = "assets/css/stock.css" />

<div class="am-fl am-cf">
    <strong class="am-text-primary am-text-lg">库存</strong> /
    <small>Form</small>
</div>
<hr>

<!--上方盘点和月结按钮-->
<div class="am-g">
    <div class="am-u-sm-12 am-u-md-4">
        <button type="button" class="am-btn am-btn-default am-round"  data-am-modal="{target: '#my-popup'}"><span class="am-icon-plus">盘点</span></button>
        <button type="button" class="am-btn am-btn-default am-round" id="check" onclick="monthlyBalance()" data-am-modal="{target: '#my-popup1'}"><span class="am-icon-plus">月结</span></button>
    </div>  


    <!--表单顶部搜索区域内容-->
    <!--<form>-->
    <div class="am-u-sm-12 am-u-md-3">
        <div class="am-form-group">
            <select data-am-selected="{btnSize: 'sm'}" name="search"  id="materialSearch">
                <option value="material_name">原料名称</option>
            </select>
        </div>

    </div>
    <!--搜索按钮和搜索框-->
    <?PHP
    require_once 'classLibrary/searchbutton.php';
    searchbutton("materialSearchInput", "materialSearchButton", "search_material()")
    ?>

</div>


<!--库存的内容模块-->
<div class="am-g" id="orderDiv2">
    <div class="am-u-md-12  am-u-sm-6 am-u-sm-centered am-u-md-uncentered am-form" style="position: relative;width:100%">
        <table id="workTable" style="position: relative;width:100%">
            <thead>
            <th class="table-author" style="text-align: center;">材料名称</th>
            <th class="table-author" style="text-align: center;">数量</th>
            </thead>
            <!--循环输出每行tr  共六行-->
            <?PHP
            for ($i = 0; $i < 6; $i++) {
                echo <<<SUI
                                        <tr>
                                        <td><input  type='text' disabled='disabled' value="" class="name" style="text-align: center;"></td>
                                        <td><input  type='number' disabled='disabled' value="" class="number" style="text-align: center;"></td>
                                    </tr>
                                        
SUI;
            }
            ?>
        </table>
    </div>
    <!--翻页模块-->
    <?PHP
    require_once 'classLibrary/skip.php';
    skip("pageTableButton1","pageTableButton2","pageTableButton3");
    ?>

</div>

<!--月结代码区域-->
<div class="am-popup" id="my-popup1">
  <div class="am-popup-inner">
    <div class="am-popup-hd">
      <h4 class="am-popup-title">月结</h4>
      <span data-am-modal-close class="am-close">&times;</span>
    </div>
    <div class="am-popup-bd">
        <table id="monthBalanceThis2" class="am-form">
        <thead>
        <th class="table-author" style="text-align: center;">材料名称</th>
        <th class="table-author" style="text-align: center;">入库数量</th>
        <th class="table-author" style="text-align: center;">出库数量</th>
        <th class="table-author" style="text-align: center;">结余时间</th>
        </thead>
        </table>
    <div id="month2">
        <table id="monthBalanceThis" style="" class="am-form">
        </table>
    </div>
    </div>
  </div>
</div>




<!--库存盘点-->
<div class="am-popup" id="my-popup">
    <div class="am-popup-inner">
        <div class="am-popup-hd">
            <h4 class="am-popup-title">库存盘点</h4>
            <!--下面是关闭按钮-->
            <span data-am-modal-close class="am-close">&times;</span>
        </div>
        <div class="am-popup-bd">
            <hr/>
                <div class="am-input-group am-input-group-sm">
                    <span class="am-input-group-btn">
                        <select data-am-selected="{btnSize: 'sm'}" name="search"  id="materialSearch">
                            <option value="material_name">原料名称</option>
                        </select></span>
                    <input  class="am-form-field" id="materialSearchInput1" type="text"  placeholder="searching..." />
                    <span class="am-input-group-btn">
                        <button class="am-btn am-btn-default" id="materialSearchButton" onclick="search_material1()">搜索</button>
                    </span>
                </div>
                <hr/>
                <!--盘点的显示区域-->
                <div  id="orderDiv1">
                   
                        <table id="workTable" class="am-form">
                            <thead>

                            <th class="table-author" style="text-align: center;">材料名称</th>
                            <th class="table-author" style="text-align: center;">在库数量</th>
                            <th class="table-author" style="text-align: center;">实际数量</th>
                            <th class="table-set" style="text-align: center;">操作</th>
                            </thead>
                            <!--循环输出每行tr  共六行-->
                            <?PHP
                            for ($i = 0; $i < 6; $i++) {
                                echo <<<SUI
                                        <tr>
                                        <td><input  type='text' disabled='disabled' value="" class="stockName" style="text-align: center;"></td>
                                        <td><input  type='number' disabled='disabled' value="" class="stockNum" style="text-align: center;"></td>
                                        <td><input  type='number'   value="" class="realNum" style="text-align: center;"></td>
                                        <td><button class='am-btn am-btn-default am-btn-xs am-text-secondary' type='button' id='$i'>确认</button></td>
                                        </tr>
                                        
SUI;
                            }
                            ?>
                        </table>

                    <?PHP
                    skip("pageTableButton4","pageTableButton5","pageTableButton6");
                    ?>

                </div>
                
        </div>
    </div>
</div>


<script type="text/javascript" src="assets/js/stockForm.js"></script>
<?php
require_once 'View/footer.php';
?>