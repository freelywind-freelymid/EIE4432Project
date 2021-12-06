$(document).ready(function () {
    $("#login").click(function () {
        $(".info").html("");

        $("#login-popup").show();
    });
    
    $("#login-form").on("submit", function () {
        var valid = true;
        $(".info").html("");
        
        var loginId = $("#loginPage_loginId").val().trim();
        var password = $("#loginPage_password").val().trim();

        if (loginId == "" || password == "") {
            $("#login-info").html("***Wrong login ID or password.***");
            valid = false;
        }      

        return valid;
    });

    $("#loginPage_register").click(function (){
        $("#login-popup").hide();
        $("#register-popup").show();
    });

    $("#loginPage_back").click(function () {
        $("#login-popup").hide();
    });

    $("#forgot-info").click(function () {
        location.replace("reset_password.php");
    });
});