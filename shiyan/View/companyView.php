<!doctype html>
<?PHP
require_once 'View/head.php';
?> 
<!--表单顶部内容(start)-->
<div class="am-fl am-cf">
    <strong class="am-text-primary am-text-lg">客户公司</strong> /
    <small>Form</small>
</div>
<hr>
<div class="am-g">
    <div class="am-u-sm-12 am-u-md-4">
        <!--顶部新增按钮-->
        <button type="button" class="am-btn am-btn-default" onclick="orderlightClose()" data-am-modal="{target: '#my-popup'}"><span class="am-icon-plus">新增</span></button>
    </div>              
    <!--表单顶部内容(end)-->
    <!--form表单(start)包含select以及搜索框-->
    <!--<form>-->
    <div class="am-u-sm-12 am-u-md-3">
        <div class="am-form-group">
            <select data-am-selected="{btnSize: 'sm'}" name="search"  id="companySearch">
                <option value="all">全部</option>

                <option value="company_name">公司名称</option>
                <option value="company_tel">公司电话</option>
                <option value="company_address">公司地址</option>
            </select>
        </div>
    </div>
    <!--搜索按钮和搜索框-->
    <?PHP
    require_once 'classLibrary/searchbutton.php';
    searchbutton("companySearchInput", "companySearchButton", "search_company()")
    ?>
    <!--</form>-->
</div>
<!--form表单(end)-->
<!--数据库翻页内容(包含表头，以及从数据库搜索的内容和翻页功能)-->
<div class="am-g" id="orderDiv1">
    <div class="am-u-md-12  am-u-sm-6 am-u-sm-centered am-u-md-uncentered am-form" style="position: relative;width:100%">
        <table id="companyTable" style="position: relative;width:100%">
            <thead>

            <th class="table-author">公司名称</th>
            <th class="table-author">公司电话</th>
            <th class="table-author">公司地址</th>
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
                                      <td class="am-hide-sm-only" >
                                     <button type="button" class="am-btn am-btn-default am-btn-xs am-text-secondary" id="edit1" onclick="detail(this)" data-am-modal="{target: '#my-popup1'}">
                                       <span class="am-icon-pencil-square-o">编辑</span></button>
                                       </td>
                                    </tr>
SUI;
            }
            ?>
        </table>
    </div>
    <!--导入跳转-->
    <?PHP
    require_once 'classLibrary/skip.php';
    skip("pageTableButton1", "pageTableButton2", "pageTableButton3");
    ?>
</div>

<!-- 新增客户公司块(start)-->
<div class="am-popup" id="my-popup">
    <div class="am-popup-inner">
        <div class="am-popup-hd">
            <h4 class="am-popup-title">添加客户</h4>
            <span data-am-modal-close
                  class="am-close" onclick="orderlightClose()">&times;</span>
        </div>
        <div class="am-popup-bd">
            </div>
            <table class="distable am-u-sm-6 am-u-sm-centered">
                <tr >
                    <td colspan="2" >
                        <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                            <span class="am-input-group-label">公司名称</span>
                            <input type="text" class="am-form-field" id="company_name" onkeyup="checkCompanyName()" name="company_name" placeholder="公司名称"><span id="newcompanyname"></span>
                        </div></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                            <span class="am-input-group-label">公司电话</span>
                            <input type="text" class="am-form-field" id="company_tel"   name="company_tel"  placeholder="公司电话"onkeyup="clearNewTelTest();testTel()"><span id="newcompanytel"></span>
                        </div></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                            <span class="am-input-group-label">公司地址</span>
                            <input type="text" class="am-form-field" id="company_address" onkeyup="checkCompanyAddress()"  name="company_address"  placeholder="公司地址"><span id="newcompanyaddress"></span>
                        </div></td>
                </tr>

                <tr> <td><button style="width: 100%"  class="am-btn am-btn-default am-btn-xs am-text-secondary" id="company_submit" name="sumbit" onclick="checkcompany();submitTestTel()">提交</button></td></tr>

            </table>
        
    </div>
</div>

<!--详细页面 客户公司块(end) -->
<div class="am-popup" id="my-popup1">
    <div class="am-popup-inner">
        <div class="am-popup-hd">
            <h4 class="am-popup-title">编辑</h4>
            <span data-am-modal-close
                  class="am-close">&times;</span>
        </div>
        <div class="am-popup-bd" >
                    </div>
        <div id="detailedInfo">
            <table class="distable am-u-sm-6 am-u-sm-centered">

                <tr style="display: none"><td>公司id:</td><td><input type="text" name="company_id" class="company_id_alter"  /></td></tr>

                <tr>
                    <td colspan="2">
                        <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                            <span class="am-input-group-label">公司名称</span>
                            <input type="text" class="am-form-field company_name_alter"  name="company_name" id="company_name_alter" onkeyup="checkAll();checkCompanyName()"  value="lll" disabled="disabled"><span id="checkcompanyname"></span>
                        </div></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                            <span class="am-input-group-label">公司电话</span>
                            <input type="text" class="am-form-field company_tel_alter"  name="company_tel" id="company_tel_alter" onkeyup="checkAll();checkCompanyTel()" value="lll" disabled="disabled"><span id="checkcompanytel"></span>
                        </div></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                            <span class="am-input-group-label">公司地址</span>
                            <input type="text" class="am-form-field company_address_alter"  name="company_address" id="company_address_alter"  onkeyup="checkAll();checkCompanyAddress()"value="lll" disabled="disabled"><span id="checkcompanyaddress"></span>
                        </div></td>
                </tr>
                <tr>
                    <td colspan="2">
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
        </div>
    </div>
</div>


<!--详细内容表格(end)，默认display=none-->
<script type="text/javascript" src="assets/js/companyForm.js"></script>
<?PHP
require_once 'View/footer.php';
?>