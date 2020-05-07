function error_display(text, display) {
    if (display) {
        $(".error-box p").css("display", "block");
    } else {
        $(".error-box p").css("display", "none");
    }
    $(".error-box p").text(text);
}

function sleep(milliseconds) {
    const date = Date.now();
    let currentDate = null;
    do {
        currentDate = Date.now();
    } while (currentDate - date < milliseconds);
}

//to submit the faculy survey
function submit_survey() {
    // $("#submit_survey").prop("disabled", true);
    $("#submit_survey").attr("disabled", true);

    var subject_code = $("#subject_name").val();
    var faculty_name = $("#faculty_name").val();
    var q1 = $("#q1").val();
    var q2 = $("#q2").val();
    var q3 = $("#q3").val();
    var q4 = $("#q4").val();
    var q5 = $("#q5").val();
    var q6 = $("#q6").val();
    var q7 = $("#q7").val();
    var q8 = $("#q8").val();
    var q9 = $("#q9").val();
    var q11 = $("#q11").val();
    var q10 = $("#q10").val();
    if (
        (subject_code,
        faculty_name == "" ||
            q1 == "" ||
            q2 == "" ||
            q3 == "" ||
            q4 == "" ||
            q5 == "" ||
            q6 == "" ||
            q7 == "" ||
            q8 == "" ||
            q9 == "" ||
            q10 == "" ||
            q11 == "")
    ) {
        error_display("All feilds are required!!", 1);
        $(window).scrollTop(0);
    } else {
        $("#submit_survey").html("<img src='profile_photos/load.gif' alt='loading...'>");
        $.ajax({
            url: "includes/faculty-survey.inc.php",
            type: "POST",
            data: {
                s_code: subject_code,
                f_name: faculty_name,
                q1: q1,
                q2: q2,
                q3: q3,
                q4: q4,
                q5: q5,
                q6: q6,
                q7: q7,
                q8: q8,
                q9: q9,
                q10: q10,
                q11: q11
            },
            success: function(data) {
                $(".error-box p").html(data);
            },
            complete: function() {
                $("#submit_survey").prop("disabled", false);
            }
        });
    }

    $("#submit_survey").prop("disabled", false);
}

$(document).ready(function() {
    //get the academic results
    $("#get-result-btn").click(function() {
        var sem = $("#sem_type").val();
        var result_type = $("#result_type").val();
        if (sem == "" || result_type == "") {
            error_display("All feilds are required!!", 1);
        } else {
            $("#get-result-btn").html("<img src='profile_photos/load.gif' alt='loading...'>");

            $.ajax({
                url: "includes/get_results.inc.php",
                type: "POST",
                data: {
                    sem_type: sem,
                    result_type: result_type
                },
                success: function(data) {
                    $(".results-table").html(data);
                },
                complete: function(data) {
                    $("#get-result-btn").html("Get Result");
                }
            });
        }
    });

    //get the faculty based on selected subject
    $("#subject_name").change(function() {
        var sub_code = $("#subject_name").val();
        $(".survey-questions-box").html("");
        $query = "SELECT * FROM sem_subjects where branch = ? AND year = ? ";
        if (sub_code == "") {
            $("#faculty_name").html("<option value=''>Select Faculty</option><option value=''>No data</option>");
            return;
        }
        $("#faculty_name").html("<option value=''>Loading</option>");
        $.ajax({
            url: "includes/faculty-survey.inc.php",
            type: "POST",
            data: {
                sub_code: sub_code
            },
            success: function(data) {
                $("#faculty_name").html(data);
            }
        });
    });

    $("#faculty_name").change(function() {
        $(".survey-questions-box").html("");
    });

    //to get the survey questions
    $("#get-survey-questions").click(function() {
        error_display("", 0);
        var subject_code = $("#subject_name").val();
        var faculty_name = $("#faculty_name").val();
        if (subject_code == "" || faculty_name == "") {
            error_display("All feilds are required!!", 1);
        } else {
            $("#get-survey-questions").html("<img src='profile_photos/load.gif' alt='loading...'>");
            $.ajax({
                url: "includes/faculty-survey.inc.php",
                type: "POST",
                data: {
                    subject_code: subject_code
                },
                success: function(data) {
                    $(".survey-questions-box").html(data);
                    $("#submit_survey").prop("disabled", false);
                },
                complete: function(data) {
                    $("#get-survey-questions").html("Get Survey");
                }
            });
        }
    });

    //to display student  details edit box
    $("#profile-edit-btn").click(function() {
        $(".edit-student-data-box").addClass("display-edit-box");
        $(window).scrollTop(0);
    });

    //to close pop up edit details window
    $("#close-window-btn").click(function() {
        $(".edit-student-data-box").removeClass("display-edit-box");
    });

    //to update the student edited details to the database
    $("#update-student-details-btn").click(function(e) {
        e.preventDefault();

        var name,
            id,
            email,
            ht,
            dob,
            gender,
            year,
            branch,
            section,
            hostel_room,
            mother_name,
            father_name,
            guardian_name,
            parent_mobile,
            stu_mobile,
            address;

        name = $("#name").val();
        id = $("#id").val();
        email = $("#email").val();
        ht = $("#hall_ticket").val();
        gender = $("#gender").val();
        year = $("#year").val();
        branch = $("#branch").val();
        dob = $("#dob").val();
        section = $("#section").val();
        hostel_room = $("#hostel_room").val();
        mother_name = $("#mother_name").val();
        father_name = $("#father_name").val();
        guardian_name = $("#guardian_name").val();
        parent_mobile = $("#parent_mobile").val();
        stu_mobile = $("#stu_mobile").val();
        address = $("#address").val();
        image = $("#file").val();

        if (
            name == "" ||
            email == "" ||
            ht == "" ||
            gender == "" ||
            year == "" ||
            branch == "" ||
            dob == "" ||
            section == "" ||
            hostel_room == "" ||
            parent_mobile == "" ||
            address == "" ||
            image == ""
        ) {
            error_display("All feilds are required!", 1);
            $(".edit-student-data").scrollTop(0);
        } else {
            var mydata = {
                name: name,
                email: email,
                ht: ht,
                gender: gender,
                year: year,
                branch: branch,
                id: id,
                dob: dob,
                section: section,
                hostel_room: hostel_room,
                parent_mobile: parent_mobile,
                address: address
            };
            var form = $("form");
            formData = new FormData(form[0]);

            $("#update-student-details-btn").html("<img src='profile_photos/load.gif' alt='loading...'>");
            $.ajax({
                url: "includes/edit-profile.inc.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    $(".response-box").html(data);
                },
                complete: function(data) {
                    $("#update-student-details-btn").html("Update Details");
                }
            });
        }
    });

    //to request outpass
    $("#request-outpass-btn").click(function(e) {
        e.preventDefault();
        var reason = $("#outing-reason").val();
        var date = $("#outing-date").val();
        if (reason == "" || date == "") {
            error_display("All fields are required!", 1);
            return;
        }

        $("#request-outpass-btn").html("<img src='profile_photos/load.gif' alt='loading...'>");
        $.ajax({
            url: "includes/request-outpass.inc.php",
            type: "POST",
            data: {
                reason: reason,
                date: date
            },
            success: function(data) {
                $(".response-box").html(data);
            },
            complete: function(data) {
                $("#request-outpass-btn").html("Request outpass");
            }
        });
    });
});
