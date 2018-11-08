var page_index = 1; //当前的页数
var all_page = 1; //总共的页面
var num_index = 0; //数据库查询的的限制条件(从第"page_index"行开始)
var searchValue = $("#companySearch").val();//定义select里面的初始值
var inputValue = $("#companySearchInput").val();//定义input的输入框内的初始值

window.onload = function () {

    //第一次加载页面的时候对传给数据库的查询条件限制，从第一条数据开始，查询全部数据，input为空，无where值
    get_company_info(num_index, "all", inputValue);

};

//加载列表，定义函数（）
function get_company_info(num_index, type, input) {

//    用post方法将js从html获取的数据传送到php文件
    $.post("Models/companyFormModel.php", {
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
            $('#companyTable tr td input').val("");
            //创建一个新数组，存储从php传过来的值
            var arr_company_info = new Array();
            //定义的a使下面选择器从第一行开始
            var a = 1;
            //让数组从第一个值开始接收传值
            b = 0;
            //循环将php传回数据添加到数组中
            for (var i = 0; i < returnValue.outputArrays.length; i++) {
                arr_company_info[b] = returnValue.outputArrays[i];
                b++;
                //当b=5的倍数时，表示页面表格的第一行结束，进行下面操作
                if (b % 4 == 0) {
                    for (var k = 0; k < 4; k++) {
                        //如果数组中的某一个值没有，则给该位置添加一个null值
                        if (arr_company_info[k] == null || arr_company_info[k] == "") {
                            arr_company_info[k] = "null";
                        }
                        //a定义的是1，k定义的是0;所欲从第一个tr，第一个td开始赋值
                        $('#companyTable tr:nth-of-type(' + a + ') td:nth-of-type(' + k + ') input').val(arr_company_info[k]);
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
}
//点击下一页按钮
$("#pageTableButton2").click(function () {
    var searchValue = $("#companySearch").val();
    var inputValue = $("#companySearchInput").val();
    if (page_index < all_page) {
        num_index += 6;
        page_index++;
        get_company_info(num_index, searchValue, inputValue);
    } else
        alert("已到最后一页");
});
//点击上一页按钮
$("#pageTableButton1").click(function () {
    var searchValue = $("#companySearch").val();
    var inputValue = $("#companySearchInput").val();
    if (page_index > 1) {
        num_index -= 6;
        page_index--;
        get_company_info(num_index, searchValue, inputValue);
    } else
        alert("已到第一页")
})
//点击跳转按钮
$("#pageTableButton3").click(function () {
    var searchValue = $("#companySearch").val();
    var inputValue = $("#companySearchInput").val();
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
        get_company_info(num_index, searchValue, inputValue);
        $("#pageTableInput").val("");
    }
});
//点击实现搜索功能
function search_company() {
    page_index = 1;
    num_index = 0;
    var searchValue = $("#companySearch").val();
    var inputValue = $("#companySearchInput").val();
    get_company_info(num_index, searchValue, inputValue);
}

//删除功能
function deleteit(obj) {

    var company_name = $(".company_name_alter").val();
    var message = confirm("你确定删除么？");
    if (message == true)
    {
        $.post("Models/companyForm_delete.php", {
            company_name: company_name,
        }, function (data) {
            if (data == 1) {
                alert("删除成功");
                location.href = "http://localhost/shiyan/index.php?page=companyView";
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
    var company_name = $(obj).parent().parent().children().eq(0).children().val();

    $.post("Models/companyForm_detail.php", {
        "company_name": company_name,
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
              
                document.querySelector("#detailedInfo").querySelector('input[name="company_name"]').value = resObj.data[1];
                document.querySelector("#detailedInfo").querySelector('input[name="company_tel"]').value = resObj.data[2];
                document.querySelector("#detailedInfo").querySelector('input[name="company_address"]').value = resObj.data[3];

            }
        } else {
            // 查询失败
        }
    });
    //显示详细信息界面
    document.getElementById('detailedInfo').style.display = 'block';
    $("#detailedInfo").find("input").prop("disabled", true);
    document.getElementById("checkcompanyname").innerHTML = "";
    document.getElementById("checkcompanytel").innerHTML = "";
    document.getElementById("checkcompanyaddress").innerHTML = "";
    document.getElementById("save").disabled = false;
}
//实现修改功能
$("#save").click(function () {
    var company_id = $(".company_id_alter").val();
    var company_tel = $(".company_tel_alter").val();
    var company_address = $(".company_address_alter").val();
    var company_name = $(".company_name_alter").val();
    var message = confirm("你确定修改吗？");
    if (message == true) {
        if (company_id == "")
        {
        } else if (company_tel == "")
        {
        } else if (company_address == "")
        {
        } else if (company_name == "")
        {
        } else {
            $.post("Models/companyForm_alter.php", {
                company_id: company_id,
                company_name: company_name,
                company_tel: company_tel,
                company_address: company_address
            }, function (data) {
                if (data == 1) { //数据库中没有数据，验证失败
                    alert("客户公司信息修改成功！");
                    window.location.href = "http://localhost/shiyan/index.php?page=companyView";
                } else if (data == 2) {
                    alert("客户公司信息修改失败！");
                } else
                    alert("客户公司名称不能重复！");
            });
        }
    } else if (message == false) {
        return false;
    }
});

//新增页面关闭时清空警告
function orderlightClose() {
    $('#my-popup tr td input').val("");
    document.getElementById("newcompanyname").innerHTML = "";
    document.getElementById("newcompanytel").innerHTML = "";
    document.getElementById("newcompanyaddress").innerHTML = "";
    document.getElementById('my-popup').style.display = 'none';
}
//将除第一个输入框之外的输入框变为可输入
function alterit() {
    $("#detailedInfo").find("input").removeAttr("disabled");
}
//添加页面的显示
function addView() {
    document.getElementById('orderlight').style.display = 'block';
}
//详细的关闭清空警告
function detailedInfoClose() {
    document.getElementById('detailedInfo').style.display = 'none';
    document.getElementById("checkcompanyaddress").innerHTML = "";
    document.getElementById("checkcompanyname").innerHTML = "";
    document.getElementById("checkcompanytel").innerHTML = "";
}
//判断客户公司地址是否为空
function checkCompanyAddress() {
    var Absorbnewcompanyaddress = document.getElementById("company_address");
    var Absorbcompanyaddress = document.getElementById("company_address_alter");
    if (Absorbcompanyaddress.value.length < 1) {
        document.getElementById("checkcompanyaddress").innerHTML = "<font size='1' color='red'>请输入公司地址！</font>";
        document.getElementById("save").disabled = true;
    } else {
        document.getElementById("checkcompanyaddress").innerHTML = "";

    }
    if (Absorbnewcompanyaddress.value.length < 1) {
        document.getElementById("newcompanyaddress").innerHTML = "<font size='1' color='red'>请输入公司地址！</font>";
    } else {
        document.getElementById("newcompanyaddress").innerHTML = "";
    }
}
//判断电话名称是否填写
function checkCompanyName() {
    var Absorbcompanyname = document.getElementById("company_name");
    var Absorbcompanynamealter = document.getElementById("company_name_alter");
    if (Absorbcompanynamealter.value.length < 1) {
        document.getElementById("checkcompanyname").innerHTML = "<font size='1' color='red'>请输入公司名称！</font>";
        document.getElementById("save").disabled = true;
    } else {
        document.getElementById("checkcompanyname").innerHTML = "";

    }
    if (Absorbcompanyname.value.length < 1) {
        document.getElementById("newcompanyname").innerHTML = " <font size='1' color='red'>请输入公司名称！</font>";
    } else {
        document.getElementById("newcompanyname").innerHTML = "";
    }
}
//判断电话号码格式以及是否为空
function checkCompanyTel() {
    {
        var Absorbcompanytel = document.getElementById("company_tel_alter");
        var pattern = $(document.getElementById("company_tel_alter")).val();
        var patrnphone = /^(0[0-9]{2,3}\-)([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$/
        var patrnmobile = /^(0|86|17951)?(13[0-9]|15[012356789]|17[01678]|18[0-9]|14[57])[0-9]{8}$/
        if (!patrnphone.test(pattern) && !patrnmobile.test(pattern) && Absorbcompanytel.value.length > 1) {
            document.getElementById("checkcompanytel").innerHTML = "<font size='1' color='red'>必须为固定电话或手机号格式!</font>";
            document.getElementById("save").disabled = true;
        } else if (!patrnphone.test(pattern) | !patrnmobile.test(pattern) && Absorbcompanytel.value.length > 1) {
            document.getElementById("checkcompanytel").innerHTML = "";
            document.getElementById("save").disabled = false;

        } else {
            document.getElementById("checkcompanytel").innerHTML = "<font size='1' color='red'>请输入加工厂电话！</font>";
            document.getElementById("save").disabled = true;
        }
    }
}
//判断保存按钮是否可用取决于各项条件是否满足
function checkAll() {
    var patrnphone = /^(0[0-9]{2,3}\-)([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$/
    var patrnmobile = /^(0|86|17951)?(13[0-9]|15[012356789]|17[01678]|18[0-9]|14[57])[0-9]{8}$/
    var Absorbcompanyname = document.getElementById("company_name_alter");
    var Absorbcompanytel = document.getElementById("company_tel_alter").value;
    var Absorbcompanyaddress = document.getElementById("company_address_alter");
    if ((Absorbcompanyname.value.length > 0) && (Absorbcompanyaddress.value.length > 0) && (patrnmobile.test(Absorbcompanytel) | (patrnphone.test(Absorbcompanytel))))
    {
        document.getElementById("save").disabled = false;
    } else
    {
        document.getElementById("save").disabled = true;
    }
}
//新增客户公司时点击提交后判断各行是否为空
function checkcompany() {
    var Absorbnewcompanyname = document.getElementById("company_name");
    var Absorbnewcompanytel = document.getElementById("company_tel");
    var Absorbnewnewcompanyaddress = document.getElementById("company_address");
    if (Absorbnewcompanyname.value.length < 1) {
        document.getElementById("newcompanyname").innerHTML = "<font size='1' color='red'>请输入公司名称！</font>";
    } else {
        document.getElementById("newcompanyname").innerHTML = "";
    }
    if (Absorbnewcompanytel.value.length < 1) {
        document.getElementById("newcompanytel").innerHTML = "<font size='1' color='red'>请输入公司电话！</font>";
    } else {
        document.getElementById("newcompanytel").innerHTML = "";
    }
    if (Absorbnewnewcompanyaddress.value.length < 1) {
        document.getElementById("newcompanyaddress").innerHTML = "<font size='1' color='red'>请输入公司地址！</font>";
    } else {
        document.getElementById("newcompanyaddress").innerHTML = "";
    }
}
//提交之后判断电话号码是否规范，规范后才可以新增
function submitTestTel() {
    var pattern = $(document.getElementById("company_tel")).val();
    var patrnphone = /^(0[0-9]{2,3}\-)([2-9][0-9]{6,7})+(\-[0-9]{1,4})?$/
    var patrnmobile = /^(0|86|17951)?(13[0-9]|15[012356789]|17[01678]|18[0-9]|14[57])[0-9]{8}$/
    if (!patrnphone.test(pattern) && !patrnmobile.test(pattern)) {
        document.getElementById("newcompanytel").innerHTML = "<font size='1' color='red'>必须为固定电话或手机号格式!</font>";
        return false;
    } else {
        document.getElementById("newcompanytel").innerHTML = "";
        var company_name = $("#company_name").val();
        var company_tel = $("#company_tel").val();
        var company_address = $("#company_address").val();
        if (company_name == "") {
        } else if (company_tel == "") {
        } else if (company_address == "") {
        } else {
            $.post("Models/company_add.php", {
                company_name: company_name,
                company_tel: company_tel,
                company_address: company_address,
            }, function (data) {
                if (data == 1) {
                    alert("客户公司添加成功!");
                    window.location.href ="http://localhost/shiyan/index.php?page=companyView";
                } else
                    alert("客户名称重复!")
            });
        }
    }
}
//新增时输入手机号时避免提示
function clearNewTelTest() {
    document.getElementById("newcompanytel").innerHTML = "";

}
//检查新增联系方式时候为空
function testTel(){
    var Absorbnewcompanytel = document.getElementById("company_tel");
       if (Absorbnewcompanytel.value.length < 1) {
        document.getElementById("newcompanytel").innerHTML = "<font size='1' color='red'>请输入公司电话！</font>";
    } else {
        document.getElementById("newcompanytel").innerHTML = "";
    }
}



//当输入框为空时重新搜索
$("#companySearchInput").on("keyup", function () {
    var inputValue = $("#companySearchInput").val();
    if (inputValue == "") {
        num_index = 0;
        page_index = 1;
        get_company_info(num_index, "all", inputValue);
    }
});