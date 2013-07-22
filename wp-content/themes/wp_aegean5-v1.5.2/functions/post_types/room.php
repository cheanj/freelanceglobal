<?php
//
// Room Post Type related functions.
//
add_action('init', 'ci_create_cpt_room');
add_action('admin_init', 'ci_add_cpt_room_meta');
add_action('save_post', 'ci_update_cpt_room_meta');

if( !function_exists('ci_create_cpt_room') ):
function ci_create_cpt_room()
{
	$labels = array(
		'name' => _x('Rooms', 'post type general name', 'ci_theme'),
		'singular_name' => _x('Room', 'post type singular name', 'ci_theme'),
		'add_new' => __('New Room', 'ci_theme'),
		'add_new_item' => __('Add New Room', 'ci_theme'),
		'edit_item' => __('Edit Room', 'ci_theme'),
		'new_item' => __('New Room', 'ci_theme'),
		'view_item' => __('View Room', 'ci_theme'),
		'search_items' => __('Search Rooms', 'ci_theme'),
		'not_found' =>  __('No Rooms found', 'ci_theme'),
		'not_found_in_trash' => __('No Rooms found in the trash', 'ci_theme'), 
		'parent_item_colon' => __('Parent Room Item:', 'ci_theme')
	);

	$args = array(
		'labels' => $labels,
		'singular_label' => __('Room', 'ci_theme'),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'has_archive' => true,
		'rewrite' => true,
		'menu_position' => 5,
		'supports' => array('title', 'editor', 'thumbnail')
		//'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats') 
	);

	register_post_type( 'room' , $args );
}
endif;

if( !function_exists('ci_add_cpt_room_meta') ):
function ci_add_cpt_room_meta()
{
	add_meta_box("ci_cpt_room_meta", __('Room Details', 'ci_theme'), "ci_add_cpt_room_meta_box", "room", "normal", "high");
}
endif;

if( !function_exists('ci_update_cpt_room_meta') ):
function ci_update_cpt_room_meta($post_id)
{
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
	if (isset($_POST['post_view']) and $_POST['post_view']=='list') return;

	if (isset($_POST['post_type']) && $_POST['post_type'] == "room")
	{
		update_post_meta($post_id, "ci_cpt_room_slider", (isset($_POST["ci_cpt_room_slider"]) ? $_POST["ci_cpt_room_slider"] : '') );
		update_post_meta($post_id, "ci_cpt_room_amenities", (isset($_POST["ci_cpt_room_amenities"]) ? $_POST["ci_cpt_room_amenities"] : '') );
		update_post_meta($post_id, "ci_cpt_room_from", (isset($_POST["ci_cpt_room_from"]) ? $_POST["ci_cpt_room_from"] : '') );
		update_post_meta($post_id, "ci_cpt_room_offer", (isset($_POST["ci_cpt_room_offer"]) ? $_POST["ci_cpt_room_offer"] : '') );
		update_post_meta($post_id, "ci_cpt_room_featured_header", (isset($_POST["ci_cpt_room_featured_header"]) ? $_POST["ci_cpt_room_featured_header"] : '') );
	}
}
endif;

