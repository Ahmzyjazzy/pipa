// JavaScript Document
$(init);

function init(){
	
	//fetch_category_query();
	/*$('#category_search').keyup(function(){
		$('#category_list').html('');
		run_category_query();
	});*/
	
	$('.srch-sel-cat').click(hold_categorys);

}

function add_product_interior_image(data)
{
	p				= 	data.split('.');
	var filename 	= 	p[0];
	var file 		= 	p[0]+'.'+p[1];
	
	$.post(link+"admin/interior-js-add-image/", { filename: filename, file:file},
			function(data) {

			$('#gc-interior-photos').append(data);
			$('#gc-interior-photos').sortable('destroy');
			interior_photos_sortable();

	});
	
}

function interior_photos_sortable()
{
	$('#gc-interior-photos').sortable({	
		handle : '.gc_interior_thumbnail',
		items: '.gc-interior-photo',
		axis: 'y',
		scroll: true
	});
}

function interior_remove_image(img)
{
	if(confirm('Are you sure you want to remove this image?'))
	{
		var id		= 	img.attr('rel');
		var file 	= 	img.attr('lang');
		
		$.post(link+"admin/interior-remove-image/", { id: file},
		function(data) {

		if(data == "done"){	
			$('#gc-interior-photo-'+id).remove();
		}
		
	});

	}
}

function add_product_exterior_image(data)
{
	p				= 	data.split('.');
	var filename 	= 	p[0];
	var file 		= 	p[0]+'.'+p[1];
	
	$.post(link+"admin/exterior-js-add-image/", { filename: filename, file:file},
			function(data) {

			$('#gc-exterior-photos').append(data);
			$('#gc-exterior-photos').sortable('destroy');
			exterior_photos_sortable();

	});
	
}

function exterior_photos_sortable()
{
	$('#gc-exterior-photos').sortable({	
		handle : '.gc_exterior_thumbnail',
		items: '.gc-exterior-photo',
		axis: 'y',
		scroll: true
	});
}

function exterior_remove_image(img)
{
	if(confirm('Are you sure you want to remove this image?'))
	{
		var id		= 	img.attr('rel');
		var file 	= 	img.attr('lang');
		
		$.post(link+"admin/exterior-remove-image/", { id: file},
		function(data) {

		if(data == "done"){	
			$('#gc-exterior-photo-'+id).remove();
		}
		
	});

	}
}

function add_product_exterior_feature(data)
{
	p				= 	data.split('.');
	var filename 	= 	p[0];
	var file 		= 	p[0]+'.'+p[1];
	
	$.post(link+"admin/exterior-feature-js-add-image/", { filename: filename, file:file},
			function(data) {

			$('#gc-exterior-features').append(data);
			$('#gc-exterior-features').sortable('destroy');
			exterior_feature_sortable();

	});
	
}

function exterior_feature_sortable()
{
	$('#gc-exterior-feature').sortable({	
		handle : '.gc_exterior_feature_thumbnail',
		items: '.gc-exterior-feature',
		axis: 'y',
		scroll: true
	});
}

function exterior_feature_remove(img)
{
	if(confirm('Are you sure you want to remove this image?'))
	{
		var id		= 	img.attr('rel');
		var file 	= 	img.attr('lang');
		
		$.post(link+"admin/exterior-feature-remove/", { id: file},
		function(data) {

		if(data == "done"){	
			$('#gc-exterior-feature-'+id).remove();
		}
		
	});

	}
}

function add_product_interior_feature(data)
{
	p				= 	data.split('.');
	var filename 	= 	p[0];
	var file 		= 	p[0]+'.'+p[1];
	
	$.post(link+"admin/interior-feature-js-add-image/", { filename: filename, file:file},
			function(data) {

			$('#gc-interior-features').append(data);
			$('#gc-interior-features').sortable('destroy');
			interior_feature_sortable();

	});
	
}

function interior_feature_sortable()
{
	$('#gc-interior-feature').sortable({	
		handle : '.gc_interior_feature_thumbnail',
		items: '.gc-interior-feature',
		axis: 'y',
		scroll: true
	});
}

