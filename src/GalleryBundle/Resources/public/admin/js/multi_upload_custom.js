/* multi upload param */
var id =  '{% if form.vars.value.translatable.id is defined %}{{ form.vars.value.translatable.id }}{% else %}0{% endif %}';
var mod = 'blog';
/* end multi upload*/
$('.datepicker').datetimepicker({
    sideBySide: true,
    locale: '{{ app.request.locale }}',
    format: 'YYYY-MM-DD HH:mm'
});

$.fn.filestyle.defaults = {
    'buttonText' : '&nbsp;&nbsp;&nbsp;&nbsp;{{ "MainPhoto"|trans }}',
    'iconName' : 'glyphicon glyphicon-folder-open',
    'buttonName' : 'btn-default changeBtn',
    'size' : 'nr',
    'input' : true,
    'badge' : true,
    'icon' : true,
    'buttonBefore' : false,
    'disabled' : false,
    'placeholder': ''
};

$("#post_file").filestyle({input: false});
$("#post_file").change(function(){
    $("#users_profile_change").val(new Date().getTime());
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#previewImg').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    }
});