var page_index = 1; //当前的页数
var all_page = 1; //总共的页面
var num_index = 0; //数据库查询的的限制条件(从第"page_index"行开始)
var searchValue = $("#factorySearch").val();//定义select里面的初始值
var inputValue = $("#factorySearchInput").val();//定义input的输入框内的初始值
window.onload = function () {
    //第一次加载页面的时候对传给数据库的查询条件限制，从第一条数据开始，查询全部数据，input为空，无where值
    get_factory_info(num_index, "all", inputValue);
};
//加载列表，定义函数（）
function get_factory_info(num_index, type, input) {
//    用post方法将js从html获取的数据传送到php文件
    $.post("Models/factoryFormModel.php", {
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
            $('#factoryTable tr td input').val("");
            //创建一个新数组，存储从php传过来的值
            var arr_factory_info = new Array();
            //定义的a使下面选择器从第一行开始
            var a = 1;
            //让数组从第一个值开始接收传值
            b = 0;
            //循环将php传回数据添加到数组中
            for (var i = 0; i < returnValue.outputArrays.length; i++) {
                arr_factory_info[b] = returnValue.outputArrays[i];
                b++;
                //当b=5的倍数时，表示页面表格的第一行结束，进行下面操作
                if (b % 5 == 0) {
                    for (var k = 0; k < 5; k++) {
                        //如果数组中的某一个值没有，则给该位置添加一个null值
                        if (arr_factory_info[k] == null || arr_factory_info[k] == "") {
                            arr_factory_info[k] = "null";
                        }
                        //a定义的是1，k定义的是0;所欲从第一个tr，第一个td开始赋值(内容是数组中的4个值)
                        $('#factoryTable tr:nth-of-type(' + a + ') td:nth-of-type(' + k + ') input').val(arr_factory_info[k]);
                    }
                    //给每一个tr附加一个value值
//                        $('#orderTable tr:nth-of-type(' + a + ')').attr("value", arr_order_info[0]);
                    b = 0;
                    a++;
                }

            }
        } else {
            alert(data);
        }
    });
}//点击上一页按钮
$("#pageTableButton2").click(function () {
    var searchValue = $("#factorySearch").val();
    var inputValue = $("#factorySearchInput").val();
    if (page_index < all_page) {
        num_index += 6;
        page_index++;
        get_factory_info(num_index, searchValue, inputValue);
    } else
        alert("已到最后一页");
});
//点击上一页按钮
$("#pageTableButton1").click(function () {
    var searchValue = $("#factorySearch").val();
    var inputValue = $("#factorySearchInput").val();
    if (page_index > 1) {
        num_index -= 6;
        page_index--;
        get_factory_info(num_index, searchValue, inputValue);
    } else
        alert("已到第一页")
})
//点击跳转按钮
$("#pageTableButton3").click(function () {
    var searchValue = $("#factorySearch").val();
    var inputValue = $("#factorySearchInput").val();
    var index = $("#pageTableInput").val();
    if (index == "")
        alert("请输入跳转到那一页！");
    else if (isNaN(index))
        alert("输入有误！");
    else if (index < 1 || index > all_page)
        alert("跳转范围有误！")
    else if (index == page_index)
        alert("您已在当前页面！")
    else {
        num_index = (index - 1) * 6;
        page_index = index;
        get_factory_info(num_index, searchValue, inputValue);
        $("#pageTableInput").val("");
    }
});
//点击实现搜索功能
function search_factory() {
    page_index = 1;
    num_index = 0;
    var searchValue = $("#factorySearch").val();
    var inputValue = $("#factorySearchInput").val();
    get_factory_info(num_index, searchValue, inputValue);
}

//删除功能
function deleteit(obj) {
    var delete_factory = "delete";
    var finished_factory_name = $(".finished_factory_name_alter").val();
    var message = confirm("你确定删除么？");
    if (message == true)
    {
        $.post("Models/factoryForm_delete.php", {
            finished_factory_name: finished_factory_name,
            type: delete_factory
        }, function (data) {
            if (data == 1) {
                alert("删除成功");
                location.href = "http://localhost/shiyan/index.php?page=factoryView";
            } else
                alert(data);
        });
    } else if (message == false) {
        //
        return false;
    }
    // 执行数据库操作然后刷新页面
}

