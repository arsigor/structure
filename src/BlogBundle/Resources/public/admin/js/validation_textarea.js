$( "#submit" ).click(function() {
    var message = $('textarea#post_translations_uk_brief').val();
    if (message == '') {
        alert('Не заповнене поле!');
        $( "#brief" ).css("border","1px solid red");
    }
});