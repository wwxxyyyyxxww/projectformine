var page_index = 1; //当前的页数
var all_page = 1; //总共的页面
var num_index = 0; //数据库查询的的限制条件(从第"page_index"行开始)
var searchValue = $("#userSearch").val();//定义select里面的初始值
var inputValue = $("#userSearchInput").val();//定义input的输入框内的初始值
window.onload = function () {
    //第一次加载页面的时候对传给数据库的查询条件限制，从第一条数据开始，查询全部数据，input为空，无where值
    get_user_info(num_index, "all", inputValue);
};
//加载列表，定义函数（）
function get_user_info(num_index, type, input) {
//    用post方法将js从html获取的数据传送到php文件
    $.post("Models/userFormModel.php", {
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
            $('#userTable tr td input').val("");
            //创建一个新数组，存储从php传过来的值
            var arr_user_info = new Array();
            //定义的a使下面选择器从第一行开始
            var a = 1;
            //让数组从第一个值开始接收传值
            b = 0;
            //循环将php传回数据添加到数组中
            for (var i = 0; i < returnValue.outputArrays.length; i++) {
                arr_user_info[b] = returnValue.outputArrays[i];
                b++;
                //当b=3的倍数时，表示页面表格的第一行结束，进行下面操作
                if (b % 4 == 0) {
                    for (var k = 0; k < 4; k++) {
                        //如果数组中的某一个值没有，则给该位置添加一个null值
                        if (arr_user_info[k] == null || arr_user_info[k] == "") {
                            arr_user_info[k] = "null";
                        }
                        //a定义的是1，k定义的是0;所欲从第一个tr，第一个td开始赋值(内容是数组中的3个值)
                        $('#userTable tr:nth-of-type(' + a + ') td:nth-of-type(' + k + ') input').val(arr_user_info[k]);
                    }
                    //给每一个tr附加一个value值
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
    var searchValue = $("#userSearch").val();
    var inputValue = $("#userSearchInput").val();
    if (page_index < all_page) {
        num_index += 6;
        page_index++;
        get_user_info(num_index, searchValue, inputValue);
    } else
        alert("已到最后一页");
});
//点击上一页按钮
$("#pageTableButton1").click(function () {
    var searchValue = $("#userSearch").val();
    var inputValue = $("#userSearchInput").val();
    if (page_index > 1) {
        num_index -= 6;
        page_index--;
        get_user_info(num_index, searchValue, inputValue);
    } else
        alert("已到第一页")
})
//点击跳转按钮
$("#pageTableButton3").click(function () {
    var searchValue = $("#userSearch").val();
    var inputValue = $("#userSearchInput").val();
    var index = $("#pageTableInput").val();
    if (index == "")
        alert("请输入跳转到那一页!");
    else if (isNaN(index))
        alert("输入有误！");
    else if (index < 1 || index > all_page)
        alert("跳转范围有误！")
    else if (index == page_index)
        alert("您已在当前页面！")
    else {
        num_index = (index - 1) * 6;
        page_index = index;
        get_user_info(num_index, searchValue, inputValue);
        $("#pageTableInput").val("");
    }
});
//点击实现搜索功能
function search_user() {
    page_index = 1;
    num_index = 0;
    var searchValue = $("#userSearch").val();
    var inputValue = $("#userSearchInput").val();
    get_user_info(num_index, searchValue, inputValue);
}

//删除功能
function deleteit(obj) {
    var staff_name = $(".staff_name_alter").val();
    var message = confirm("你确定删除么？");
    if (message == true)
    {
        $.post("Models/userForm_delete.php", {
            staff_name: staff_name,
        }, function (data) {
            if (data == 1) {
                alert("删除成功！");
                location.href = "http://localhost/shiyan/index.php?page=userView";
            } else
                alert(data);
        });
    } else if (message == false) {
        return false;
    }
    // 执行数据库操作然后刷新页面
}

function detail(obj) {
//查找订单编号
    var staff_name = $(obj).parent().parent().children().eq(0).children().val();
    console.log(obj);
    $.post("Models/userForm_detail.php", {
        "staff_name": staff_name,
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
                document.querySelector("#detailedInfo").querySelector('input[name="staff_id"]').value = resObj.data[0];
                document.querySelector("#detailedInfo").querySelector('input[name="staff_name"]').value = resObj.data[1];
                document.querySelector("#detailedInfo").querySelector('input[name="staff_password"]').value = resObj.data[2];
                document.querySelector("#detailedInfo").querySelector('input[name="level"]').value = resObj.data[3];
            }
        } else {
            // 查询失败
        }
    });
//    //显示详细信息界面
//    document.getElementById('detailedInfo').style.display = 'block';
    document.getElementById("checkname").innerHTML = "";
    document.getElementById("checkpassword").innerHTML = "";
    document.getElementById("checklevel").innerHTML = "";
    document.getElementById('detailedInfo').style.display = 'block';
    $("#detailedInfo").find("input").prop("disabled", true);
    document.getElementById("save").disabled = false;
}
//点击保存，实现修改事件
$("#save").click(function () {
    var staff_id = $(".staff_id_alter").val();
    var staff_name = $(".staff_name_alter").val();
    var staff_password = $(".staff_password_alter").val();
    var level = $(".level_alter").val();
    var message = confirm("你确定修改吗？");
    if (message == true) {
        if (staff_name == "")
        {
        } else if (staff_password == "")
        {
        } else if (staff_id == "")
        {
        } else if (level == "")
        {
        } else {
            $.post("Models/userForm_alter.php", {
                staff_id: staff_id,
                staff_name: staff_name,
                staff_password: staff_password,
                level: level
            }, function (data) {
                if (data == 1) { //数据库中没有数据，验证失败
                    alert("用户信息修改成功！");
                    //刷新页面
                    window.location.href = "http://localhost/shiyan/index.php?page=userView";
                } else if (data == 2) {
                    alert("用户信息修改失败!");
                } else
                    alert("用户名称不能重复！");
            });
        }
    } else if (message == false) {
        return false;
    }
});
//将除第一个输入框之外的输入框变为可输入
function alterit() {
    $("#detailedInfo").find("input").removeAttr("disabled");
}
//关闭新增页面的时候清空痕迹
function userlightClose() {
    document.getElementById('my-popup').style.display = 'none';

    $("#my-popup").find("input").not("#user_submit").val("");

    document.getElementById("newstaffname").innerHTML = "";
    document.getElementById("newstaffpassword").innerHTML = "";
    document.getElementById("newlevel").innerHTML = "";
}

//检查用户名
function checkName() {
    var Absorbname = document.getElementById("staff_name_alter");
    var Absorbnewname = document.getElementById("staff_name");
    if (Absorbname.value.length < 1) {
        document.getElementById("checkname").innerHTML = "<font size='1' color='red'>员工名称不能为空！</font>";
        document.getElementById("save").disabled = true;
    } else {
        document.getElementById("checkname").innerHTML = "";
        document.getElementById("save").disabled = true;
    }
    if (Absorbnewname.value.length < 1) {
        document.getElementById("newstaffname").innerHTML = "<font size='1' color='red'>请输入员工名称！</font>";
    } else {
        document.getElementById("newstaffname").innerHTML = "";
    }
}
//判断新增或者详细页面员工密码是否合格并且判断位数
function checkPassword() {
    var Absorbpassword = document.getElementById("staff_password_alter");
    var Absorbnewpassword = document.getElementById("staff_password");
    if (Absorbpassword.value.length < 1) {
        document.getElementById("checkpassword").innerHTML = "<font size='1' color='red'>请输入员工密码！</font>";
        document.getElementById("save").disabled = true;
    } else if (Absorbpassword.value.length > 0 && Absorbpassword.value.length < 3) {
        document.getElementById("checkpassword").innerHTML = "<font size='1' color='red'>员工密码必须大于2位！</font>";
    } else {
        document.getElementById("checkpassword").innerHTML = "";
    }
    if (Absorbnewpassword.value.length < 1) {
        document.getElementById("newstaffpassword").innerHTML = "<font size='1' color='red'>请输入员工密码！</font>";
    } else if (Absorbnewpassword.value.length > 0 && Absorbnewpassword.value.length < 3) {
        document.getElementById("newstaffpassword").innerHTML = "<font size='1' color='red'>员工密码必须大于2位！</font>";

    } else {
        document.getElementById("newstaffpassword").innerHTML = "";
    }
}//判断新增或者详细页面员工级别是否为空
function checkLevel() {
    var Absorblevel = document.getElementById("level_alter");
    var Absorbnewlevel = document.getElementById("level");
    if (Absorbnewlevel.value.length < 1) {
        document.getElementById("newlevel").innerHTML = "<font size='1' color='red'>请输入员工级别1或2！</font>";
    } else if (Absorbnewlevel.value.length > 0 && (Absorbnewlevel.value == 1 | Absorbnewlevel.value == 2))
    {
        document.getElementById("newlevel").innerHTML = "";
    } else {
        document.getElementById("newlevel").innerHTML = "<font size='1' color='red'>员工级别必须是1或2！</font>";
    }
    if (Absorblevel.value.length < 1) {
        document.getElementById("checklevel").innerHTML = "<font size='1' color='red'>请输入员工级别1或2！</font>";
    } else if (Absorblevel.value.length > 0 && (Absorblevel.value == 1 | Absorblevel.value == 2))
    {
        document.getElementById("checklevel").innerHTML = "";
    }
}
//新增员工时点击提交按钮判断各列是否为空
function checkuser() {
    var Absorbnewname = document.getElementById("staff_name");
    var Absorbnewpassword = document.getElementById("staff_password");
    var Absorbnewlevel = document.getElementById("level");

    if (Absorbnewname.value.length < 1) {
        document.getElementById("newstaffname").innerHTML = "<font size='1' color='red'>请输入员工名称！</font>";
    } else {
        document.getElementById("newstaffname").innerHTML = "";
    }
    if (Absorbnewpassword.value.length < 1) {
        document.getElementById("newstaffpassword").innerHTML = "<font size='1' color='red'>请输入员工密码！</font>";
    } else {
        document.getElementById("newstaffpassword").innerHTML = "";
    }
    if (Absorbnewlevel.value.length < 1) {
        document.getElementById("newlevel").innerHTML = "<font size='1' color='red'>请输入员工级别！</font>";
    } else {
        document.getElementById("newlevel").innerHTML = "";
    }

}
//详细页面的按钮是否可用取决于各项填写是否合格
//用户名不为空并且密码大于等于6位并且小于等于15位
function checkAll() {
    var Absorbstaff_name = document.getElementById("staff_name_alter");
    var Absorbstaff_password = document.getElementById("staff_password_alter");
    var Absorbstaff_level = document.getElementById("level_alter");
    if ((Absorbstaff_name.value.length > 0) && (Absorbstaff_password.value.length > 2) && (Absorbstaff_level.value == 1 | Absorbstaff_level.value == 2))
    {
        document.getElementById("save").disabled = false;
    } else {
        document.getElementById("save").disabled = true;
    }
}
//输入级别的时候取消提示
function clearNewlevelTest() {
    document.getElementById("newlevel").innerHTML = "";
}

//搜索框为空时查询全部
$("#userSearchInput").on("keyup", function () {
    var inputValue = $("#userSearchInput").val();
    if (inputValue == "") {
        page_index = 1;
        num_index = 0;
        get_user_info(num_index, "all", inputValue);
    }
});
//检查级别格式是不是正确，正确才能新增
function checkTestLevel() {

    var Absorbnewlevel = document.getElementById("level");

    if (Absorbnewlevel.value.length > 0 && (Absorbnewlevel.value == 1 | Absorbnewlevel.value == 2)) {

        var staff_name = $("#staff_name").val();
        var staff_password = $("#staff_password").val();
        var level = $("#level").val();

        if (staff_name == "") {

        } else if (staff_password == "")
        {
        } else if (level == "")
        {
        } else {
            $.post("Models/user_add.php", {
                staff_name: staff_name,
                staff_password: staff_password,
                level: level
            }, function (data) {
                if (data == 0) { //数据库中没有数据，验证失败
                    alert("用户名称已存在");
                } else if (data == 1) {
                    alert("用户添加成功");
                    window.location.href = "http://localhost/shiyan/index.php?page=userView";
                } else
                    alert(data);
            });
        }
    } else {
        document.getElementById("newlevel").innerHTML = "<font size='1' color='red'>用户级别必须为1或2！</font>";
    }
}