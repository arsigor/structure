$(document).ready(function() {
	$('.multipleAjax').fileuploader({
	    upload: {
		url: '/'+mod+'/post/add/image/'+id,
		data: null,
		type: 'POST',
		enctype: 'multipart/form-data',
		start: true,
		synchron: true,
		beforeSend: function(item) {
		    },
		onSuccess: function(result, item) {
		    var data = JSON.parse(result),
		    nameWasChanged = false;
		    if(data[0].name != '') {
			nameWasChanged = item.name != data[0].name;
			item.name = data[0].name;
		    }
		    if(nameWasChanged)
			item.html.find('.column-title div').animate({opacity: 0}, 400);
			item.html.find('.column-actions').append('<a class="fileuploader-action fileuploader-action-remove fileuploader-action-success" title="Remove"><i></i></a>');
			setTimeout(function() {
			    item.html.find('.column-title div').attr('title', item.name).text(item.name).animate({opacity: 1}, 400);
			    item.html.find('.progress-bar2').fadeOut(400);
			}, 400);
		    },
		onError: function(item) {
		    var progressBar = item.html.find('.progress-bar2');
		    if(progressBar.length > 0) {
			progressBar.find('span').html(0 + "%");
			progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
			item.html.find('.progress-bar2').fadeOut(400);
			}
		    item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
			'<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
			) : null;
		    },
		onProgress: function(data, item) {
		    var progressBar = item.html.find('.progress-bar2');
		    if(progressBar.length > 0) {
			progressBar.show();
			progressBar.find('span').html(data.percentage + "%");
			progressBar.find('.fileuploader-progressbar .bar').width(data.percentage + "%");
			}
		    },
		onComplete: null,
	    },
	    onRemove: function(item) {
		$.post('/'+mod+'/post/remove/image/'+id, {
		    file: item.name
		});
	    }
	});
});