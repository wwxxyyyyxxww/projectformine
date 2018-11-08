// 设置主页的iframe宽度高度
document.getElementById("iframe").setAttribute("height",window.innerHeight-50);
document.getElementById("iframe").setAttribute("width",window.innerWidth-260);
// 设置主页的rightIndex
document.getElementById("rightIndex").style.height=(window.innerHeight-50)+"px";
document.getElementById("rightIndex").style.width=(window.innerWidth-260)+"px";
// 用来获取iframe的url的函数
        function geturl(){
            setTimeout(function(){
                alert(parent.document.getElementById("iframe").contentWindow.location.href);
            },1000);
      
        }
//切换iframe和首页的优先级
        $("#leftul>li").on("click",function(){
            $(".rightIndex").css("z-index",-1);
          })
          $("#leftul>li").eq(0).on("click",function(){
            $(".rightIndex").css("z-index",2);
          })
//主页注销按钮
    $("#leftul>li").last().on("click",function(){
             alert("未保存的内容将会被清空，您是否确定要退出");
            window.close();
          })
