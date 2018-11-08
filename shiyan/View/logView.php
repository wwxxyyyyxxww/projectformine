<!doctype html>
<?PHP
require_once 'View/head.php';
?> 
<!--表单顶部内容(start)-->
<div class="am-fl am-cf">
    <strong class="am-text-primary am-text-lg">日志</strong> /
    <small>log</small>
</div>
<hr>


<div class="am-g">           
    <div class="am-u-sm-12 am-u-md-4">
        <div class="am-form-group">
            <select data-am-selected="{btnSize: 'sm'}" name="search"  id="logSearch">
                <option value="all">全部</option>
                <option value="operate_time">操作时间</option>
                <option value="operate_user">操作人员</option>
                <option value="operate">操作内容</option>
            </select>
        </div>
    </div>
    <!--搜索按钮和搜索框-->
            <?PHP
    require_once 'classLibrary/searchbutton.php';
    searchbutton("SearchInput", "SearchButton", "search_log()")
    ?>
    <!--</form>-->
</div>
<!--form表单(end)-->




<!--数据库翻页内容(包含表头，以及从数据库搜索的内容和翻页功能)-->
<div class="am-g" id="orderDiv1" >
    <div class="am-u-md-12  am-u-sm-6 am-u-sm-centered am-u-md-uncentered am-form" style="position: relative;width:100%">
        <table  id="logTable" style="position: relative;width:100%">
            <!--class="am-table am-table-striped am-table-hover table-main"-->
            <thead>
            <th class="table-author">操作时间</th>
            <th class="table-author">操作人员</th>
            <th class="table-author">操作内容</th>
            </thead>
            <!--循环输出每行tr  共六行-->
            <?PHP
            for ($i = 0; $i < 6; $i++) {
                echo <<<SUI
                                        <tr>
                                        <td><input  type='text' disabled='disabled' value="" class="table_time"></td>
                                        <td><input  type='text' disabled='disabled' value="" class="table_user" style="cursor:hand"></td>
                                        <td><input  type='text' disabled='disabled' value="" class="table_operate"></td>
                                    </tr>
                                        
SUI;
            }
            ?>

        </table>
    </div>
<br>
<!--底部上一页下一页和跳转-->
<?PHP
            require_once 'classLibrary/skip.php';
             skip("pageTableButton1","pageTableButton2","pageTableButton3");
?>
</div>
<script type="text/javascript" src="assets/js/log.js"></script>
<?PHP
require_once 'View/footer.php';
?>


