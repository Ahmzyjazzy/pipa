// JavaScript Document
$(init);
function init(){
	
	photos_sortable();
	$(".sortable").sortable();
	$(".sortable > span").disableSelection();
}



function remove_image(img)
{
	if(confirm('Are you sure you want to remove this image?'))
	{
		var id	= img.attr('rel');
		var file = img.attr('lang');
		$.post(link+"admin/category_remove_image/", { id: file},
		function(data) {

		if(data == "done"){	
			$('#gc_photo_'+id).remove();
		}
	});
		
	}
}

function photos_sortable()
{
	$('#gc_photos').sortable({	
		handle : '.gc_thumbnail',
		items: '.gc_photo',
		axis: 'y',
		scroll: true
	});
}

/*function photos_sortable()
{
	$('#gc_photos').sortable({	
		handle : '.gc_thumbnail',
		items: '.gc_photo',
		axis: 'y',
		scroll: true
	});
}*/

function category_add_product_image(data)
{
	p	= data.split('.');
	var filename = p[0];
	var file = p[0]+'.'+p[1];
	
	$.post(link+"admin/category_js_add_image/", { filename: filename, file:file},
			function(data) {

			$('#gc_photos').append(data);
			$('#gc_photos').sortable('destroy');
			photos_sortable();

	});
	
}