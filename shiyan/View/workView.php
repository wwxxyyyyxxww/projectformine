<!doctype html>
<?PHP
require_once 'View/head.php';
?> 
<!--表单顶部内容(start)-->
<div class="am-fl am-cf">
    <strong class="am-text-primary am-text-lg">加工中</strong> /
    <small>Form</small>
</div>
<hr>


<div class="am-g">            
    <!--表单顶部内容(end)-->
    <!--form表单(start)包含select以及搜索框-->
    <!--<form>-->
    <div class="am-u-sm-12 am-u-md-3 ">
        <div class="am-form-group">
            <select data-am-selected="{btnSize: 'sm'}" name="search" id="workSearch">
                <option value="all">全部</option>
                <option value="order_serial_number">订单编号</option>
                <option value="finished_factory_name">加工厂名称</option>
                <option value="material_name">原料名称</option>
                <option value="product_name">成品名称</option>
                <option value="completion_status">完成状态</option>
            </select>
        </div>
    </div>
    <!--搜索按钮和搜索框-->
    <?PHP
    require_once 'classLibrary/searchbutton.php';
    searchbutton("workSearchInput", "workSearchButton", "search_work()")
    ?>
    <!--</form>-->
</div>
<!--form表单(end)-->




<!--数据库翻页内容(包含表头，以及从数据库搜索的内容和翻页功能)-->
<div class="am-g" id="orderDiv1">
    <div class="am-u-md-12  am-u-sm-6 am-u-sm-centered am-u-md-uncentered am-form" style="position: relative;width:100%">
        <table id="workTable" style="position: relative;width:100%">
            <thead>
            <th class="table-author ">订单编号</th>
            <th class="table-author ">加工厂名称</th>
            <th class="table-author ">原料名称</th>
            <th class="table-author ">被分配原料数量</th>
            <th class="table-author am-hide-sm-only">成品名称</th>
            <th class="table-author am-hide-sm-only">期望数量</th>
            <th class="table-author am-hide-sm-only">实际数量</th>
            <th class="table-author am-hide-sm-only">完成状态</th>
            <th class="table-set am-hide-sm-only">操作</th>
            </thead>
            <!--循环输出每行tr  共六行-->
            <?PHP
            for ($i = 0; $i < 6; $i++) {
                echo <<<SUI
                                        <tr>
                                        <td><input  type='number' disabled='disabled' value=""></td>
                                        <td><input  type='text' disabled='disabled' value=""></td>
                                        <td><input  type='text' disabled='disabled' value=""></td>
                                        <td><input  type='number' disabled='disabled' value=""></td>
                                        <td class="am-hide-sm-only"><input  type='text' disabled='disabled' value=""></td>
                                        <td class="am-hide-sm-only"><input  type='number' disabled='disabled' value=""></td>
                                        <td class="am-hide-sm-only"><input  type='number' disabled='disabled' value=""></td>
                                        <td class="am-hide-sm-only"><input  type='text' disabled='disabled' value="" ></td>
                                        <td class="am-hide-sm-only">
                                         <button class="am-btn am-btn-default am-btn-xs am-text-secondary" id="edit1" onclick="detail(this)">
                                                <span class="am-icon-pencil-square-o">编辑</span></button>
                
                                <button type="button" class="am-btn am-btn-default am-btn-xs am-text-secondary" data-am-modal="{target: '#my-popup'}" id="distributuAgain" onclick="distribute(this)"><span class="am-icon-pencil-square-o">分配</span></button>

                                        <button class="am-btn am-btn-default am-btn-xs am-text-secondary" id="finish" onclick="finishWork(this)">
                                                <span class="am-icon-pencil-square-o">完成</span></button>
                
                                        <button class="am-btn am-btn-default am-btn-xs am-text-secondary" id="save" onclick="save(this)">
                                                <span class="am-icon-pencil-square-o">保存</span></button>
                                      </td>
                                    </tr>
                                        
SUI;
            }
            ?>
        </table>
    </div>
  
    <?PHP
            require_once 'classLibrary/skip.php';
            skip("pageTableButton1","pageTableButton2","pageTableButton3");
    ?>
</div>

<br>
<!--底部上一页下一页和跳转-->
<div class="am-popup" id="my-popup">
  <div class="am-popup-inner">
    <div class="am-popup-hd">
      <h4 class="am-popup-title">再分配</h4>
      <span data-am-modal-close
            class="am-close">&times;</span>
    </div>
    <div class="am-popup-bd">
      <div id="distributeTable"> 
          <table border="1" class="distable am-u-sm-6 am-u-sm-centered">
              <!--<tr><td>订单编号：</td><td><input type="number" class="workAdd_order_serial_number" disabled="disabled"/></td></tr>-->
        <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">订单编号</span>
                                <input type="number" class="am-form-field  workAdd_order_serial_number"  name="material_name" placeholder="订单编号" disabled="disabled">
                            </div></td>
                    </tr>
        <!--<tr><td>工厂名称</td><td><input type="text" class="workAdd_factory_name" disabled="disabled"/></tr>-->
         <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">工厂名称</span>
                                <input type="text" class="am-form-field  workAdd_factory_name"  name="material_name" placeholder="工厂名称" disabled="disabled">
                            </div></td>
                    </tr>
        <!--<tr><td>原料名称：</td><td><input type="text" class="workAdd_meterial_name" disabled="disabled"/></td></tr>-->
        <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">原料名称</span>
                                <input type="text" class="am-form-field  workAdd_meterial_name"  name="material_name" placeholder="原料名称" disabled="disabled">
                            </div></td>
                    </tr>
<!--        <tr><td>原料数量：</td><td><input type="number" class="workAdd_meterial_number" /></td></tr>-->
        <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">原料数量</span>
                                <input type="number" class="am-form-field  workAdd_meterial_number"  name="material_name" placeholder="原料数量" >
                            </div></td>
                    </tr>
        <!--<tr><td>产品名称：</td><td><input type="text" class="workAdd_product_name" disabled="disabled"/></td></tr>-->
        <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">产品名称</span>
                                <input type="text" class="am-form-field  workAdd_product_name"  name="material_name" placeholder="产品名称" disabled="disabled">
                            </div></td>
                    </tr>
        <!--<tr><td>期望返回数量：</td><td><input type="number" class="workAdd_product_number" /></td></tr>-->
        <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">期望返回数量</span>
                                <input type="number" class="am-form-field  workAdd_product_number"  name="material_name" placeholder="期望返回数量">
                            </div></td>
                    </tr>
        <tr><td colspan="2"><button onclick="submit_distribute()">提交</button></td></tr>
    </table>
</div>
    </div>
  </div>
</div>


<script type="text/javascript" src="assets/js/workForm.js"></script>
<?PHP
require_once 'View/footer.php';
?>