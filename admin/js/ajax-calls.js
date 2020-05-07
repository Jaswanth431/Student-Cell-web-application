function error_display(text, display) {
    if (display) {
        $(".hidden-error-box p").css("display", "block");
    } else {
        $(".hidden-error-box p").css("display", "none");
    }
    $(".hidden-error-box p").text(text);
}

function sleep(milliseconds) {
    const date = Date.now();
    let currentDate = null;
    do {
        currentDate = Date.now();
    } while (currentDate - date < milliseconds);
}

$(document).ready(function() {
    //to display results
    $("#stu-result-get-btn").click(function() {
        var id = $("#stu_id").val();
        var sem_type = $("#sem_type").val();
        if (sem_type == "" || id == "") {
            error_display("All feilds are required!!", 1);
        } else {
            $("#stu-result-get-btn").html("<img src='../img/load.gif' alt='loading...'>");

            $.ajax({
                url: "../includes/get-result.inc.php",
                type: "POST",
                data: {
                    sem_type: sem_type,
                    stu_id: id
                },
                success: function(data) {
                    $(".table-box").html(data);
                },
                complete: function(data) {
                    $("#stu-result-get-btn").html("Get Result");
                }
            });
        }
    });

    //to update results on clicking button

    $(".results-edit-table").on("click", ".update-btn", function(e) {
        var subject_data = e.target.parentNode.parentNode.parentNode.id;
        if (subject_data) {
            var mid1, mid2, mid3, bo2, wat, grade, tb_name, id, sub_name;
            mid1 = $("#" + subject_data + " .mid1").text();
            mid2 = $("#" + subject_data + " .mid2").text();
            mid3 = $("#" + subject_data + " .mid3").text();
            wat = $("#" + subject_data + " .wat").text();
            grade = $("#" + subject_data + " .grade").text();
            bo2 = $("#" + subject_data + " .bo2").text();
            sub_name = $("#" + subject_data + " .sub_name").text();
            sub_code = $("#" + subject_data + " .sub_code").text();
            tb_name = $("#sem_type").val();
            id = $("#stu_id").val();
            var i = "#" + subject_data + " button";
            console.log(mid1, mid2, mid3, wat, grade, bo2, sub_name, sub_code, tb_name, id, i);

            $(i).html("<img src='../img/load.gif' alt='loading...'>");
            $.ajax({
                url: "../includes/get-result.inc.php",
                type: "POST",
                data: {
                    mid1: mid1,
                    mid2: mid2,
                    mid3: mid3,
                    wat: wat,
                    grade: grade,
                    bo2: bo2,
                    tb_name: tb_name,
                    sub_name: sub_name,
                    id: id,
                    sub_code: sub_code
                },
                success: function(data) {
                    $(i).html("<p>Done</p>");
                    sleep(1000);
                },
                complete: function(data) {
                    $(i).html("<i class='fa fa-check-square' aria-hidden='true'></i>");
                }
            });
        }
    });

    //to remove results when id change in exam results editing
    $("#stu_id").keyup(function() {
        $(".table-box").html("");
    });

    //to remove results when sem change in exam results editing
    $("#sem_type").change(function() {
        $(".table-box").html("");
    });

    //to display academic result
    $("#get-academic-btn").click(function() {
        console.log("hii");
        var id = $("#stu_id").val();
        $("#get-academic-btn").html("<img src='../img/load.gif' alt='loading...'>");

        $.ajax({
            url: "../includes/get-result.inc.php",
            type: "POST",
            data: {
                clg_id: id
            },
            success: function(data) {
                $(".table-box").html(data);
            },
            complete: function(data) {
                $("#get-academic-btn").html("Get Data");
            }
        });
    });

    //to approve the outpass request
    $(".outpass-requests-box").on("click", ".outpass-approve-btn", function(e) {
        e.preventDefault();
        var row_id = e.target.parentNode.parentNode.id;
        if (!row_id) return;
        var reason_type = $("#" + row_id + " " + ".reason_type").val();
        var no_of_days = $("#" + row_id + " " + ".no_of_days").val();
        var op_id = $("#" + row_id + " " + ".outpass_id").text();
        var student_id = $("#" + row_id + " " + ".student_id").text();

        if (reason_type == "" || no_of_days == "") {
            error_display("All feilds are required to approve outpass!", 1);
            return;
        }

        $("#" + row_id + " " + ".outpass-approve-btn").html("<img src='../img/load.gif' alt='loading...'>");

        $.ajax({
            url: "../includes/outpass-requests.inc.php",
            type: "POST",
            data: {
                outpass_id: op_id,
                reason_type: reason_type,
                no_of_days: no_of_days,
                stu_id: student_id
            },
            success: function(data) {
                $(".response-box").html(data);
                // location.reload();
            },
            complete: function(data) {
                $("#" + row_id + " " + ".outpass-approve-btn").html("Approved");
            }
        });
    });

    //to reject the outpass request
    $(".outpass-requests-box").on("click", ".outpass-reject-btn", function(e) {
        e.preventDefault();
        var row_id = e.target.parentNode.parentNode.id;
        if (!row_id) return;
        var op_id = $("#" + row_id + " " + ".outpass_id").text();
        var student_id = $("#" + row_id + " " + ".student_id").text();
        alert(row_id);
        $("#" + row_id + " " + ".outpass-reject-btn").html("<img src='../img/load.gif' alt='loading...'>");

        $.ajax({
            url: "../includes/outpass-requests.inc.php",
            type: "POST",
            data: {
                reject_op_id: op_id,
                reject_stu_id: student_id
            },
            success: function(data) {
                $(".response-box").html(data);
            },
            complete: function(data) {
                $("#" + row_id + " " + ".outpass-reject-btn").html("Rejected");
            }
        });
    });

    //to get the outpass list
    $(".outpass-list-box #student_id").keyup(function() {
        var id = $("#student_id").val();
        $(".outpass-list").html("<img src='../img/dual-ring-load.gif' alt='Loading'> ");
        $.ajax({
            url: "../includes/get-outpass-list.inc.php",
            type: "POST",
            data: {
                stu_id: id
            },
            success: function(data) {
                $(".outpass-list").html(data);
            },
            complete: function(data) {}
        });
    });

    //to approve outing of student by security
    $(".outpass-list").on("click", ".out-from-campus-btn", function(e) {
        var row_id = e.target.parentNode.parentNode.id;
        if (!row_id) return;

        var op_id = $("#" + row_id + " " + ".outpass_id").text();
        var student_id = $("#" + row_id + " " + ".student_id").text();

        $("#" + row_id + " " + ".out-from-campus-btn").html("<img src='../img/load.gif' alt='loading...'>");
        $.ajax({
            url: "../includes/get-outpass-list.inc.php",
            type: "POST",
            data: {
                out_op_id: op_id,
                out_stu_id: student_id,
                row_id: row_id
            },
            success: function(data) {
                $(".response-box").html(data);
            },
            error: function(data) {
                $("#" + row_id + " " + ".out-from-campus-btn").html("OUT");
            }
        });
    });

    //to get the out of campus students list
    $(".out-of-campus-list-box #student_id").keyup(function() {
        var id = $("#student_id").val();
        $(".out-of-campus-list").html("<img src='../img/dual-ring-load.gif' alt='Loading'> ");
        $.ajax({
            url: "../includes/get-outpass-list.inc.php",
            type: "POST",
            data: {
                out_of_campus_stu_id: id
            },
            success: function(data) {
                $(".out-of-campus-list").html(data);
            }
        });
    });

    //approve in to campus of student
    $(".out-of-campus-list").on("click", ".in-to-campus-btn", function(e) {
        var row_id = e.target.parentNode.parentNode.id;
        if (!row_id) return;
        var op_id = $("#" + row_id + " " + ".outpass_id").text();
        var student_id = $("#" + row_id + " " + ".student_id").text();

        $("#" + row_id + " " + "in-to-campus-btn").html("<img src='../img/load.gif' alt='loading...'>");
        $.ajax({
            url: "../includes/get-outpass-list.inc.php",
            type: "POST",
            data: {
                in_op_id: op_id,
                in_stu_id: student_id,
                row_id: row_id
            },
            success: function(data) {
                $(".response-box").html(data);
            },
            error: function(data) {
                $("#" + row_id + " " + "in-to-campus-btn").html("IN");
            }
        });
    });
});