function detail(obj) {
//查找订单编号
    var finished_factory_name = $(obj).parent().parent().children().eq(0).children().val();
    console.log(obj);
    $.post("Models/factoryForm_detail.php", {

        "finished_factory_name": finished_factory_name,
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
                $('#detailedInfo tr td input').val("");
                //创建一个新数组，存储从php传过来的值
                // 操作DOM
                document.querySelector("#detailedInfo").querySelector('input[name="finished_factory_id"]').value = resObj.data[0];
                document.querySelector("#detailedInfo").querySelector('input[name="finished_factory_name"]').value = resObj.data[1];
                document.querySelector("#detailedInfo").querySelector('input[name="factory_responsable_name"]').value = resObj.data[2];
                document.querySelector("#detailedInfo").querySelector('input[name="factory_tel"]').value = resObj.data[3];
                document.querySelector("#detailedInfo").querySelector('input[name="finished_factory_address"]').value = resObj.data[4];

            }
        } else {
            // 查询失败
        }
    });
    //显示详细信息界面
       document.getElementById('detailedInfo').style.display = 'block';
    $("#detailedInfo").find("input").prop("disabled", true);
    document.getElementById("save").disabled = false;
    document.getElementById("checkfactoryname").innerHTML = "";
    document.getElementById("checkresponsablename").innerHTML = "";
    document.getElementById("checkfactorytel").innerHTML = "";
    document.getElementById("checkfactoryaddress").innerHTML = "";
}
//点击保存实现修改功能
$("#save").click(function () {
    $("#detailedInfo").find("input").not(".finished_factory_name_alter").attr("disabled", "disabled");
    var finished_factory_name = $(".finished_factory_name_alter").val();
    var finished_factory_id = $(".finished_factory_id_alter").val();
    var factory_responsable_name = $(".factory_responsable_name_alter").val();
    var factory_tel = $(".factory_tel_alter").val();
    var finished_factory_address = $(".finished_factory_address_alter").val();
    var message = confirm("你确定修改吗？");
    if (message == true) {
        if (finished_factory_name == "")
        {}
        else if (factory_responsable_name == "")
             {}
        else if (factory_tel == "")
             {}
        else if (finished_factory_address == "")
           {}
        else {
            $.post("Models/factoryForm_alter.php", {
                finished_factory_id: finished_factory_id,
                finished_factory_name: finished_factory_name,
                factory_responsable_name: factory_responsable_name,
                factory_tel: factory_tel,
                finished_factory_address: finished_factory_address
            }, function (data) {
                if (data == 1) { //数据库中没有数据，验证失败
                    alert("加工厂信息修改成功！");
                    window.location.href = "http://localhost/shiyan/index.php?page=factoryView";
                } else if (data == 2) {
                    alert("加工厂信息修改失败！");
                } else
                    alert("加工厂名称不能重复！");
            });
        }
    } else if (message == false) {
        return false;
    }
});


//添加页面的显示
function addView() {
    document.getElementById('orderlight').style.display = 'block';
}

function orderlightClose() {
    
    $('#my-popup tr td input').val("");
    document.getElementById("newfinishedfactoryname").innerHTML = "";
    document.getElementById("newfactoryresponsablename").innerHTML = "";
    document.getElementById("newfactorytel").innerHTML = "";
    document.getElementById("newfinishedfactoryaddress").innerHTML = "";
}
//将除第一个输入框之外的输入框变为可输入
function alterit() {
    $("#detailedInfo").find("input").removeAttr("disabled");
}

