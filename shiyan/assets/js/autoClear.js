
window.onload = function () {
    autoClear();
};
var myDate = new Date();
var s = myDate.getDate();
function autoClear() {
    if (s == 1) {
        $.post("Models/autoClear.php", {}, function (data) {
        });
        
    }
}