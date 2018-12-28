$(document).ready(function() {
    changeValue();
    function changeValue() {
        //none
        if ($("#post_category_id").val() == '' || $("#post_category_id").val() == 1) {
            $("#full_content").hide();
        }
        //news
        if ($("#post_category_id").val() => 2) {
            $("#full_content").show();
            $("#section_1_1").show();
            $("#section_1_2").show();
            $("#section_1_3").show();
            $("#section_2").hide();
        }
        //tours and services
/*
        if ($("#post_category_id").val() >= 3) {
            $("#full_content").show();
            $("#section_1_1").hide();
            $("#section_1_2").hide();
            $("#section_1_3").hide();
            $("#section_2").show();
        }
*/
    }
    $("#post_category_id").change(function () {
        changeValue();
    });
});