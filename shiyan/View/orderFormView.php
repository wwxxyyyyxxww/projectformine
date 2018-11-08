<!doctype html>
<?PHP
require_once 'View/head.php';
?>

<script type="text/javascript" src="assets/js/distribute.js"></script>
<!--表单顶部内容(start)-->
<div class="am-fl am-cf">
    <strong class="am-text-primary am-text-lg">订单</strong> /
    <small>Form</small>
</div>
<hr>
<div class="am-g">
    <div class="am-u-sm-12 am-u-md-4">
        <!--顶部新增按钮-->
        <button type="button" class="am-btn am-btn-default" data-am-modal="{target: '#my-popup'}"  onclick="orderlightClose()"><span class="am-icon-plus">新增</span></button>
    </div>              
    <!--表单顶部内容(end)-->
    <div class="am-u-sm-12 am-u-md-3">
        <div class="am-form-group">
            <select data-am-selected="{btnSize: 'sm'}" name="search"  id="orderSearch" >
                <option value="all">全部</option>
                <option value="order_serial_number">订单编号</option>
                <option value="material_name">原料名称</option>
                <option value="material_number">原料数量</option>
                <option value="product_name">成品名称</option>
                <option value="product_name">公司名称</option>
                <option value="status_code">完成状态</option>
            </select>
        </div>
    </div>
    <!--搜索按钮和搜索框-->
    <?PHP
    require_once 'classLibrary/searchbutton.php';
    searchbutton("orderSearchInput", "orderSearchButton", "search_order()")
    ?>
    <!--</form>-->
</div>
<!--form表单(end)-->
<!--数据库翻页内容(包含表头，以及从数据库搜索的内容和翻页功能)-->
<div class="am-g" id="orderDiv1">
    <div class="am-u-md-12  am-u-sm-6 am-u-sm-centered am-u-md-uncentered am-form" style="position: relative;width:100%">
        <table  id="orderTable" style="position: relative;width:100%">
            <thead>
            <th class="table-author ">订单编号</th>
            <th class="table-author ">原料名称</th>
            <th class="table-author am-hide-sm-only">原料数量</th>
            <th class="table-author ">成品名称</th>
            <th class="table-author am-hide-sm-only">公司名称</th>
            <th class="table-author ">完成状态</th>
            <th class="table-set am-hide-sm-only">操作</th>
            </thead>
            <!--循环输出每行tr  共六行-->
            <?PHP
            for ($i = 0; $i < 6; $i++) {
                echo <<<SUI
                                        <tr>
                                        <td><input  type='text' disabled='disabled' value="" name="orderserialnumber"></td>
                                        <td><input  type='text' disabled='disabled' value=""></td>
                                        <td class="am-hide-sm-only"><input  type='text' disabled='disabled' value="" ></td>
                                        <td><input  type='text' disabled='disabled' value=""></td>
                                        <td class="am-hide-sm-only"><input  type='text' disabled='disabled' value=""></td>
                                        <td><input  type='text' disabled='disabled' value=""></td>
                                        
                                        <td class="am-hide-sm-only">
                                           <button type="button" class="am-btn am-btn-default am-btn-xs am-text-secondary" id="distribute" onclick="distribute(this)" data-am-modal="{target: '#my-popup1'}">
                                           <span class="am-icon-plus">分配</span></button>
                                           <button type="button" class="am-btn am-btn-default am-btn-xs am-text-secondary" id="detailed" onclick="detail(this)" data-am-modal="{target: '#my-popup2'}">
                                           <span class="am-icon-pencil-square-o">编辑</span></button>
                                           <button class="am-btn am-btn-default am-btn-xs am-text-secondary" id="send" onclick="send(this)">
                                           <span class="am-icon-pencil-square-o">发送</span></button>
                                       </td>
                                    </tr>
                                        
SUI;
            }
            ?>
        </table>
    </div>
    <?PHP
    require_once 'classLibrary/skip.php';
    skip("pageTableButton1", "pageTableButton2", "pageTableButton3");
    ?>
</div>

