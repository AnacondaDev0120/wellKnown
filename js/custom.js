
$("#phoneLoginModalClose").click(function (e) {
    e.preventDefault();
    $("#phoneLoginModal").modal("toggle");
});

$(".phoneLoginModal").click(function (e) {
    e.preventDefault();
    $("#LoginDialog").modal("toggle");
    $("#phoneLoginModal").modal("toggle");
});