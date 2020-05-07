function error_display(text, display) {
    if (display) {
        $(".error-box p").css("opacity", "1");
        $(".error-box p").css("visibility", "visible");
    } else {
        $(".error-box p").css("opacity", "0");
        $(".error-box p").css("visibility", "hidden");
    }
    $(".error-box p").text(text);
}

function f_pass_error_display(text, display) {
    if (display) {
        $(".f-pass-error-box p").css("opacity", "1");
        $(".f-pass-error-box p").css("visibility", "visible");
    } else {
        $(".f-pass-error-box p").css("opacity", "0");
        $(".f-pass-error-box p").css("visibility", "hidden");
    }
    $(".f-pass-error-box p").text(text);
}

function sleep(milliseconds) {
    const date = Date.now();
    let currentDate = null;
    do {
        currentDate = Date.now();
    } while (currentDate - date < milliseconds);
}

$(document).ready(function() {
    //student login
    $("#student-login-btn").click(function(e) {
        e.preventDefault();
        var id = $("#student_id").val();
        var password = $("#student_pass").val();
        if (id == "" || password == "") {
            error_display("All fields are required!!", 1);
            return;
        } else {
            $(this).html("<img src='img/load.gif' alt='loading...'>");
            $.ajax({
                url: "includes/home.inc.php",
                type: "POST",
                data: {
                    id: id,
                    password: password
                },
                success: function(data) {
                    $(".response-data").html(data);
                },
                complete: function(data) {
                    $("#student-login-btn").html("Login");
                }
            });
        }
    });

    //admin login
    $("#admin-login-btn").click(function() {
        var email = $("#admin_email").val();
        var password = $("#admin_pass").val();
        if (email == "" || password == "") {
            error_display("All fields are required!!", 1);
            return;
        } else {
            $(this).html("<img src='img/load.gif' alt='loading...'>");
            $.ajax({
                url: "../includes/home.inc.php",
                type: "POST",
                data: {
                    admin_email: email,
                    password: password
                },
                success: function(data) {
                    $(".response-data").html(data);
                },
                complete: function(data) {
                    $("#admin-login-btn").html("Login");
                }
            });
        }
    });

    //get opt function
    $("#get-otp-btn").click(function() {
        var id = $("#forget-id").val();
        if (id == "") {
            f_pass_error_display("All feilds are required!!", 1);
        } else {
            $("#get-otp-btn").html("<img src='img/load.gif' alt='loading...'>");
            $.ajax({
                url: "includes/home.inc.php",
                type: "POST",
                data: {
                    f_pass_id: id
                },
                success: function(data) {
                    $(".f-pass-response-data").html(data);
                },
                complete: function(data) {
                    $("#get-otp-btn").html("Get OTP");
                }
            });
        }
    });

    //updaate the new password
    $("#password-change-btn").click(function() {
        var id = $("#forget-id").val();
        var otp = $("#otp").val();
        var new_pass = $("#new_pass").val();
        if (id == "" || otp == "" || new_pass == "") {
            f_pass_error_display("All feilds are required!!", 1);
        } else {
            $("#password-change-btn").html("<img src='img/load.gif' alt='loading...'>");
            $.ajax({
                url: "includes/home.inc.php",
                type: "POST",
                data: {
                    update_id: id,
                    otp: otp,
                    new_pass: new_pass
                },
                success: function(data) {
                    $(".f-pass-response-data").html(data);
                },
                complete: function(data) {
                    $("#password-change-btn").html("Update Password");
                }
            });
        }
    });
});
