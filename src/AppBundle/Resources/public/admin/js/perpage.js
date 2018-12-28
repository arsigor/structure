$('#perpage').change(function () {
    $( "#perpage option:selected" ).each(function() {
        perpage = $( this ).val();
    });
    url = url.replace('0', perpage);

    $(location).attr("href", url);
});