function interior_feature_remove(img)
{
	if(confirm('Are you sure you want to remove this image?'))
	{
		var id		= 	img.attr('rel');
		var file 	= 	img.attr('lang');
		
		$.post(link+"admin/interior-feature-remove/", { id: file},
		function(data) {

		if(data == "done"){	
			$('#gc-interior-feature-'+id).remove();
		}
		
	});

	}
}

function add_product_color_image(data)
{
	p				= 	data.split('.');
	var filename 	= 	p[0];
	var file 		= 	p[0]+'.'+p[1];
	
	$.post(link+"admin/color-js-add-image/", { filename: filename, file:file},
			function(data) {

			$('#gc-color-photos').append(data);
			$('#gc-color-photos').sortable('destroy');
			color_photos_sortable();

	});
	
}

function color_photos_sortable()
{
	$('#gc-color-photos').sortable({	
		handle : '.gc_color_thumbnail',
		items: '.gc-color-photo',
		axis: 'y',
		scroll: true
	});
}

function color_remove_image(img)
{
	if(confirm('Are you sure you want to remove this image?'))
	{
		var id		= 	img.attr('rel');
		var file 	= 	img.attr('lang');
		
		$.post(link+"admin/color-remove-image/", { id: file},
		function(data) {

		if(data == "done"){	
			$('#gc-color-photo-'+id).remove();
		}
		
	});

	}
}

function add_product_technology_image(data)
{
	p				= 	data.split('.');
	var filename 	= 	p[0];
	var file 		= 	p[0]+'.'+p[1];
	
	$.post(link+"admin/technology-js-add-image/", { filename: filename, file:file},
			function(data) {

			$('#gc-technology-photos').append(data);
			$('#gc-technology-photos').sortable('destroy');
			technology_photos_sortable();

	});
	
}

function technology_photos_sortable()
{
	$('#gc-interior-photos').sortable({	
		handle : '.gc_technology_thumbnail',
		items: '.gc-technology-photo',
		axis: 'y',
		scroll: true
	});
}

function technology_remove_image(img)
{
	if(confirm('Are you sure you want to remove this image?'))
	{
		var id		= 	img.attr('rel');
		var file 	= 	img.attr('lang');
		
		$.post(link+"admin/technology-remove-image/", { id: file},
		function(data) {

		if(data == "done"){	
			$('#gc-technology-photo-'+id).remove();
		}
		
	});

	}
}

function hold_categorys(){
	
		// $(".assets".attr("checked", "checked";
	//$(".assets".each(
	//var hold = $(this).val();
	
	var long_list = "";
	$('.srch-sel-cat:checked').each(function(){ // walk through each div with 'chat_p' as class
		var the_id_list = $(this).val();// extract the number contained in the id of the class
		long_list += the_id_list+','; 
	
	//member_ids.push(the_id_list); // creation of array with number of each status div
	});

	$(".cats_hldr").val(long_list);

}

function run_category_query()
{	
	if($('#category_search').val().length > 0)
	{
		
		$.post(link+"admin/category_autocomplete/", { name: $('#category_search').val(), limit:20},
			function(data) {
	
				$('#category_list').html('');
				
				$.each(data, function(index, value){
				
					if($('#category_'+index).length == 0)
					{
						$('#category_list').append('<option id="category_item_'+index+'" value="'+index+'">'+value+'</option>');
					}
				});
	
		}, 'json');
	
	}else{
		
		fetch_category_query();
	}
}

function fetch_category_query()
{
	$.post(link+"admin/category_autocomplete_fetch/",
		function(data) {

			$('#category_list').html('');
						
			$.each(data, function(index, value){
			
				if($('#category_'+index).length == 0)
				{
					$('#category_list').append('<option id="category_item_'+index+'" value="'+index+'">'+value+'</option>');
				}
			});

	}, 'json');
}

function remove_category(id)
{
	if(confirm('Are you sure you want to remove this category?'))
	{
		$('#category_'+id).remove();
		run_category_query();
	}
}