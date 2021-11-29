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
        
        var nickName = $("#nickName").val().trim();
        var userEmail = $("#userEmail").val().trim();
        var birthday = $("#birthday").val();
        var gender = $("#gender").val();
        var userIcon = $("#userIcon").val();
        var password = $("#password").val().trim();
        var confirmPassword = $("#confirmPassword").val().trim();

        if (nickName == "") {
            $("#nickName-info").html("Required.");
            $("#nickName").addClass("input-error");
        }
        if (userEmail == "") {
            $("#userEmail-info").html("Required.");
            $("#userEmail").addClass("input-error");
            valid = false;
        }
        if (!userEmail.match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/))
        {
            $("#userEmail-info").html("Invalid.");
            $("#userEmail").addClass("input-error");
            valid = false;
        }

        birthday = Date.parse(birthday);
        if (isNaN(birthday)) {
            $("#birthday-info").html("Invalid.");
            $("#birthday").addClass("input-error");
            valid = false;
        }

        if (gender == "") {
            $("#gender-info").html("Required.");
            $("#gender").addClass("input-error");
            valid = false;
        }

        if (password == "") {
            $("#password-info").html("Required.");
            $("#password").addClass("input-error");
            valid = false;
        }

        if (confirmPassword == "") {
            $("#confirmPassword-info").html("Required.");
            $("#confirmPassword").addClass("input-error");
            valid = false;
        }
        
        if(password != confirmPassword){
            $("#confirmPassword-info").html("Not matching.");
            $("#confirmPassword").addClass("input-error");
            valid = false;
        }

        return valid;
    });

    $("#register-form").on("reset", function() {
        $(".info").html("");
        $(".inputBox").removeClass("input-error");
        $(".inputSelect").removeClass("input-error");
    });

    $("#back").click(function () {
        $("#register-popup").hide();
    });
});