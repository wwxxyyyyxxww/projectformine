
var page_index = 1; //当前的页数
var all_page = 1; //总共的页面
var num_index = 0; //数据库查询的的限制条件(从第"page_index"行开始)
var searchValue = $("#workSearch").val();//定义select里面的初始值
var inputValue = $("#workSearchInput").val();//定义input的输入框内的初始值

window.onload = function () {
    //第一次加载页面的时候对传给数据库的查询条件限制，从第一条数据开始，查询全部数据，input为空，无where值
    get_work_info(num_index, "all", inputValue);

};

//加载列表，定义函数（）
function get_work_info(num_index, type, input) {
//    用post方法将js从html获取的数据传送到php文件

    $.post("Models/workFormModel.php", {
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

//            $.getJSON("assets/user.json", function (data) { //从服务器读取json文件
//                每一页的input值赋空
            $('#workTable tr td input').val("");

            //创建一个新数组，存储从php传过来的值
            var arr_work_info = new Array();
            //定义的a使下面选择器从第一行开始
            var a = 1;
            //让数组从第一个值开始接收传值
            b = 0;
            //循环将php传回数据添加到数组中
            for (var i = 0; i < returnValue.outputArrays.length; i++) {
                arr_work_info[b] = returnValue.outputArrays[i];
                b++;

                //当b=5的倍数时，表示页面表格的第一行结束，进行下面操作
                if (b % 9 == 0) {
                    for (var k = 0; k < 9; k++) {
                        //如果数组中的某一个值没有，则给该位置添加一个null值
                        if (arr_work_info[k] == null || arr_work_info[k] == "") {
                            arr_work_info[k] = "null";
                        }
                        //a定义的是1，k定义的是0;所欲从第一个tr，第一个td开始赋值(内容是数组中的8个值)
                        $('#workTable tr:nth-of-type(' + a + ') td:nth-of-type(' + k + ') input').val(arr_work_info[k]);
                    }
                    //给每一个tr附加一个value值
//                        $('#orderTable tr:nth-of-type(' + a + ')').attr("value", arr_order_info[0]);
                    b = 0;
                    a++;
                }

            }
//            })

        } else {
            alert(data);
        }
    });
}

//点击下一页按钮
$("#pageTableButton2").click(function () {
    var searchValue = $("#workSearch").val();
    var inputValue = $("#workSearchInput").val();

    if (page_index < all_page) {
        num_index += 6;
        page_index++;

        get_work_info(num_index, searchValue, inputValue);


    } else
        alert("已到最后一页");
});

//点击上一页按钮
$("#pageTableButton1").click(function () {

    var searchValue = $("#workSearch").val();
    var inputValue = $("#workSearchInput").val();

    if (page_index > 1) {
        num_index -= 6;
        page_index--;
        get_work_info(num_index, searchValue, inputValue);
    } else
        alert("已到第一页")
})
//点击跳转按钮
$("#pageTableButton3").click(function () {
    var searchValue = $("#workSearch").val();
    var inputValue = $("#workSearchInput").val();
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
        get_work_info(num_index, searchValue, inputValue);
        $("#pageTableInput").val("");
    }
});

//点击实现搜索功能
function search_work() {
    page_index = 1;
    num_index = 0;
    var searchValue = $("#workSearch").val();
    var inputValue = $("#workSearchInput").val();
    get_work_info(num_index, searchValue, inputValue);

}
//点击添加按钮
$("#work_submit").click(function () {
    var work_serial_number = $("#work_serial_number").val();
    var work_name = $("#work_name").val();
    var work_tel = $("#work_tel").val();
    var work_address = $("#work_address").val();


    if (work_serial_number == "")
        alert("材料名称不能为空");
    else if (work_name == "")
        alert("原材料数量不能为空");
    else if (work_tel == "")
        alert("产品名称不能为空");
    else if (work_address == "")
        alert("公司名称不能为空");
    else {
        $.post("Models/work_add.php", {
            work_serial_number: work_serial_number,
            work_name: work_name,
            work_tel: work_tel,
            work_address: work_address,
        }, function (data) {
            if (data == 0) { //数据库中没有数据，验证失败
                alert("失败");
            } else if (data == 1) {
                alert("订单添加成功");
                window.location.href = "http://localhost/shiyan/index.php?page=customerForm";
            } else
                alert(data);
        });
    }

});

