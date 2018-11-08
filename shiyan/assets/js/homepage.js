//主页面的AJAX

$(document).ready(function(){
    //页面加载完成后调用post方法
      $.post("Models/homePageModel.php",function(data){
          //将回调回来的json信息进行解码
        returnValue = JSON.parse(data);
        $(".orderNumber").val(returnValue.orderNumber);
        $(".distribute").val(returnValue.distribute);
        $(".userNumber").val(returnValue.userNumber);
        $(".customerNumber").val(returnValue.customerNumber);
        $(".plantNumber").val(returnValue.plantNumber);
    })
});

window.onload = function () {
alertMonth();
};
function alertMonth() {
    var myDate = new Date();
    var day = myDate.getDate(); 
    if(day=="21"){
    $(".ll").css('display', 'block');
    }
}
//
//function home_message(){
// 
//}


