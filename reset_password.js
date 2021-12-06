$(document).ready(function () {   
    $("#reset-info-form").on("submit", function () {
        var valid = true;

        $(".info").html("");
        $(".inputBox").removeClass("input-error");
        
        var userEmail = $("#reset_info_page_email").val().trim();
        var password = $("#reset_info_page_password").val().trim();
        var confirmPassword = $("#reset_info_page_confirmPassword").val().trim();

        if (userEmail == "") {
            $("#reset-info-page-email-info").html("Required.");
            $("#reset_info_page_email").addClass("input-error");
            valid = false;
        }

        if (password == "") {
            $("#reset-info-page-password-info").html("Required.");
            $("#reset_info_page_password").addClass("input-error");
            valid = false;
        }

        if (confirmPassword == "") {
            $("#reset-info-page-confirmPassword-info").html("Required.");
            $("#reset_info_page_confirmPassword").addClass("input-error");
            valid = false;
        }
        
        if(password != confirmPassword){
            $("#reset-info-page-confirmPassword-info").html("Not matching.");
            $("#reset_info_page_confirmPassword").addClass("input-error");
            valid = false;
        }

        return valid;
    });
});