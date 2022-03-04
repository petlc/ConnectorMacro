$(document).ready(function () {

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });

});

$(document).ready(function () {

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });

});



$(document).ready(function(){
    //$(".form-group-login").hide();
    $(".notif").click(function(){
        $(".notif-grp").fadeToggle("fast");
        $(".badgeNotif").fadeOut("fast");
        $(".request-forms").hide("fast");
        return false;
    });

    $(document).on('click', function(e) {
        $(".notif-grp").hide("fast");
    });

});

$(document).ready(function(){
    //$(".form-group-login").hide();
    $(".rqst-frms").click(function(){
        $(".request-forms").fadeToggle("fast");
        $(".notif-grp").hide("fast");
        return false;
    });

    $(document).on('click', function(e) {
        $(".request-forms").hide("fast");
    });

});

$(".click").click(function() {
  window.location = $(this).find("div a").attr("href");
  return false;
});

function watsup(wat){
    window.location.href= $(wat).attr("value");
}
