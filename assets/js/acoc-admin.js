/*jQuery(document).ready(function($) {
	$(document).on('click', '.row-addnew', function(e) {
		e.preventDefault();
		var list = $(this).parent().children('ul');
		var count = parseInt(list.children('li').length);
		var settings = $('#'+name+'_settings_array').val();;
					
		$.ajax({
			url: ajaxurl,
			type: 'post',
			data: {
				action: 'add_acoc_field_list_item',
				count: count,
				settings: settings,
			},
			complete: function( data ) {
				//console.log (data);
				//alert(data.responseText);
				$('.sss').html(data.responseText);
			}
		});
	});
});*/