function save(obj) {
    var order_serial_number = $(obj).parent().parent().children().children().eq(0).val();
    var finished_factory_name = $(obj).parent().parent().children().children().eq(1).val();
    var material_name = $(obj).parent().parent().children().children().eq(2).val();
    var distribute_number = $(obj).parent().parent().children().children().eq(3).val();
    var product_name = $(obj).parent().parent().children().children().eq(4).val();
    var expect_number = $(obj).parent().parent().children().children().eq(5).val();
    var finish_number = $(obj).parent().parent().children().children().eq(6).val();
    var message = confirm("你确定修改吗？");
    if (message == true) {
        $("input").attr("disabled", "disabled");
        if (finished_factory_name == "")
            alert("工厂名称不能为空");
        else if (material_name == "")
            alert("材料名称不能为空");
        else if (distribute_number == "")
            alert("分配数量不能为空");
        else if (product_name == "")
            alert("产品名称不能为空");
        else if (expect_number == "")
            alert("期望数量不能为空");
        else if (finish_number == "")
            alert("实际数量不能为空");
        else {
            $.post("Models/workForm_alter.php", {
                order_serial_number: order_serial_number,
                finished_factory_name: finished_factory_name,
                material_name: material_name,
                distribute_number: distribute_number,
                product_name: product_name,
                expect_number: expect_number,
                finish_number: finish_number
            }, function (data) {
                if (data == 1) { //数据库中没有数据，验证失败
                    alert("订单修改成功");
                    window.location.href = "http://localhost/shiyan/index.php?page=workView";
                } else if (data == 2) {
                    alert("订单修改失败");
                } else
                    alert(data);
            });
        }
    } else if (message == false) {
        return false;
    }
}
;
//根据期望值和实际数量判断订单是否完成
function finishWork(obj) {
    var order_serial_number = $(obj).parent().parent().children().children().eq(0).val();
    var product_name = $(obj).parent().parent().children().children().eq(4).val();
    var expect_number = parseInt($(obj).parent().parent().children().children().eq(5).val());
    var finish_number = parseInt($(obj).parent().parent().children().children().eq(6).val());
    if (expect_number == finish_number) {
        //此处期望值与实际数量相等，
        $.post("Models/workFinishButton.php",
                {
                    product_name: product_name,
                    order_serial_number: order_serial_number,
                    finish_number: finish_number},
                function (data) {
                    if (data == 1) {
                        window.location.href = "http://localhost/shiyan/index.php?page=workView";
                    } else {
                        alert(data);
                    }
                })
    } else {
        var message = confirm("期望值与实际数量不相等，是否继续?");
        if (message = true) {
//            alert("这儿还没做...");
        }
    }
}
//分配界面
function distribute(obj) {
    var order_serial_number = $(obj).parent().parent().children().children().eq(0).val();
    var finished_factory_name = $(obj).parent().parent().children().children().eq(1).val();
    var material_name = $(obj).parent().parent().children().children().eq(2).val();
    var product_name = $(obj).parent().parent().children().children().eq(4).val();
    $(".workAdd_order_serial_number").val(order_serial_number);
    $(".workAdd_meterial_name").val(material_name);
    $(".workAdd_factory_name").val(finished_factory_name);
    $(".workAdd_product_name").val(product_name);
    document.getElementById('distributeTable').style.display = 'block';

}
function submit_distribute() {
    alert("a");
    var order_serial_number = $(".workAdd_order_serial_number").val();
    var finished_factory_name = $(".workAdd_factory_name").val();
    var material_name = $(".workAdd_meterial_name").val();
    var material_num = $(".workAdd_meterial_number").val();
    var product_name = $(".workAdd_product_name").val();
    var product_num = $(".workAdd_product_number").val();
    $.post('Models/workDistribute.php', {
        finished_factory_name: finished_factory_name,
        material_name: material_name,
        material_num: material_num,
        product_name: product_name,
        product_num: product_num,
        order_serial_number: order_serial_number
    }, function (data) {

        if (data == 1) {
            window.location.href = "http://localhost/shiyan/index.php?page=workView";
        }else{
            alert(data);
        }

    });
}


function detail(obj) {
    $.each($(obj).parent().siblings().children(), function (a, b) {
        b.removeAttribute('disabled');
    });
    $(obj).parent().siblings().eq(0).children().attr("disabled", "true");
    $(obj).parent().siblings().eq(1).children().attr("disabled", "true");
    $(obj).parent().siblings().eq(2).children().attr("disabled", "true");
    $(obj).parent().siblings().eq(3).children().attr("disabled", "true");
    $(obj).parent().siblings().eq(4).children().attr("disabled", "true");
    $(obj).parent().siblings().eq(7).children().attr("disabled", "true")

}
//搜索框为空时查询全部
$("#workSearchInput").on("keyup",function(){
    var inputValue = $("#workSearchInput").val();
    if(inputValue==""){
        num_index=0;
        page_index=1;
        get_work_info(num_index, "all", inputValue);
    }
});