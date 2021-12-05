$(document).ready(function () {
    $("#butt_create").click(function () {
        $(".info").html("");
        $(".inputBox").removeClass("input-error");

        $("#createItem-popup").show();
    });

    $("#createItem-form").on("reset", function() {
        $(".info").html("");
        $(".inputBox").removeClass("input-error");
    });

    $("#createItem_back").click(function () {
        $("#createItem-popup").hide();
    });
});