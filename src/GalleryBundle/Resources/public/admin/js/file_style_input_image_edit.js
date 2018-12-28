$("#image_file").filestyle({input: false});
$("#image_file").change(function(){
    $("#users_profile_change").val(new Date().getTime());
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#previewImg').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    }
});