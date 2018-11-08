
var page_index = 1; //当前的页数
var all_page = 1; //总共的页面
var num_index = 0; //数据库查询的的限制条件(从第"page_index"行开始)
var searchValue = $("#orderSearch").val();//定义select里面的初始值
var inputValue = $("#orderSearchInput").val();//定义input的输入框内的初始值

window.onload = function () {
    //第一次加载页面的时候对传给数据库的查询条件限制，从第一条数据开始，查询全部数据，input为空，无where值
    get_order_info(num_index, "all", inputValue);
    get_company_info();
};

//加载列表，定义函数（）
function get_order_info(num_index, type, input) {
//    用post方法将js从html获取的数据传送到php文件
    $.post("Models/orderFormModel.php", {
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
            $('#orderTable tr td input').val("");
            //创建一个新数组，存储从php传过来的值
            var arr_order_info = new Array();
            //定义的a使下面选择器从第一行开始
            var a = 1;
            //让数组从第一个值开始接收传值
            b = 0;
            //循环将php传回数据添加到数组中
            for (var i = 0; i < returnValue.outputArrays.length; i++) {
                arr_order_info[b] = returnValue.outputArrays[i];
                b++;
                //当b=8的倍数时，表示页面表格的第一行结束，进行下面操作
                if (b % 8 == 0) {
                    for (var k = 0; k < 8; k++) {
                        //如果数组中的某一个值没有，则给该位置添加一个null值
                        if (arr_order_info[k] == null || arr_order_info[k] == "") {
                            arr_order_info[k] = "null";
                        }
                        //a定义的是1，k定义的是0;所欲从第一个tr，第一个td开始赋值(内容是数组中的8个值)
                        $('#orderTable tr:nth-of-type(' + a + ') td:nth-of-type(' + k + ') input').val(arr_order_info[k]);
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
    var searchValue = $("#orderSearch").val();
    var inputValue = $("#orderSearchInput").val();
    if (page_index < all_page) {
        num_index += 6;
        page_index++;
        get_order_info(num_index, searchValue, inputValue);
    }
});

//点击上一页按钮
$("#pageTableButton1").click(function () {
    var searchValue = $("#orderSearch").val();
    var inputValue = $("#orderSearchInput").val();
    if (page_index > 1) {
        num_index -= 6;
        page_index--;
        get_order_info(num_index, searchValue, inputValue);
    }
})
//点击跳转按钮
$("#pageTableButton3").click(function () {
    var searchValue = $("#orderSearch").val();
    var inputValue = $("#orderSearchInput").val();
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
        get_order_info(num_index, searchValue, inputValue);
        $("#pageTableInput").val("");
    }
});

//点击实现搜索功能
function search_order() {
    page_index = 1;
    num_index = 0;
    var searchValue = $("#orderSearch").val();
    var inputValue = $("#orderSearchInput").val();
    get_order_info(num_index, searchValue, inputValue);

}
//修改功能
$("#save").click(function () {
    $("#detailedInfo").find("input").not(".order_serial_number_alter").attr("disabled", "disabled");
    var order_serial_number = $(".order_serial_number_alter").val();
    var material_name = $(".material_name_alter").val();
    var material_number = $(".material_number_alter").val();
    var product_name = $(".product_name_alter").val();
    var select_name = $(".select_name_alter").val();
    var responsable_name = $(".responsable_name_alter").val();
    var responsable_tel = $(".responsable_tel_alter").val();
    var end_time = $(".end_time_alter").val();
    var dead_time = $(".dead_time_alter").val();
    var status_code = $(".status_code_alter").val();
    var order_note = $(".note_alter").val();
    var message = confirm("你确定修改吗？");
    if (message == true) {
        if (order_serial_number == "") {
        } else if (material_name == "") {
        } else if (material_number == "") {
        } else if (product_name == "") {
        } else if (select_name == "") {
        } else if (responsable_name == "") {
        } else if (responsable_tel == "") {
        } else if (end_time == "") {
        } else if (dead_time == "") {
        } else {
            $.post("Models/orderForm_alter.php", {
                order_serial_number: order_serial_number,
                material_name: material_name,
                material_number: material_number,
                product_name: product_name,
                select_name: select_name,
                responsable_name: responsable_name,
                responsable_tel: responsable_tel,
                end_time: end_time,
                dead_time: dead_time,
                status_code: status_code,
                order_note: order_note
            }, function (data) {
                if (data == 1) { //数据库中没有数据，验证失败
                    alert("订单修改成功");
                    window.location.href = "http://localhost/shiyan/index.php?page=orderForm";
                } else if (data == 2) {
                    alert("订单修改失败");
                } else
                    alert(data);
            });
        }
    } else if (message == false) {
        return false;
    }
});


//删除功能
function deleteit(obj) {
    var delete_order = "delete";
    var order_serial_number = $(".order_serial_number_alter").val();
    var material_name = $(".material_name_alter").val();
    var material_number = $(".material_number_alter").val();
    var message = confirm("你确定删除么？");
    if (message == true)
    {
        $.post("Models/orderForm_delete.php", {
            order_serial_number: order_serial_number,
            material_name: material_name,
            material_number: material_number,
            type: delete_order
        }, function (data) {
            if (data == 1) {
                alert("删除成功");
                location.href = "http://localhost/shiyan/index.php?page=orderForm";
            } else if (data = "lack") {
                alert("删除失败，库存数量不足，请更改库存后再次删除");
            } else {
                alert("数据库计算出错");
            }
        });
    } else if (message == false) {
        //
        return false;
    }
    // 执行数据库操作然后刷新页面
}

//查询详细的界面
function detail(obj) {
//查找订单编号
    var order_serial_number = $(obj).parent().parent().children().eq(0).children().val();
    $.post("Models/orderForm_detail.php", {
        "order_serial_number": order_serial_number,
        "type": "detailit"
    }, function (data) {
        var resObj = JSON.parse(data);
        if (resObj.error == 0)
        {
            // 查询成功
            if (resObj.data.length > 0)
            {
                // 有数据
                console.log(resObj.data);
                returnValue = resObj.data;
                //赋空值
                $('#my-detailedInfo tr td input').val("");
                //创建一个新数组，存储从php传过来的值
                // 操作DOM
                document.querySelector("#detailedInfo").querySelector('input[name="order_serial_number"]').value = resObj.data[0];
                document.querySelector("#detailedInfo").querySelector('input[name="material_name"]').value = resObj.data[1];
                document.querySelector("#detailedInfo").querySelector('input[name="material_number"]').value = resObj.data[2];
                document.querySelector("#detailedInfo").querySelector('input[name="product_name"]').value = resObj.data[3];
                document.querySelector("#detailedInfo").querySelector('input[name="company_name"]').value = resObj.data[4];
                document.querySelector("#detailedInfo").querySelector('input[name="responsable_name"]').value = resObj.data[5];
                document.querySelector("#detailedInfo").querySelector('input[name="responsable_tel"]').value = resObj.data[6];
                document.querySelector("#detailedInfo").querySelector('input[name="end_time"]').value = resObj.data[7];
                document.querySelector("#detailedInfo").querySelector('input[name="dead_time"]').value = resObj.data[8];
                document.querySelector("#detailedInfo").querySelector('input[name="status_code"]').value = resObj.data[9];
                document.querySelector("#detailedInfo").querySelector('input[name="note"]').value = resObj.data[10];
            }
        } else {
            // 查询失败
        }
    });
    //显示详细信息界面
    document.getElementById('detailedInfo').style.display = 'block';

    document.getElementById("checkname").innerHTML = "";
    document.getElementById("checknumber").innerHTML = "";
    document.getElementById("checkproduct").innerHTML = "";
    document.getElementById("checkselectname").innerHTML = "";
    document.getElementById("checkresponsablename").innerHTML = "";
    document.getElementById("checktel").innerHTML = "";
    document.getElementById("checkendtime").innerHTML = "";
    document.getElementById("checkdeadtime").innerHTML = "";
    document.getElementById("statuscodealter").innerHTML = "";


    $("#detailedInfo").find("input").prop("disabled", true);
    document.getElementById("save").disabled = false;
}


//动态添加select的option选项函数，在界面加载完成后运行
function get_company_info() {
    $.post("Models/get_company_info.php", {
    }, function (data) {
        //解析传回的值
        return_company_info = JSON.parse(data);

        var get_company_info = new Array();
        var company_num = 0;
        for (j = 0; j < return_company_info.length; j++) {
            get_company_info[company_num] = return_company_info[j];
            //动态创建option的具体代码new Option(a,b):a为option的可显示内容,b为option的value值
            document.getElementById("select_name").options.add(new Option(get_company_info[company_num], get_company_info[company_num]));

        }
    });
}

//分配界面
function distribute(obj) {
    var order_serial_number = $(obj).parent().parent().children().eq(0).children().val();

    $.post('Models/get_distribute_info.php', {
        order_serial_number: order_serial_number
    }, function (data) {
        return_data = JSON.parse(data);
        $(".distribute_order_serial_number").val(return_data[0]);
        $(".distribute_meterial_name").val(return_data[1]);
        $(".distribute_product_name").val(return_data[2]);
        $(".distribute_meterial_number").val(return_data[3]);
        $(".distribute_leave_number").val(return_data[4]);

    });
    document.getElementById('distributeTable').style.display = 'block';
}

//分配页面的关闭
function distributeClose() {
    document.getElementById('distributeTable').style.display = 'none';
    $(".factory_number").val("");
    $(".add_tr").remove();
}

//新增关闭清空数据
function orderlightClose() {
    $('#my-popup tr td input').val("");
    $('#my-popup tr td select').val("");
    document.getElementById("newmaterialname").innerHTML = "";
    document.getElementById("newmaterialnumber").innerHTML = "";
    document.getElementById("newproductname").innerHTML = "";
    document.getElementById("newselectname").innerHTML = "";
    document.getElementById("newresponsablename").innerHTML = "";
    document.getElementById("newresponsabletel").innerHTML = "";
    document.getElementById("newendtime").innerHTML = "";
    document.getElementById("newdeadtime").innerHTML = "";
}
//将除第一个输入框之外的输入框变为可输入
function alterit(obj) {
    $("#detailedInfo").find("input").not(".order_serial_number_alter").removeAttr("disabled");
}

function send(obj) {
    //获取当前状态值，以便判断接下来的操作
    var status = $(obj).parent().parent().children().eq(5).children().val();
    if (status == 1) {
        var order_serial_number = $(obj).parent().parent().children().eq(0).children().val();
        var product_name = $(obj).parent().parent().children().eq(3).children().val();
        $.post("Models/sendOrder.php", {
            "order_serial_number": order_serial_number,
            "product_name": product_name
        }, function (data) {
            if (data == 1) {
                location.href = "http://localhost/shiyan/index.php?page=orderForm";
            } else {
                alert("库存数量不够，请修改库存后重新发送该订单");
            }
        });
    } else {
        alert("尚未完成，不可发送");
    }
}
$("#orderSearchInput").on("keyup", function () {
    var inputValue = $("#orderSearchInput").val();
    if (inputValue == "") {
        num_index = 0;
        page_index = 1;
        get_order_info(num_index, "all", inputValue);
    }
});//检查原料名称是否为空
function checkName() {
    var Absorbname = document.getElementById("material_name_alter");
    var Absorbnewname = document.getElementById("material_name");
    if (Absorbname.value.length < 1) {
        document.getElementById("checkname").innerHTML = "<font size='1' color='red'>请输入原料名称！</font>";
        document.getElementById("save").disabled = true;
    } else {
        document.getElementById("checkname").innerHTML = "";
    }
    if (Absorbnewname.value.length < 1) {
        document.getElementById("newmaterialname").innerHTML = "<font size='1' color='red'>请输入原料名称！</font>";
    } else {
        document.getElementById("newmaterialname").innerHTML = "";
    }
}

//检查原料数量是否为空
function checkNumber() {
    var Absorbnumber = document.getElementById("material_number_alter");
    var Absorbnewnumber = document.getElementById("material_number");
    if (Absorbnumber.value.length < 1) {
        document.getElementById("checknumber").innerHTML = "<font size='1' color='red'>请输入原料数量！</font>";
        document.getElementById("save").disabled = true;
    } else {
        document.getElementById("checknumber").innerHTML = "";
    }
    if (Absorbnewnumber.value.length < 1) {
        document.getElementById("newmaterialnumber").innerHTML = "<font size='1' color='red'>请输入原料数量！</font>";

    } else {
        document.getElementById("newmaterialnumber").innerHTML = "";
    }

}
//检查产品名称是否为空
function checkProduct() {
    var Absorbproduct = document.getElementById("product_name_alter");
    var Absorbnewproduct = document.getElementById("product_name");
    if (Absorbproduct.value.length < 1) {
        document.getElementById("checkproduct").innerHTML = "<font size='1' color='red'>请输入产品名称！</font>";
        document.getElementById("save").disabled = true;
    } else {
        document.getElementById("checkproduct").innerHTML = "";
    }
    if (Absorbnewproduct.value.length < 1) {
        document.getElementById("newproductname").innerHTML = "<font size='1' color='red'>请输入产品名称！</font>";
    } else {
        document.getElementById("newproductname").innerHTML = "";
    }
}
//检查负责人电话是否为空
function checkResponsableName() {
    var Absorbresponsablename = document.getElementById("responsable_name_alter");
    var Absorbnewresponsablename = document.getElementById("responsable_name");
    if (Absorbresponsablename.value.length < 1) {
        document.getElementById("checkresponsablename").innerHTML = "<font size='1' color='red'>请输入负责人名称！</font>";
        document.getElementById("save").disabled = true;
    } else {
        document.getElementById("checkresponsablename").innerHTML = "";
    }
    if (Absorbnewresponsablename.value.length < 1) {
        document.getElementById("newresponsablename").innerHTML = "<font size='1' color='red'>请输入负责人名称！</font>";
    } else {
        document.getElementById("newresponsablename").innerHTML = "";
    }
}
//检查详细页面电话号码规范与否
function checkTel() {
    {
        var Absorbtel = document.getElementById("responsable_tel_alter");
        var pattern = $(document.getElementById("responsable_tel_alter")).val();
        var patrnphone = /^(0[0-9]{2,3}\-)([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$/
        var patrnmobile = /^(0|86|17951)?(13[0-9]|15[012356789]|17[01678]|18[0-9]|14[57])[0-9]{8}$/
        if (!patrnphone.test(pattern) && !patrnmobile.test(pattern) && Absorbtel.value.length > 1) {
            document.getElementById("checktel").innerHTML = "<font size='1' color='red'>必须为固定电话或手机号格式!</font>";
            document.getElementById("save").disabled = true;
        } else if
                (!patrnphone.test(pattern) | !patrnmobile.test(pattern) && Absorbtel.value.length > 1)
        {
            document.getElementById("checktel").innerHTML = "";
        } else {
            document.getElementById("checktel").innerHTML = "<font size='1' color='red'>请输入公司电话！</font>";
            document.getElementById("save").disabled = true;
        }
    }
}
//检查详细页面公司名称
function checkCompanyName() {
    var Absorbcode = document.getElementById("select_name_alter");
    if (Absorbcode.value.length < 1) {
        document.getElementById("checkselectname").innerHTML = "<font size='1' color='red'>请输入公司名称！</font>";
        document.getElementById("save").disabled = true;
    } else {
        document.getElementById("checkselectname").innerHTML = "";
    }
}
//检查到期时间是是否为空
function checkEndTime() {
    var Absorbendtime = document.getElementById("end_time_alter");
    var Absorbnewendtime = document.getElementById("end_time");
    if (Absorbendtime.value.length < 1) {
        document.getElementById("checkendtime").innerHTML = "<font size='1' color='red'>请输入到期时间！</font>";
        document.getElementById("save").disabled = true;
    } else {
        document.getElementById("checkendtime").innerHTML = "";

    }
    if (Absorbnewendtime.value.length < 1) {
        document.getElementById("newendtime").innerHTML = "<font size='1' color='red'>请输入到期时间！</font>";

    } else {
        document.getElementById("newendtime").innerHTML = "";

    }


}
//检查截止时间是否为空
function checkDeadTime() {
    var Absorbdeadtime = document.getElementById("dead_time_alter");
    var Absorbnewdeadtime = document.getElementById("dead_time");
    if (Absorbdeadtime.value.length < 1) {
        document.getElementById("checkdeadtime").innerHTML = "<font size='1' color='red'>请输入截止时间！</font>";
        document.getElementById("save").disabled = true;
    } else {
        document.getElementById("checkdeadtime").innerHTML = "";
    }
    if (Absorbnewdeadtime.value.length < 1) {
        document.getElementById("newdeadtime").innerHTML = "<font size='1' color='red'>请输入截止时间！</font>";

    } else {
        document.getElementById("newdeadtime").innerHTML = "";
    }


}
//检查状态码是否为空
function checkStatusCode() {
    var Absorbcode = document.getElementById("status_code_alter");
    if (Absorbcode.value.length < 1) {
        document.getElementById("statuscodealter").innerHTML = "<font size='1' color='red'>请输入状态！</font>";
        document.getElementById("save").disabled = true;
    } else {
        document.getElementById("statuscodealter").innerHTML = "";
    }
}
//检查新增订单各行是否为空
function checkorder() {
    var Absorbnewname = document.getElementById("material_name");
    var Absorbnewnumber = document.getElementById("material_number");
    var Absorbnewproduct = document.getElementById("product_name");
    var Absorbnewselect = $('#select_name option:selected').val();
    var Absorbnewresponsablename = document.getElementById("responsable_name");
    var Absorbnewresponsabletel = document.getElementById("responsable_tel");
    var Absorbnewendtime = document.getElementById("end_time");
    var Absorbnewdeadtime = document.getElementById("dead_time");
    if (Absorbnewname.value.length < 1) {
        document.getElementById("newmaterialname").innerHTML = "<font size='1' color='red'>原料名称不能为空！</font>";
    } else {
        document.getElementById("newmaterialname").innerHTML = "";
    }
    if (Absorbnewnumber.value.length < 1) {
        document.getElementById("newmaterialnumber").innerHTML = "<font size='1' color='red'>原材料数量不能为空！</font>";
    } else {
        document.getElementById("newmaterialnumber").innerHTML = "";
    }
    if (Absorbnewproduct.value.length < 1) {
        document.getElementById("newproductname").innerHTML = "<font size='1' color='red'>成品名称不能为空！</font>";
    } else {
        document.getElementById("newproductname").innerHTML = "";
    }
    if (Absorbnewresponsablename.value.length < 1) {
        document.getElementById("newresponsablename").innerHTML = "<font size='1' color='red'>负责人名称不能为空！</font>";
    } else {
        document.getElementById("newresponsablename").innerHTML = "";
    }
    if (Absorbnewresponsabletel.value.length < 1) {
        document.getElementById("newresponsabletel").innerHTML = "<font size='1' color='red'>负责人电话不能为空！</font>";
    } else {
        document.getElementById("newresponsabletel").innerHTML = "";
    }
    if (Absorbnewendtime.value.length < 1) {
        document.getElementById("newendtime").innerHTML = "<font size='1' color='red'>到期时间不能为空！</font>";
    } else {
        document.getElementById("newendtime").innerHTML = "";
    }
    if (Absorbnewdeadtime.value.length < 1) {
        document.getElementById("newdeadtime").innerHTML = "<font size='1' color='red'>截止日期不能为空！</font>";
    } else {
        document.getElementById("newdeadtime").innerHTML = "";
    }
    if (Absorbnewselect == "") {
        document.getElementById("newselectname").innerHTML = "<font size='1' color='red'>客户公司不能为空！</font>";
    } else {
        document.getElementById("newselectname").innerHTML = "";
    }

}
//检查新增页面选择客户公司是否为空
function  checkselect() {
    var Absorbnewselect = $('#select_name option:selected').val();
    if (Absorbnewselect == "") {
        document.getElementById("newselectname").innerHTML = "<font size='1' color='red'>客户公司不能为空！</font>";
    } else {
        document.getElementById("newselectname").innerHTML = "";
    }


}
//检查新增负责人电话规范与否，规范的话可以新增
function checkRestel() {
    var pattern = $(document.getElementById("responsable_tel")).val();
    var patrnphone = /^(0[0-9]{2,3}\-)([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$/
    var patrnmobile = /^(0|86|17951)?(13[0-9]|15[012356789]|17[01678]|18[0-9]|14[57])[0-9]{8}$/
    if (!patrnphone.test(pattern) && !patrnmobile.test(pattern)) {
        document.getElementById("newresponsabletel").innerHTML = "<font size='1' color='red'>必须为固定电话或手机号格式!</font>";
    } else {
        document.getElementById("newresponsabletel").innerHTML = "";
        var material_name = $("#material_name").val();
        var material_number = $("#material_number").val();
        var product_name = $("#product_name").val();
        var select_name = $('#my-popup').find('#select_name').val();
        var responsable_name = $("#responsable_name").val();
        var responsable_tel = $("#responsable_tel").val();
        var end_time = $("#end_time").val();
        var dead_time = $("#dead_time").val();
        var order_note = $("#order_note").val();
        if (material_name == "") {
        } else if (material_number == "") {
        } else if (product_name == "") {
        } else if (select_name == "") {
        } else if (responsable_name == "") {
        } else if (responsable_tel == "") {
        } else {
            $.post("Models/orderForm_add.php", {
                material_name: material_name,
                material_number: material_number,
                product_name: product_name,
                select_name: select_name,
                responsable_name: responsable_name,
                responsable_tel: responsable_tel,
                end_time: end_time,
                dead_time: dead_time,
                order_note: order_note
            }, function (data) {
                if (data == 0) { //数据库中没有数据，验证失败
                    alert("失败");
                } else if (data == 1) {
                    alert("订单添加成功");
                    window.location.href = "http://localhost/shiyan/index.php?page=orderForm";
                } else
                    alert(data);
            });
        }
    }

}
//新增时输入电话号码的时候不要提示
function clearNewTelTest() {
    document.getElementById("newresponsabletel").innerHTML = "";
}
//检查个项是否合格规范，规范的话保存按钮可用
function checkAll() {
    var material_name = document.getElementById("material_name_alter");
    var material_number = document.getElementById("material_number_alter");
    var product_name = document.getElementById("product_name_alter");
    var select_name = document.getElementById("select_name_alter");
    var responsable_name = document.getElementById("responsable_name_alter");
    var end_time = document.getElementById("end_time_alter");
    var dead_time = document.getElementById("dead_time_alter");
    var status_code = document.getElementById("status_code_alter");
    var responsable_tel = document.getElementById("responsable_tel_alter").value;
    var patrnphone = /^(0[0-9]{2,3}\-)([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$/
    var patrnmobile = /^(0|86|17951)?(13[0-9]|15[012356789]|17[01678]|18[0-9]|14[57])[0-9]{8}$/
    if ((material_name.value.length > 0) &&
            (material_number.value.length > 0) &&
            (product_name.value.length > 0) &&
            (patrnmobile.test(responsable_tel) | (patrnphone.test(responsable_tel))) &&
            (select_name.value.length > 0) &&
            (responsable_name.value.length > 0) &&
            (end_time.value.length > 0) &&
            (dead_time.value.length > 0) &&
            (status_code.value.length > 0))
    {
        document.getElementById("save").disabled = false;
    } else {
        document.getElementById("save").disabled = true;
    }

}
//点击input框是取消提示截止时间
function checkdeadTime() {
    WdatePicker({dateFmt: 'yyyy-MM-dd', minDate: '#F{$dp.$D(\'dead_time\')}'})
    document.getElementById("newdeadtime").innerHTML = "";
      document.getElementById("checkdeadtime").innerHTML = "";
}
//点击input框是取消提示到期时间
function checkendtime() {
    WdatePicker({dateFmt: 'yyyy-MM-dd', maxDate: '#F{$dp.$D(\'end_time\')}'});
    document.getElementById("newendtime").innerHTML = "";
     document.getElementById("checkendtime").innerHTML = "";
}