var id;
var mod;
$(document).ready(function() {
    $('input[type="file"].multiple').fileuploader();

    $(".thumbnail-img-modal").on('click', function(){
        $('#image-gallery-title').text($(this).data('title'));
        $('#image-gallery-image').attr('src', $(this).data('image'));
        $('#image-gallery-url').val($(this).data('image'));
    });


});
