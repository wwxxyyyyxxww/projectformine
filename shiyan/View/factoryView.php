<!doctype html>
<?PHP
require_once 'View/head.php';
?> 
<!--表单顶部内容(start)-->
<div class="am-fl am-cf">
    <strong class="am-text-primary am-text-lg">加工厂</strong> /
    <small>Form</small>
</div>
<hr>
<div class="am-g">
    <div class="am-u-sm-12 am-u-md-4">
        <!--顶部新增按钮-->
        <button type="button" class="am-btn am-btn-default" data-am-modal="{target: '#my-popup'}" onclick="addView();orderlightClose()" id="btnadd"><span class="am-icon-plus">新增</span></button>
    </div>              
    <!--表单顶部内容(end)-->
    <!--form表单(start)包含select以及搜索框-->
    <!--<form>-->
    <div class="am-u-sm-12 am-u-md-3">
        <div class="am-form-group">
            <select data-am-selected="{btnSize: 'sm'}" name="search"  id="factorySearch">
                <option value="all">全部</option>
                <option value="finished_factory_name">加工厂名称</option>
                <option value="factory_responsable_name">负责人名称</option>
                <option value="factory_tel">联系方式</option>
                <option value="finished_factory_address">地址</option>
            </select>
        </div>
    </div>
    <!--搜索按钮和搜索框-->
    <?PHP
    require_once 'classLibrary/searchbutton.php';
    searchbutton("factorySearchInput", "factorySearchButton", "search_factory()")
    ?>

