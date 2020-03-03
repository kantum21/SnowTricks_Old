$("#mainPictureSaveButton").click(function () {
    var id_input = $("input[name='trick_form[mainPicture]']:checked:enabled").attr('id');
    var labelElement = $("label[for='" + id_input + "']");
    var imageElement = labelElement.children();
    var src = imageElement.attr('src');
    $("#mainPicture").attr('src', src);
});

$("#mainPictureDeleteButton").click(function (e) {
    e.preventDefault();
    $(".default").prop("checked", true);
    var id_input = $("input[name='trick_form[mainPicture]']:checked:enabled").attr('id');
    var labelElement = $("label[for='" + id_input + "']");
    var imageElement = labelElement.children();
    var src = imageElement.attr('src');
    $("#mainPicture").attr('src', src);
});