<!--底部上一页下一页和跳转-->
<!--分配页面-->
<div class="am-popup" id="my-popup1">
    <div class="am-popup-inner">
        <div class="am-popup-hd">
            <h4 class="am-popup-title">订单分配</h4>
            <span data-am-modal-close
                  class="am-close">&times;</span>
        </div>
        <div class="am-popup-bd">
            <div id="distributeTable"> 
                <table border="1" class="distable am-u-sm-6 am-u-sm-centered">

                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">订单编号</span>
                                <input type="number" class="am-form-field distribute_order_serial_number"  disabled="disabled">
                            </div></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">原料名称</span>
                                <input type="text" class="am-form-field distribute_meterial_name"  disabled="disabled">
                            </div></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">成品名称</span>
                                <input type="text" class="am-form-field distribute_product_name"  disabled="disabled">
                            </div></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">原料数量</span>
                                <input type="number" class="am-form-field distribute_meterial_number"  disabled="disabled">
                            </div></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">可分配数量</span>
                                <input type="number" class="am-form-field distribute_leave_number"  disabled="disabled">
                            </div></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">分配工厂数量</span>
                                <input type="number" class="am-form-field factory_number" onkeyup="show_factory_num()">


                                </tr>                    
                                <tr><td colspan="2"><button class="am-btn am-btn-default am-btn-xs am-text-secondary" onclick="sum()">
                                            <span class="am-icon-pencil-square-o" >提交分配</span></button></td></tr>

                                <tr>
                                    <td colspan="2">
                                        <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                            <span class="am-input-group-label">加工厂名称</span>
                                            <span class="am-input-group-label">分配数量</span>
                                            <span class="am-input-group-label">期待成品数量</span>
                                        </div>
                                </tr>    
                </table>
                <!--关闭按钮，点击关闭当前div-->
            </div>
        </div>
    </div>
</div>
<!--分配页面-->



<!--详细页面(end)，默认display=none-->
<div class="am-popup" id="my-popup2">
    <div class="am-popup-inner">
        <div class="am-popup-hd">
            <h4 class="am-popup-title">编辑</h4>
            <span data-am-modal-close
                  class="am-close">&times;</span>
        </div>
        <div class="am-popup-bd">
            <div id="detailedInfo">
                <table class="am-u-sm-6 am-u-sm-centered">

                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">订单编号</span>
                                <input type="number" class="am-form-field order_serial_number_alter"   name="order_serial_number" value="lll" placeholder="订单编号" disabled="disabled">
                            </div></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">原料名称</span>
                                <input type="text" class="am-form-field material_name_alter"  name="material_name" value="lll" placeholder="原料名称" disabled="disabled"id="material_name_alter" onkeyup="checkAll();checkName()"><span id="checkname"></span>
                            </div></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">原料数量</span>
                                <input type="text" class="am-form-field material_number_alter" name="material_number" value="lll" placeholder="原料数量" disabled="disabled"id="material_number_alter" onkeyup="checkAll();checkNumber()"><span id="checknumber"></span>
                            </div></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">产品名称</span>
                                <input type="text" class="am-form-field product_name_alter" name="product_name" value="lll" placeholder="产品名称" disabled="disabled"id="product_name_alter" onkeyup="checkAll();checkProduct()"><span id="checkproduct"></span>
                            </div></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">公司名称</span>
                                <input type="text" class="am-form-field select_name_alter" name="company_name" value="lll" placeholder="公司名称" disabled="disabled"id="select_name_alter" onkeyup="checkAll();checkCompanyName()"><span id="checkselectname"></span>
                            </div></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">负责人姓名</span>
                                <input type="text" class="am-form-field responsable_name_alter"  name="responsable_name" value="lll" placeholder="负责人姓名" disabled="disabled"id="responsable_name_alter" onkeyup="checkAll();checkResponsableName()"><span id="checkresponsablename"></span>
                            </div></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">负责人电话</span>
                                <input type="tel" class="am-form-field responsable_tel_alter" name="responsable_tel" value="lll" placeholder="负责人电话" disabled="disabled"id="responsable_tel_alter" onkeyup="checkAll();checkTel()"><span id="checktel"></span>
                            </div></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">到期日期</span>
                                <input type="datetime" class="am-form-field end_time_alter" name="end_time" value="lll" disabled="disabled"id="end_time_alter" onkeyup="checkEndTime()" onClick="checkendtime()"><span id="checkendtime"></span>
                            </div></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">截止日期</span>
                                <input type="datetime" class="am-form-field dead_time_alter "  name="dead_time" value="lll" disabled="disabled" id="dead_time_alter"  onkeyup="checkDeadTime()" onClick="checkdeadTime()"><span id="checkdeadtime"></span>
                            </div></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">状态</span>

                                <input type="number" name="status_code"  disabled="disabled" class="am-form-field status_code_alter"id="status_code_alter" onkeyup="checkAll();checkStatusCode()"/><span id="statuscodealter"></span>
                            </div>  </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">备注</span>
                                <input type="text" class="am-form-field note_alter "  name="note" value="lll" disabled="disabled">
                            </div></td>
                    </tr>
                    <tr><td colspan="2"><button class="am-btn am-btn-default am-btn-xs am-text-secondary" id="alter" onclick="alterit(this)" style="width: 100%">
                                <span class="am-icon-pencil-square-o">修改</span></button></td></tr>
                    <tr><td  colspan="2"><button class="am-btn am-btn-default am-btn-xs am-text-secondary" id="save" style="width: 100%">
                                <span class="am-icon-save">保存</span></button></td></tr>
                    <tr><td  colspan="2"><button class="am-btn am-btn-default am-btn-xs am-text-secondary" id="delete" onclick="deleteit(this)" style="color:red;width: 100%">
                                <span class="am-icon-pencil-square-o" >删除</span></button></td></tr>

                </table>
            </div>
        </div>
    </div>
