$(document).ready(function() {
    //to remove animations while loading page
    $("body").removeClass("preload");

    //to display the size menu
    $(".toggle-icon").click(function() {
        $(".header-ul-list").toggleClass("side-nav");
        var e = $(".toggle-icon i").hasClass("fa-bars");
        if (e) {
            $(".toggle-icon").html(" <i class='fa fa-times' aria-hidden='true'></i>");
        } else {
            $(".toggle-icon").html(" <i class='fa fa-bars' aria-hidden='true'></i>");
        }
    });

    //to change main text
    var w = $(this).width();
    if (w < 768) $(".header-left-box h1").text("STUDENT CELL");

    //to display forget password btn
    $("#forget-password-btn").click(function(e) {
        e.preventDefault();
        $(".forget-password-box").addClass("display-forget-password-box");
        $(".otp-box").css("display", "none");
        $(".pass-box").css("display", "none");
        $(".get-otp-box").css("display", "block");
        $(".pass-change-box").css("display", "none");
        f_pass_error_display("", 0);
    });
    $("#close-password-box").click(function() {
        $(".forget-password-box").removeClass("display-forget-password-box");
        $("#password-change-btn").html("Update Password");
        $("#get-otp-btn").html("Get OTP");
    });
});
