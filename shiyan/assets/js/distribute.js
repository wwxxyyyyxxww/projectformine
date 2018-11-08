//动态生成分配的tr
function show_factory_num() {
    if ($(".distribute_leave_number").val() <= 0) {
        $(this).attr("disabled", "disabled");
        alert("订单已分配完成");
    } else {
        $(".add_tr").remove();
        var num = $(".factory_number").val();
        for (i = 0; i < num; i++)
        {
            $(".distable").append("<tr class='add_tr'>\n\
                                        <td colspan='3'> <div class='am-input-group am-input-group-secondary am-input-group-sm am-u-sm-12 am-u-sm-centered'>\n\
                                         <span class='am-input-group-label'><select class=' select_name1' style='color:black'></select></span>\n\
                                       <span class='am-input-group-label'> <input type='number' class='input_num' style='color:black'></span>\n\
                                        <span class='am-input-group-label'><input type='number' class='expect_num' style='color:black'></span></td></div></tr>");
        }
        get_company_infoa();
    }
}
//给分配界面加工厂分配公司选择
function get_company_infoa() {
    $.post("Models/get_company_info.php", {
//        "get_company_info": company_name
    }, function (data) {
        //解析传回的值
        return_company_info = JSON.parse(data);
        var get_company_info = new Array();
        company_num = 0;
        for (j = 0; j < return_company_info.length; j++) {
            get_company_info[company_num] = return_company_info[j];
            //动态创建option的具体代码new Option(a,b):a为option的可显示内容,b为option的value值
            $(".select_name1").append("<option value='" + get_company_info[company_num] + "'>" + get_company_info[company_num] + "</option>");
            ;
        }

    });
}

//判断分配数量是否大于可分配数量的函数
function sum() {
    var num = $(".distribute_leave_number").val();
    var factory_number = $(".factory_number").val();
    var sum = 0;
    for (i = 0; i < factory_number; i++)
    {
        var number = parseInt($(".input_num").eq(i).val());
        sum = sum + number;
    }

    if (sum > num) {
        alert("分配数量大于实际可分配数量！！！请重新分配");
        $(".input_num").val("");
        $(".expect_num").val("");
    } else if (sum <= num) {
        var message = confirm("请确认分配数据数据！！");
        if (message == true) {
            insert_work();
        } else if (message == false) {
            return false;
        }
    }
}

//插入加工表
function insert_work() {
    var distribute_order_serial_number = $(".distribute_order_serial_number").val();
    var distribute_meterial_name = $(".distribute_meterial_name").val();
    var distribute_product_name = $(".distribute_product_name").val();
    var num = $(".factory_number").val();
    var select_name1 = new Array();
    var input_num = new Array();
    var expect_num = new Array();

    for (i = 0; i < num; i++) {
        select_name1[i] = $(".select_name1").eq(i).val();
        input_num[i] = $(".input_num").eq(i).val();
        expect_num[i] = $(".expect_num").eq(i).val();
    }
    $.post("Models/insert_work.php",
            {
                distribute_order_serial_number: distribute_order_serial_number,
                distribute_meterial_name: distribute_meterial_name,
                distribute_product_name: distribute_product_name,
                select_name1: select_name1,
                input_num: input_num,
                expect_num: expect_num,
                num: num
            }, function (data) {
        if (data == 1) {
            alert("分配成功");
            window.location.href = "http://localhost/shiyan/index.php?page=orderForm";
        } else {
            alert(data);
        }
    });

}

            