</div>
<!--详细内容表格(start)，默认display=none-->

<!-- 新增加 -->
<div class="am-popup" id="my-popup">
    <div class="am-popup-inner">
        <div class="am-popup-hd">
            <h4 class="am-popup-title">添加订单</h4>
            <span data-am-modal-close
                  class="am-close"  onclick="orderlightClose()">&times;</span>
        </div>
        <div class="am-popup-bd">
            <div class="demo" class="am-u-md-12">
                <table class="am-u-sm-6 am-u-sm-centered">
                    <tr><td>
                            <div class="number">
                                <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                    <span class="am-input-group-label">订单编号</span>
                                    <input type="text" class="am-form-field" placeholder="<?php
                                    date_default_timezone_set('Asia/Shanghai');
                                    echo date("YmdHis")
                                    ?>" disabled="disabled">
                                </div></td></tr>
                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">原料名称</span>
                                <input type="text" class="am-form-field "  name="material_name" id="material_name" onkeyup="checkName()"placeholder="原料名称"><span id="newmaterialname"></span>
                            </div></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">原料数量</span>
                                <input type="number" class="am-form-field"  name="material_number" id="material_number" onkeyup="checkNumber()" placeholder="原料数量"><span id="newmaterialnumber"></span>
                            </div></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">成品名称</span>
                                <input type="text" class="am-form-field"   name="product_name" id="product_name" onkeyup="checkProduct()" placeholder="成品名称"><span id="newproductname"></span>
                            </div></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">客户公司</span>



                                <select id="select_name" class="am-form-field"  onclick="checkselect()">
                                    <option > </option>
                                </select><span id="newselectname"></span>
                            </div></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">客户姓名</span>
                                <input type="text" class="am-form-field"   name="responsable_name" id="responsable_name" onkeyup="checkResponsableName()"placeholder="客户姓名"><span id="newresponsablename"></span>
                            </div></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">客户电话</span>
                                <input type="text" class="am-form-field"   name="responsable_tel" pattern="[0-9]{11}" id="responsable_tel"  onkeyup="clearNewTelTest()"placeholder="客户电话"><span id="newresponsabletel"></span>
                            </div></td>

                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">到期时间</span>
                                <input id="end_time"  class="Wdate am-form-field"  name="end_time" type="text"  onkeyup="checkEndTime()" onClick="checkendtime()" placeholder="到期时间"/><span id="newendtime"></span>
                            </div></td>
                    </tr> 
                    <td colspan="2">
                        <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                            <span class="am-input-group-label">截至时间</span>
                            <input  class="Wdate am-form-field"  id="dead_time" name="dead_time" type="text"  onkeyup="checkDeadTime()" onClick="checkdeadTime()" placeholder="截止时间"/><span id="newdeadtime"></span>

                        </div></td>
                    </tr>
                    <tr> 
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">备注</span>
                                <input type="textarea" class="Wdate am-form-field"   name="order_note"  id="order_note"  placeholder="备注">
                            </div></td>
                    </tr>
                    <tr>
                        <td><button style="width: 100%" class="am-btn am-btn-default am-btn-xs am-text-secondary"id="order_submit"  onclick="checkorder();checkRestel()">提交</button></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>







<!-- 订单块(end)，默认display=none -->

<script type="text/javascript" src="assets/js/orderForm.js"></script>
<?PHP
require_once 'View/footer.php';
?>