if( !function_exists('ci_add_cpt_room_meta_box') ):
function ci_add_cpt_room_meta_box()
{
	global $post;
	$slider = get_post_meta($post->ID, 'ci_cpt_room_slider', true);
	if($slider == '') $slider = 'enabled';
	$featured_header = get_post_meta($post->ID, 'ci_cpt_room_featured_header', true);
	if($featured_header == '') $featured_header = 'enabled';
	?>

	<h2><?php _e('Gallery', 'ci_theme'); ?></h2>

	<p><?php echo sprintf(__('Each room has its own slider. In order for the slider to appear, you need to have at least two images uploaded and assigned to the post. This can be done by clicking <a href="#" class="ci-upload">here</a>, or pressing the <strong>Upload Images</strong> button bellow, or via the <strong>Add Media <img src="%s" /> button</strong>, just below the room\'s title.', 'ci_theme'), get_admin_url().'/images/media-button.png'); ?></p>
	<p><?php _e('When the slider is enabled and you have assigned multiple images, the slider will appear. If you only have one image assigned, that image will appear in place of the slider.', 'ci_theme'); ?></p>
	<p><?php _e('When the slider is not enabled, or you don\'t have any images assigned to the room, nothing will be displayed.', 'ci_theme'); ?></p>
	<p><input type="button" class="button ci-upload" value="<?php _e('Upload Images', 'ci_theme'); ?>" /></p>
	<p>
		<input type="radio" id="ci_cpt_room_slider" name="ci_cpt_room_slider" value="enabled" <?php checked($slider, 'enabled'); ?> /> 
		<label for="ci_cpt_room_slider"><?php _e('Add a slider to this post.', 'ci_theme'); ?></label>
	</p>
	<p>
		<input type="radio" id="ci_cpt_room_slider_not" name="ci_cpt_room_slider" value="disabled" <?php checked($slider, 'disabled'); ?> /> 
		<label for="ci_cpt_room_slider_not"><?php _e('Don\'t add a slider to this post.', 'ci_theme'); ?></label>
	</p>

	<p><?php _e('You can prevent the featured image getting into the header. Disable this only if you want to show the default header image, set from the Theme\'s Settings, Display Options tab. Normaly, when the Featured Image is displayed as the header, it is excluded from the slider, but when the default header image is shown, is included normaly on the room\'s slider.', 'ci_theme'); ?></p>
	<p>
		<input type="radio" id="ci_cpt_room_featured_header" name="ci_cpt_room_featured_header" value="enabled" <?php checked($featured_header, 'enabled'); ?> /> 
		<label for="ci_cpt_room_featured_header"><?php _e('Use the Featured Image as the header image for this room.', 'ci_theme'); ?></label>
	</p>
	<p>
		<input type="radio" id="ci_cpt_room_featured_header_not" name="ci_cpt_room_featured_header" value="disabled" <?php checked($featured_header, 'disabled'); ?> /> 
		<label for="ci_cpt_room_featured_header_not"><?php _e('Don\'t use the Featured Image as the header image for this room.', 'ci_theme'); ?></label>
	</p>


	<h2><?php _e('Amenities', 'ci_theme'); ?></h2>
	<p><?php _e('Provide the amenities of the room. Select <b>Add Field</b> as many times as you want to create a list of amenities. You can delete one by clicking on its <b>Remove me</b> link next to it. You may also click and drag the fields to re-arrange them.' , 'ci_theme'); ?></p>
	<fieldset class="amenities">
		<a href="#" id="amenities-add-field"><?php _e('Add Field', 'ci_theme'); ?></a>
		<div class="inside">
			<?php
				$fields = get_post_meta($post->ID, 'ci_cpt_room_amenities', true);
				if (!empty($fields)) 
				{
					for( $i = 0; $i < count($fields); $i++ )
					{
						echo '<p class="amenities-field"><input type="text" name="ci_cpt_room_amenities[]" value="'. $fields[$i] .'" /> <a href="#" class="amenities-remove">' . __('Remove me', 'ci_theme') . '</a></p>';
					}
				}
			?>
		</div>
	</fieldset>
	
	
	<?php
		 $ci_room_from = get_post_meta($post->ID, 'ci_cpt_room_from', true);
		 $ci_room_offer = get_post_meta($post->ID, 'ci_cpt_room_offer', true);
	?>
	<h2><?php _e('Room offers', 'ci_theme'); ?></h2>
	<p><?php _e('Room starting price. Include currency symbol' , 'ci_theme'); ?></p>
	<p>
		<label for="ci_room_from"><?php _e('From price', 'ci_theme'); ?></label><br>
		<input id="ci_room_from" name="ci_cpt_room_from" type="text" value="<?php echo $ci_room_from; ?>" class="code" style="width:230px" />
	</p>
	<p>
		<label for="ci_room_offer"><?php _e('Is it an offer?', 'ci_theme'); ?></label><br>
		<input id="ci_room_offer" name="ci_cpt_room_offer" type="checkbox" <?php if($ci_room_offer): ?> checked="checked" <?php endif; ?> />
	</p>	

	<style type="text/css">
		.amenities .inside p { background:#f1f1f1; margin-bottom:0; padding:5px 0 5px 10px; }
		.amenities .inside p:hover { background:#e0e0e0; cursor:pointer; }
		#amenities-add-field { display:block; padding:8px 10px; }
		.amenities input { width:auto; margin-bottom:0; }
	</style>
	<?php
}
endif;

//
// Product post type custom admin list
//
add_filter("manage_edit-room_columns", "ci_cpt_room_edit_columns");  
add_action("manage_posts_custom_column",  "ci_cpt_room_custom_columns");  

if( !function_exists('ci_cpt_room_edit_columns') ):
function ci_cpt_room_edit_columns($columns){  
	$c = array(  
		"cb" => $columns['cb'],
		"title" => $columns['title'],
		"room_category" => __('Categories', 'ci_theme'),
		"date" => $columns['date']
	);
	
	return $c;
}
endif;

if( !function_exists('ci_cpt_room_custom_columns') ):
function ci_cpt_room_custom_columns($column){
	global $post;
	switch ($column)
	{
		case "room_category": 
			$terms = wp_get_post_terms($post->ID, 'room_category');
			$list='';
			foreach($terms as $term)
			{
				$list .= $term->name.'<br />';
			}
			$list = substr($list, 0, -6);
			echo $list;
		break;
	}
}
endif;

?>
