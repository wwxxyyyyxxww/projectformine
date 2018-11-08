
var page_index = 1; //当前的页数
var all_page = 1; //总共的页面
var num_index = 0; //数据库查询的的限制条件(从第"page_index"行开始)
var searchValue = $("#logSearch").val();//定义select里面的初始值
var inputValue = $("#SearchInput").val();//定义input的输入框内的初始值

window.onload = function () {
    //第一次加载页面的时候对传给数据库的查询条件限制，从第一条数据开始，查询全部数据，input为空，无where值
    get_log_info(num_index, "all", inputValue);
};

//加载列表，定义函数（）
function get_log_info(num_index, type, input) {
//    用post方法将js从html获取的数据传送到php文件
    $.post("Models/logModel.php", {
        num_index: num_index,
        type: type,
        input: input
    }, function (data) {
        returnValue = JSON.parse(data);
//isNaN检查回调数据是否是一个数字，是=>false，不是=>true,加!与之相反
        if (!isNaN(returnValue.digit)) {
//计算数据库查询数据一共可以分为多少页
            all_page = Math.ceil(returnValue.digit / 6);
            if (all_page == 0) {
                all_page += 1;
            }

            var span1 = "第" + page_index + "页 /共" + all_page + "页";
            $("#pageTableSpan1").html(span1);

//                每一页的input值赋空
            $('#logTable tr td input').val("");
            //创建一个新数组，存储从php传过来的值
            for (i = 0; i <= 5; i++) {
                $(".table_time").eq(i).val(returnValue.outputArrays[3 * i]);
                $(".table_user").eq(i).val(returnValue.outputArrays[3 * i + 1]);
                $(".table_operate").eq(i).val(returnValue.outputArrays[3 * i + 2]);
            }

        } else {
            alert(data);
        }
    });
}

//点击下一页按钮
$("#pageTableButton2").click(function () {
    var searchValue = $("#logSearch").val();
    var inputValue = $("#SearchInput").val();
    if (page_index < all_page) {
        num_index += 6;
        page_index++;
        get_log_info(num_index, searchValue, inputValue);
    } else
        alert("已到最后一页");
});

//点击上一页按钮
$("#pageTableButton1").click(function () {

    var searchValue = $("#logSearch").val();
    var inputValue = $("#SearchInput").val();

    if (page_index > 1) {
        num_index -= 6;
        page_index--;
        get_log_info(num_index, searchValue, inputValue);
    } else
        alert("已到第一页")
})
//点击跳转按钮
$("#pageTableButton3").click(function () {
    var searchValue = $("#logSearch").val();
    var inputValue = $("#SearchInput").val();
    var index = $("#pageTableInput").val();
    if (index == "")
        alert("请输入跳转到那一页");
    else if (isNaN(index))
        alert("输入有误");
    else if (index < 1 || index > all_page)
        alert("跳转范围有误")
    else if (index == page_index)
        alert("您已在当前页面")
    else {
        num_index = (index - 1) * 6;
        page_index = index;
        get_log_info(num_index, searchValue, inputValue);
        $("#pageTableInput").val("");
    }
});


//点击实现搜索功能
function search_log() {
    page_index = 1;
    num_index = 0;
    var searchValue = $("#logSearch").val();
    var inputValue = $("#SearchInput").val();
    get_log_info(num_index, searchValue, inputValue);

}
//当输入框为空时调用查询函数
function check() {
    num_index = 0;
    var inputValue = $("#SearchInput").val();
    if (inputValue == "") {
        get_log_info(num_index, "all", inputValue);
    }
}
