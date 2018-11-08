<!doctype html>
<?PHP
require_once 'View/head.php';
?> 
<!--用户顶部内容(start)-->
<div class="am-fl am-cf">
    <strong class="am-text-primary am-text-lg">用户</strong> /
    <small>Form</small>
</div>
<hr>

<div class="am-g">
    <div class="am-u-sm-12 am-u-md-4">
        <!--顶部新增按钮-->
        <button type="button" class="am-btn am-btn-default"onclick="userlightClose()" data-am-modal="{target: '#my-popup'}"><span class="am-icon-plus">新增</span></button>
    </div>              
    <!--用户顶部内容(end)-->
    <!--form表单(start)包含select以及搜索框-->
    <!--<form>-->
    <div class="am-u-sm-12 am-u-md-3">
        <div class="am-form-group">
            <select data-am-selected="{btnSize: 'sm'}" name="search"  id="userSearch">
                <option value="all">全部</option>
                <option value="staff_name">用户姓名</option>
                <option value="staff_password">用户密码</option>
                <option value="level">用户级别</option>
            </select>
        </div>
    </div>
    <!--搜索按钮和搜索框-->
    <?PHP
    require_once 'classLibrary/searchbutton.php';
    searchbutton("userSearchInput", "userSearchButton", "search_user()")
    ?>
    <!--</form>-->
</div>
<!--form表单(end)-->
<!--数据库翻页内容(包含表头，以及从数据库搜索的内容和翻页功能)-->
<div class="am-g" id="orderDiv1" >
    <div class="am-u-sm-6 am-u-sm-centered  am-form" style="position: relative;width:100%">
        <table  id="userTable" style="position: relative;width: 100%">
            <thead>
            <th class="table-author">用户姓名</th>
            <th class="table-author">用户密码</th>
            <th class="table-author">用户级别</th>
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
<!--分页表格显示(start)-->
<!--Manage_div2-->
<br>

<!--底部上一页下一页和跳转-->


<!--添加用户的代码-->
<div class="am-popup" id="my-popup" >
    <div class="am-popup-inner">
        <div class="am-popup-hd">
            <h4 class="am-popup-title">添加用户</h4>
            <span data-am-modal-close
                  class="am-close"onclick="userlightClose()">&times;</span>
        </div>
        <div class="am-popup-bd">
            <div id="orderlight" >
                <div class="demo">
                    <form action="" class="am-form" data-am-validator>
                        <fieldset>
                            <table class="distable am-u-sm-6 am-u-sm-centered">
                                <tr>
                                    <td colspan="2">
                                        <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                            <span class="am-input-group-label">用户名称</span>
                                            <input type="text" class="am-form-field" id="staff_name"  name="staff_name" placeholder="用户名称" onkeyup="checkName()"required><span id="newstaffname"></span>
                                        </div></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                            <span class="am-input-group-label">用户密码</span>
                                            <input type="text" class="am-form-field" id="staff_password"  name="staff_password" placeholder="3至8位" minlength="3" maxlength="8" onkeyup="checkPassword()" required><span id="newstaffpassword"></span>
                                        </div></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                            <span class="am-input-group-label">用户级别</span>
                                            <input type="number" class="am-form-field" id="level"  name="level" placeholder="1或2" required onkeyup="clearNewlevelTest()"><span id="newlevel"></span>
                                        </div>
                                    </td>
                                </tr>

                                <tr>   <td><input type="button" style="width: 100%"  class="am-btn am-btn-default am-btn-xs am-text-secondary"id="user_submit" name="sumbit"  onclick="checkuser();checkTestLevel()" value="提交" ></td>
                                    </td></tr>
                            </table>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div


<!-- 用户块(end)，默认display=none -->
<!--详细内容表格(start)，默认display=none-->
<div class="am-popup" id="my-popup1">
    <div class="am-popup-inner">
        <div class="am-popup-hd">
            <h4 class="am-popup-title">编辑用户</h4>
            <span data-am-modal-close
                  class="am-close">&times;</span>
        </div>
        <div class="am-popup-bd"></div>
            <div id="detailedInfo" class=" am-form">
                <table  class="distable am-u-sm-6 am-u-sm-centered">
                    <tr style="display: none"><td>员工id:</td><td><input type="text" name="staff_id" class="staff_id_alter"value="lll" /></td></tr>
                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">员工名称</span>
                                <input type="text" class="am-form-field staff_name_alter" id="staff_name_alter"  name="staff_name" value="lll" disabled="disabled"onkeyup="checkName();checkAll()"><span id="checkname"></span>
                            </div></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">员工密码</span>
                                <input type="text" class="am-form-field staff_password_alter" id="staff_password_alter" name="staff_password" value="lll" disabled="disabled"   minlength="3" maxlength="8" onkeyup="checkPassword();checkAll()"><span id="checkpassword"></span>
                            </div></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered">
                                <span class="am-input-group-label">员工级别</span>
                                <input type="number" class="am-form-field level_alter" id="level_alter"  name="level" value="lll" disabled="disabled" onkeyup="checkLevel();checkAll()"><span id="checklevel"></span>
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
            </div>
       
    </div>
</div>

<!--详细内容表格(end)，默认display=none-->
<script type="text/javascript" src="assets/js/userForm.js"></script>
<?PHP
require_once 'View/footer.php';
?>


