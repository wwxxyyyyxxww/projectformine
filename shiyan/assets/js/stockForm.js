var page_index = 1; //当前的页数
var all_page = 1; //总共的页面
var num_index = 0; //数据库查询的的限制条件(从第"page_index"行开始)
var inputValue = $("#materialSearchInput").val();//定义input的输入框内的初始值
var input = $("#materialSearchInput1").val();
window.onload = function () {
    //第一次加载页面的时候对传给数据库的查询条件限制，从第一条数据开始，查询全部数据，input为空，无where值
    get_order_info(num_index, inputValue);
    get_pandian_info(num_index, input);
};
//加载列表，定义函数（）
function get_order_info(num_index, input) {

//    用post方法将js从html获取的数据传送到php文件
    $.post("Models/stockModel.php", {
        num_index: num_index,
        input: input
    }, function (data) {
        returnValue = JSON.parse(data);
        //改变页面页数
        all_page = Math.ceil(returnValue.digit / 6);
        if (all_page == 0) {
            all_page += 1;
        }

        var span1 = "第" + page_index + "页 /共" + all_page + "页";
        $("#pageTableSpan1").html(span1);

//                每一页的input值赋空
        $('#orderTable tr td input').val("");

//循环赋值
        for (i = 0; i <= 5; i++) {
            $(".name").eq(i).val(returnValue.outputArrays[2 * i]);
            $(".number").eq(i).val(returnValue.outputArrays[2 * i + 1])
        }
    });
}

//点击下一页按钮
$("#pageTableButton2").click(function () {
    var inputValue = $("#materialSearchInput").val();

    if (page_index < all_page) {
        num_index += 6;
        page_index++;
        get_order_info(num_index, inputValue);
    } 
});

//点击上一页按钮
$("#pageTableButton1").click(function () {
    var inputValue = $("#materialSearchInput").val();

    if (page_index > 1) {
        num_index -= 6;
        page_index--;
        get_order_info(num_index, inputValue);
    }
})
//点击跳转按钮
$("#pageTableButton3").click(function () {
    var inputValue = $("#materialSearchInput").val();
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
        get_order_info(num_index, inputValue);
        $("#pageTableInput").val("");
    }
});



//点击实现搜索功能
function search_material() {
    page_index = 1;
    num_index = 0;
    var inputValue = $("#materialSearchInput").val();
    get_order_info(num_index, inputValue);
}




function monthlyBalance() {
    $.post("Models/autoClear.php", {}, function (data) {
    });
    $(".new").remove();
    $("#month").css('display', 'block');
    $.post("Models/monthlyBalance.php", {

    }, function (data) {
        return_month_info = JSON.parse(data);
        for (var i = 0; i < return_month_info.digit; i++) {
            var current = "<tr class='new'><td><input type='text' class='monthlyBalanceInput' disabled='disable' value='" + return_month_info.info[i][0] + "'></td><td><input type='text' class='monthlyBalanceInput' disabled='disable' value='" + return_month_info.info[i][1] + "'><td><input type='text' disabled='disabled' onkeyup='get_pandian_info()' class='monthlyBalanceInput' value='" + return_month_info.info[i][2] + "'></td><td><input type='text' class='monthlyBalanceInput'  disabled='disable' value='" + return_month_info.info[i][3] + "'></tr>";
            $("#monthBalanceThis").append(current);
//
//            });
        }

    });
}

function get_pandian_info(num_index, input) {
    $.post("Models/repertory.php", {
        num_index: num_index,
        input: input
    }, function (data) {
//        alert(data);
        return_month_info = JSON.parse(data);
        //改变页面页数
        all_page = Math.ceil(returnValue.digit / 6);
        if (all_page == 0) {
            all_page += 1;
        }

        var span2 = "第" + page_index + "页 /共" + all_page + "页";
        $("#pageTableSpan2").html(span2);

//                每一页的input值赋空
        $('#orderTable tr td input').val("");
//        alert(return_month_info.materialName);
//循环赋值
        for (i = 0; i <= 5; i++) {
            $(".stockName").eq(i).val(return_month_info.materialName[i]);
            $(".stockNum").eq(i).val(return_month_info.currentNum[i]);
            $(".realNum").eq(i).val(return_month_info.currentNum[i]);
        }

    });
}
for (var i = 0; i < 6; i++) {
    $("#" + i).on("click", function () {
        $material_name = $(this).parent().parent().children().eq(0).children().val();
//        alert($material_name);
        $current = $(this).parent().parent().children().eq(1).children().val();
//        alert($current);
        $real = $(this).parent().parent().children().eq(2).children().val();
//        alert($real);
        $difference = parseInt($real) - parseInt($current);
//        alert($difference);
        $.post("Models/settleAccounts.php", {
            num: $real,
            difnum: $difference,
            name: $material_name
        }, function (data) {
            get_pandian_info(num_index, input);
//                    alert(data);
        });
    });
}

//搜索功能
function search_material1() {
    page_index = 1;
    num_index = 0;
    var input = $("#materialSearchInput1").val();
    get_pandian_info(num_index, input);

}
//点击下一页按钮
$("#pageTableButton5").click(function () {
    var input = $("#materialSearchInput1").val();
    if (page_index < all_page) {
        num_index += 6;
        page_index++;
        get_pandian_info(num_index, input);
    } else
        alert("已到最后一页");
});

//点击上一页按钮
$("#pageTableButton4").click(function () {
    var input = $("#materialSearchInput1").val();
    if (page_index > 1) {
        num_index -= 6;
        page_index--;
        get_pandian_info(num_index, input);
    } else
        alert("已到第一页")
})
//点击跳转按钮
$("#pageTableButton6").click(function () {
    var input = $("#materialSearchInput1").val();
    var index = $("#pageTableInput1").val();
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
        get_pandian_info(num_index, input);
        $("#pageTableInput").val("");
    }
});
//搜索框为空时查询全部
$("#materialSearchInput").on("keyup", function () {
    var inputValue = $("#materialSearchInput").val();
    if (inputValue == "") {
        num_index = 0;
        page_index = 1;
        get_order_info(num_index, inputValue);
    }
});

//盘点搜索框为空时查询全部
$("#materialSearchInput1").on("keyup", function () {
    var inputValue = $("#materialSearchInput1").val();
    if (inputValue == "") {
        num_index = 0;
        page_index = 1;
        get_pandian_info(num_index, input);
    }
});