//判断加工厂名称是否为空
function checkFactoryName() {
    var Absorbname = document.getElementById("finished_factory_name_alter");
    var Absorbnewname = document.getElementById("finished_factory_name");
    if (Absorbname.value.length < 1) {
        document.getElementById("checkfactoryname").innerHTML = "<font size='1' color='red'>请输入加工厂名称！</font>";
        document.getElementById("save").disabled = true;
    } else {
        document.getElementById("checkfactoryname").innerHTML = "";
    }
    if (Absorbnewname.value.length < 1) {
        document.getElementById("newfinishedfactoryname").innerHTML = "<font size='1' color='red'>请输入加工厂名称！</font>";
    } else {
        document.getElementById("newfinishedfactoryname").innerHTML = "";
    }
}
//判断加工厂负责人名称是否为空
function checkResponsableName() {
    var Absorbresponsablename = document.getElementById("factory_responsable_name_alter");
    var Absorbnewresponsablename = document.getElementById("factory_responsable_name");
    if (Absorbresponsablename.value.length < 1) {
        document.getElementById("checkresponsablename").innerHTML = "<font size='1' color='red'>请输入负责人名称!</font>";
        document.getElementById("save").disabled = true;
    } else {
        document.getElementById("checkresponsablename").innerHTML = "";
    }
    if (Absorbnewresponsablename.value.length < 1) {
        document.getElementById("newfactoryresponsablename").innerHTML = "<font size='1' color='red'>请输入负责人名称!</font>";
    } else {
        document.getElementById("newfactoryresponsablename").innerHTML = "";

    }
}
//判断详细页面加工厂电话是否为空和提示
function checkFactoryTel() {
    {
        var Absorbfactorytel = document.getElementById("factory_tel_alter");
        var pattern = $(document.getElementById("factory_tel_alter")).val();
        var patrnphone = /^(0[0-9]{2,3}\-)([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$/
        var patrnmobile = /^(0|86|17951)?(13[0-9]|15[012356789]|17[01678]|18[0-9]|14[57])[0-9]{8}$/
        if (!patrnphone.test(pattern) && !patrnmobile.test(pattern) && Absorbfactorytel.value.length > 1) {
            document.getElementById("checkfactorytel").innerHTML = "<font size='1' color='red'>必须为固定电话或手机号格式!</font>";
            document.getElementById("save").disabled = true;
        } else if (!patrnphone.test(pattern) | !patrnmobile.test(pattern) && Absorbfactorytel.value.length > 1) {
            document.getElementById("checkfactorytel").innerHTML = "";
        } else {
            document.getElementById("checkfactorytel").innerHTML = "<font size='1' color='red'>请输入加工厂电话！</font>";
            document.getElementById("save").disabled = true;
        }
    }
}
//判断加工厂地址是否为空
function checkFactoryAddress() {
    var Absorbfactoryaddress = document.getElementById("finished_factory_address_alter");
    var Absorbnewfactoryaddress = document.getElementById("finished_factory_address");
    if (Absorbfactoryaddress.value.length < 1) {
        document.getElementById("checkfactoryaddress").innerHTML = "<font size='1' color='red'>请输入加工厂地址!</font>";
        document.getElementById("save").disabled = true;
    } else {
        document.getElementById("checkfactoryaddress").innerHTML = "";
    }
    if (Absorbnewfactoryaddress.value.length < 1) {
        document.getElementById("newfinishedfactoryaddress").innerHTML = "<font size='1' color='red'>请输入加工厂地址!</font>";
    } else {
        document.getElementById("newfinishedfactoryaddress").innerHTML = "";
    }
}
//新增加工厂时点击提交按钮判断各列是否为空
function checkFactory() {
    var Absorbnewfinishedfactoryname = document.getElementById("finished_factory_name");
    var Absorbnewfactoryresponsablename = document.getElementById("factory_responsable_name");
    var Absorbnewfactorytel = document.getElementById("factory_tel");
    var Absorbnewfinishedfactoryaddress = document.getElementById("finished_factory_address");
    if (Absorbnewfinishedfactoryname.value.length < 1) {
        document.getElementById("newfinishedfactoryname").innerHTML = "<font size='1' color='red'>请输入加工厂名称！</font>";
    } else {
        document.getElementById("newfinishedfactoryname").innerHTML = "";
    }
    if (Absorbnewfactoryresponsablename.value.length < 1) {
        document.getElementById("newfactoryresponsablename").innerHTML = "<font size='1' color='red'>请输入负责人名称！</font>";
    } else {
        document.getElementById("newfactoryresponsablename").innerHTML = "";
    }
    if (Absorbnewfactorytel.value.length < 1) {
        document.getElementById("newfactorytel").innerHTML = "<font size='1' color='red'>请输入加工厂联系方式！</font>";
    } else {
        document.getElementById("newfactorytel").innerHTML = "";
    }
    if (Absorbnewfinishedfactoryaddress.value.length < 1) {
        document.getElementById("newfinishedfactoryaddress").innerHTML = "<font size='1' color='red'>请输入加工厂地址！</font>";
    } else {
        document.getElementById("newfinishedfactoryaddress").innerHTML = "";
    }
}
//判断电话号码规范规范的话可以新增
function checkFactel() {
    var pattern = document.getElementById("factory_tel").value;
    var patrnphone = /^(0[0-9]{2,3}\-)([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$/
    var patrnmobile = /^(0|86|17951)?(13[0-9]|15[012356789]|17[01678]|18[0-9]|14[57])[0-9]{8}$/
    if (!patrnphone.test(pattern) && !patrnmobile.test(pattern)) {
        document.getElementById("newfactorytel").innerHTML = "<font size='1' color='red'>必须为固定电话或手机号格式!</font>";
    } else {
        document.getElementById("newfactorytel").innerHTML = "";
        var finished_factory_name = $("#finished_factory_name").val();
        var factory_responsable_name = $("#factory_responsable_name").val();
        var factory_tel = $("#factory_tel").val();
        var finished_factory_address = $("#finished_factory_address").val();
        if (finished_factory_name == "") {
        } else if (factory_responsable_name == "") {
        } else if (factory_tel == "") {
        } else if (finished_factory_address == "") {
        } else {
            $.post("Models/factory_add.php", {
                finished_factory_name: finished_factory_name,
                factory_responsable_name: factory_responsable_name,
                factory_tel: factory_tel,
                finished_factory_address: finished_factory_address
            }, function (data) {
                if (data == 1) {
                    alert("加工厂添加成功");
                    window.location.href = "http://localhost/shiyan/index.php?page=factoryForm";
                } else
                    alert("加工厂名称重复！");
            });
        }
    }
}
//新增页面输入电话号码的时候不要提示
function clearNewTelTest() {
    document.getElementById("newfactorytel").innerHTML = "";
}
//详细页面保存按钮是否可用取决于各项规范不
function checkAll() {
    var Absorbfactory_name = document.getElementById("finished_factory_name_alter");
    var Absorbresponsable_name = document.getElementById("factory_responsable_name_alter");
    var Absorbfactory_tel = document.getElementById("factory_tel_alter").value;
    var Absorbfinished_factory_address = document.getElementById("finished_factory_address_alter");
    var patrnphone = /^(0[0-9]{2,3}\-)([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$/
    var patrnmobile = /^(0|86|17951)?(13[0-9]|15[012356789]|17[01678]|18[0-9]|14[57])[0-9]{8}$/
    if ((Absorbfactory_name.value.length > 0) && (Absorbresponsable_name.value.length > 0) && (Absorbfinished_factory_address.value.length > 0) && (patrnmobile.test(Absorbfactory_tel) | (patrnphone.test(Absorbfactory_tel))))
    {
        document.getElementById("save").disabled = false;
    } else {
        document.getElementById("save").disabled = true;
    }
}
//检查联系方式是不是为空
function testTel(){
      var Absorbnewfactorytel = document.getElementById("factory_tel");
     if (Absorbnewfactorytel.value.length < 1) {
        document.getElementById("newfactorytel").innerHTML = "<font size='1' color='red'>请输入加工厂联系方式！</font>";
    } else {
        document.getElementById("newfactorytel").innerHTML = "";
    }
}



$("#factorySearchInput").on("keyup", function () {
    var inputValue = $("#factorySearchInput").val();
    if (inputValue == "") {
        num_index = 0;
        page_index = 1;
        get_factory_info(num_index, "all", inputValue);
    }
});