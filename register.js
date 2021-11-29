$(document).ready(function () {
    $("#register").click(function () {
        $(".info").html("");
        $(".inputBox").removeClass("input-error");
        $(".inputSelect").removeClass("input-error");

        $("#register-popup").show();
    });
    
    $("#register-form").on("submit", function () {
        var valid = true;
        $(".info").html("");
        $(".inputBox").removeClass("input-error");
        $(".inputSelect").removeClass("input-error");
        
        var nickName = $("#registerPage_nickName").val().trim();
        var userEmail = $("#registerPage_userEmail").val().trim();
        var birthday = $("#registerPage_birthday").val();
        var gender = $("#registerPage_gender").val();
        var userIcon = $("#registerPage_userIcon").val();
        var password = $("#registerPage_password").val().trim();
        var confirmPassword = $("#registerPage_confirmPassword").val().trim();

        if (nickName == "") {
            $("#nickName-info").html("Required.");
            $("#registerPage_nickName").addClass("input-error");
        }
        if (userEmail == "") {
            $("#userEmail-info").html("Required.");
            $("#registerPage_userEmail").addClass("input-error");
            valid = false;
        }
        if (!userEmail.match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/))
        {
            $("#userEmail-info").html("Invalid.");
            $("#registerPage_userEmail").addClass("input-error");
            valid = false;
        }

        birthday = Date.parse(birthday);
        if (isNaN(birthday)) {
            $("#birthday-info").html("Invalid.");
            $("#registerPage_birthday").addClass("input-error");
            valid = false;
        }

        if (gender == "") {
            $("#gender-info").html("Required.");
            $("#registerPage_gender").addClass("input-error");
            valid = false;
        }

        if (password == "") {
            $("#password-info").html("Required.");
            $("#registerPage_password").addClass("input-error");
            valid = false;
        }

        if (confirmPassword == "") {
            $("#confirmPassword-info").html("Required.");
            $("#registerPage_confirmPassword").addClass("input-error");
            valid = false;
        }
        
        if(password != confirmPassword){
            $("#confirmPassword-info").html("Not matching.");
            $("#registerPage_confirmPassword").addClass("input-error");
            valid = false;
        }

        return valid;
    });

    $("#register-form").on("reset", function() {
        $(".info").html("");
        $(".inputBox").removeClass("input-error");
        $(".inputSelect").removeClass("input-error");
    });

    $("#registerPage_back").click(function () {
        $("#register-popup").hide();
    });
});