$(document).ready(function () {
    $("#cart").click(function () {
        location.replace("cart.php");
    });

    $(".return-home").click(function () {
        location.replace("index.php");
    });

    $(".return-admin-home").click(function () {
        location.replace("admin.php");
    });

    $("#user_icon").click(function () {
        location.replace("user_file.php");
    });
});