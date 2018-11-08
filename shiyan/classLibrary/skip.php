<?PHP
function skip($pageTableButton1,$pageTableButton2,$pageTableButton3){
echo <<< EOT
 <div class="am-u-md-6 am-u-md-centered  am-u-sm-12 am-u-sm-centered">
<div id="pageTable" class="pageTable">
    <!--页底上一页下一页跳转按钮-->
    <span id="pageTableSpan1" style="left:20%;"></span>
    <button class="am-btn am-btn-default am-btn-xs am-text-secondary" id="$pageTableButton1">上一页</button>
    <button class="am-btn am-btn-default am-btn-xs am-text-secondary" id="$pageTableButton2">下一页</button>
    <span style="left:61%;width:8%;">跳转到第</span>
    <input id="pageTableInput" type="text" style="left:68%;width:15px;" />
    <span style="left:71%; width:2%;">页</span>
    <button class="am-btn am-btn-default am-btn-xs am-text-secondary" id="$pageTableButton3">跳转</button>
</div>
</div>
EOT;
}
        ?>