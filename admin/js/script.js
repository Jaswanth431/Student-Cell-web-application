//to show and hide the display
$(".toggle-icon").click(function () {
    $(".navigation-list").toggleClass("side-nav");
    var e = $(".toggle-icon i").hasClass("fa-bars");
    if (e) {
        $(".toggle-icon").html(" <i class='fa fa-times' aria-hidden='true'></i>");
    } else {
        $(".toggle-icon").html(" <i class='fa fa-bars' aria-hidden='true'></i>");
    }
});

//to change the text according to the screen height
var w = $(window).width();
if (w < 768) {
    $(".header-left-box h1").html("STUDENT CELL");
}
if (w < 350) {
    $(".user-box").html("");
}
