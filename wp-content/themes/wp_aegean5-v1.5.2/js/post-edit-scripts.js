jQuery(document).ready(function($) {

	//
	// Page edit scripts
	//
	if($('#page_template').length > 0) {
		// first run
		var template_box = $('#page_template');
		var metabox = $('div#ci_page_room_listing_meta');
		metabox.hide();
		if( template_box.val() == 'template-rooms-2cols.php' || template_box.val() == 'template-rooms-3cols.php' )
			metabox.show();
	
	
		// show only the custom fields we need in the post screen
		$('#page_template').change(function(){
		if( template_box.val() == 'template-rooms-2cols.php' || template_box.val() == 'template-rooms-3cols.php' )
				metabox.show();
			else
				metabox.hide();
		});
	}


	//
	// Room edit scripts
	//
	
	// Repeating fields
	if($('#ci_cpt_room_meta').length > 0) {
		$('#ci_cpt_room_meta .amenities .inside').sortable();
		$('#amenities-add-field').click( function() {
			$('.amenities .inside').append('<p class="amenities-field"><input type="text" name="ci_cpt_room_amenities[]" /> <a href="#" class="amenities-remove">Remove me</a></p>');
			return false;		
		});
		$('.amenities-remove').live('click', function() {
			$(this).parent('p').remove();
			return false;
		});
	}

}); 
