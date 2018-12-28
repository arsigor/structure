$(document).ready(function() {
    changeValue();
    function changeValue() {
        //none
        if ($("#category_pid").val() == '') {
            $("#file_category").hide();
        }
        //service
        if ($("#category_pid").val() == 4) {
            $("#file_category").show();
        }
    }
    $("#category_pid").change(function () {
        changeValue();
    });
});