</div>
<!--form表单(end)-->
<!--数据库翻页内容(包含表头，以及从数据库搜索的内容和翻页功能)-->
<div class="am-g" id="orderDiv1">
    <div class="am-u-md-12  am-u-sm-6 am-u-sm-centered am-u-md-uncentered am-form" style="position: relative;width:100%">
        <table  id="factoryTable" style="position: relative;width:100%">
            <thead>
            <th class="table-author">加工厂名称</th>
            <th class="table-author">负责人名称</th>
            <th class="table-author">联系方式</th>
            <th class="table-author">地址</th>
            <th class="table-set am-hide-sm-only">操作</th>
            </thead>
            <!--循环输出每行tr  共六行-->
            <?PHP
            for ($i = 0; $i < 6; $i++) {
                echo <<<SUI
                                        <tr>
                                        <td><input  type='text' disabled='disabled' value=""></td>
                                        <td><input  type='text' disabled='disabled' value=""></td>
                                        <td><input  type='text' disabled='disabled' value=""></td>
                                        <td><input  type='text' disabled='disabled' value=""></td>
                                        <td class="am-hide-sm-only">
                                <button type="button" class="am-btn am-btn-default am-btn-xs am-text-secondary" data-am-modal="{target: '#my-popup1'}"  id="edit1" onclick="detail(this)"><span class="am-icon-pencil-square-o">编辑</span></button>

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


<!-- 新增加工厂块(start)，默认display=none -->
<div class="am-popup" id="my-popup">
    <div class="am-popup-inner">
        <div class="am-popup-hd">
            <h4 class="am-popup-title">新增</h4>
            <span data-am-modal-close
                  class="am-close"  onclick="orderlightClose()">&times;</span>
        </div>
        <div class="am-popup-bd">
            <div id="orderlight">
                <div class="demo" >
                    <table class="distable am-u-sm-6 am-u-sm-centered">
                        <tr>
                            <td colspan="2">
                                <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                    <span class="am-input-group-label">加工厂名称</span>
                                    <input type="text" class="am-form-field"  name="finished_factory_name"  id="finished_factory_name" placeholder="加工厂名称"  onkeyup="checkFactoryName()"><span id="newfinishedfactoryname"></span>

                                </div></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                    <span class="am-input-group-label">负责人名称</span>
                                    <input type="text" class="am-form-field"  name="factory_responsable_name"  id="factory_responsable_name" placeholder="负责人名称"onkeyup="checkResponsableName()"><span id="newfactoryresponsablename"></span>
                                </div></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                    <span class="am-input-group-label">联系方式</span>
                                    <input type="tel" class="am-form-field"  name="factory_tel"  id="factory_tel" placeholder="联系方式"onkeyup="clearNewTelTest();testTel()"><span id="newfactorytel"></span>
                                </div></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                    <span class="am-input-group-label">地址</span>
                                    <input type="text" class="am-form-field"  name="finished_factory_address"  id="finished_factory_address" placeholder="地址"onkeyup="checkFactoryAddress()"><span id="newfinishedfactoryaddress"></span>
                                </div></td>
                        </tr>


                        <tr> <td><button style="width: 100%"  class="am-btn am-btn-default am-btn-xs am-text-secondary" id="factory_submit" name="sumbit"onclick="checkFactory();checkFactel()" >提交</button></td></tr>

                    </table>
                </div>
                <!--关闭按钮，点击关闭当前div-->

            </div>
        </div>
    </div>
</div>

<!-- 详细加工厂块(end)，默认display=none -->
<div class="am-popup" id="my-popup1">
    <div class="am-popup-inner">
        <div class="am-popup-hd">
            <h4 class="am-popup-title">编辑加工厂</h4>
            <span data-am-modal-close
                  class="am-close">&times;</span>
        </div>
        <div class="am-popup-bd"></div>
            <div id="detailedInfo">
                <table class="distable am-u-sm-6 am-u-sm-centered">
                    <tr style="display: none"><td>加工厂id:</td><td><input type="text" name="finished_factory_id" class="finished_factory_id_alter" value="lll"  disabled="disabled"/></td></tr>

                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">加工厂名称</span>
                                <input type="text" class="am-form-field finished_factory_name_alter" id="finished_factory_name_alter" name="finished_factory_name"  value="lll"  disabled="disabled" onkeyup="checkAll();checkFactoryName()"><span id="checkfactoryname"></span>
                            </div></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">负责人姓名</span>
                                <input type="text" class="am-form-field factory_responsable_name_alter" id="factory_responsable_name_alter" name="factory_responsable_name"  value="lll"  disabled="disabled"onkeyup="checkAll();checkResponsableName()"><span id="checkresponsablename"></span>
                            </div></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">负责人电话</span>
                                <input type="tel" class="am-form-field factory_tel_alter"  name="factory_tel" id="factory_tel_alter" value="lll"  disabled="disabled"onkeyup="checkAll();checkFactoryTel()"><span id="checkfactorytel" ></span>
                            </div></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">地址</span>
                                <input type="text" class="am-form-field finished_factory_address_alter"  id="finished_factory_address_alter"name="finished_factory_address"  value="lll"  disabled="disabled"onkeyup="checkAll();checkFactoryAddress()"><span id="checkfactoryaddress" ></span>
                            </div></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <button class="am-btn am-btn-default am-btn-xs am-text-secondary" id="alter" onclick="alterit(this)" style="width: 100%">
                                    <span class="am-icon-pencil-square-o">修改</span></button>
                                <button class="am-btn am-btn-default am-btn-xs am-text-secondary" id="save" style="width: 100%">
                                    <span class="am-icon-save">保存</span></button>
                                <button class="am-btn am-btn-default am-btn-xs am-text-secondary" id="delete" onclick="deleteit(this)" style="color:red;width: 100%">
                                    <span class="am-icon-pencil-square-o" >删除</span></button>
                            </div></td>
                    </tr>
                </table>
                <!--关闭按钮，点击关闭当前div-->
                <a onclick="detailedInfoClose()"class="closewindow" ><img src="assets/i/close.png" style="width:20px;height: 20px"></a>
            </div>
        
    </div>
</div>
<!--详细内容表格(start)，默认display=none-->


<script type="text/javascript" src="assets/js/factoryForm.js"></script>
<?PHP
require_once 'View/footer.php';
?>


