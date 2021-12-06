$(document).ready(function () {   
    $("#user-info-form").on("submit", function () {
        var valid = true;

        $(".info").html("");
        $(".inputBox").removeClass("input-error");
        $(".inputSelect").removeClass("input-error");
        
        var nickName = $("#user_info_page_nickName").val().trim();
        var userEmail = $("#user_info_page_userEmail").val().trim();
        var birthday = $("#user_info_page_birthday").val();
        var gender = $("#user_info_page_gender").val();
        var old_password = $("#user_info_page_old_password").val().trim();
        var password = $("#user_info_page_password").val().trim();
        var confirmPassword = $("#user_info_page_confirmPassword").val().trim();

        if (nickName == "") {
            $("#user-info-page-nickName-info").html("Required.");
            $("#user_info_page_nickName").addClass("input-error");
        }
        if (userEmail == "") {
            $("#user-info-page-userEmail-info").html("Required.");
            $("#user_info_page_userEmail").addClass("input-error");
            valid = false;
        }
        if (!userEmail.match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/))
        {
            $("#user-info-page-userEmail-info").html("Invalid.");
            $("#user_info_page_userEmail").addClass("input-error");
            valid = false;
        }

        birthday = Date.parse(birthday);
        if (isNaN(birthday)) {
            $("#user-info-page-birthday-info").html("Invalid.");
            $("#user_info_page_birthday").addClass("input-error");
            valid = false;
        }

        if (gender == "") {
            $("#user-info-page-gender-info").html("Required.");
            $("#user_info_page_gender").addClass("input-error");
            valid = false;
        }

        if(password != "" || confirmPassword != ""){
            if(old_password == ""){
                $("#user-info-page-old-password-info").html("Required.");
                $("#user-info-page-old-password-info").addClass("input-error");
            }
    
            if (password == "") {
                $("#user-info-page-password-info").html("Required.");
                $("#user_info_page_password").addClass("input-error");
                valid = false;
            }
    
            if (confirmPassword == "") {
                $("#user-info-page-confirmPassword-info").html("Required.");
                $("#user_info_page_confirmPassword").addClass("input-error");
                valid = false;
            }
            
            if(password != confirmPassword){
                $("#user-info-page-confirmPassword-info").html("Not matching.");
                $("#user_info_page_confirmPassword").addClass("input-error");
                valid = false;
            }
        }

        return valid;
    });
});