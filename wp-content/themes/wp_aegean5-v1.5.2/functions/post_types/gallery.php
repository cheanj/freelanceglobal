<?php
//
// Gallery Post Type related functions.
//
add_action('init', 'ci_create_cpt_gallery');
add_action('admin_init', 'ci_add_cpt_gallery_meta');
add_action('save_post', 'ci_update_cpt_gallery_meta');

if( !function_exists('ci_create_cpt_gallery') ):
function ci_create_cpt_gallery()
{
	$labels = array(
		'name' => _x('Galleries', 'post type general name', 'ci_theme'),
		'singular_name' => _x('Gallery', 'post type singular name', 'ci_theme'),
		'add_new' => __('New Gallery', 'ci_theme'),
		'add_new_item' => __('Add New Gallery', 'ci_theme'),
		'edit_item' => __('Edit Gallery', 'ci_theme'),
		'new_item' => __('New Gallery', 'ci_theme'),
		'view_item' => __('View Gallery', 'ci_theme'),
		'search_items' => __('Search Galleries', 'ci_theme'),
		'not_found' =>  __('No Galleries found', 'ci_theme'),
		'not_found_in_trash' => __('No Galleries found in the trash', 'ci_theme'), 
		'parent_item_colon' => __('Parent Gallery Item:', 'ci_theme')
	);

	$args = array(
		'labels' => $labels,
		'singular_label' => __('Gallery', 'ci_theme'),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'has_archive' => true,
		'rewrite' => true,
		'menu_position' => 5,
		'supports' => array('title', 'editor', 'thumbnail')
	);

	register_post_type( 'gallery' , $args );
}
endif;

if( !function_exists('ci_add_cpt_gallery_meta') ):
function ci_add_cpt_gallery_meta()
{
	add_meta_box("ci_cpt_gallery_meta", __('Gallery Details', 'ci_theme'), "ci_add_cpt_gallery_meta_box", "gallery", "normal", "high");
}
endif;

if( !function_exists('ci_update_cpt_gallery_meta') ):
function ci_update_cpt_gallery_meta($post_id)
{
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
	if (isset($_POST['post_type']) && $_POST['post_type'] == "gallery")
	{
		update_post_meta($post_id, "ci_cpt_gallery", (isset($_POST["ci_cpt_gallery"]) ? $_POST["ci_cpt_gallery"] : '') );
	}
}
endif;

if( !function_exists('ci_add_cpt_gallery_meta_box') ):
function ci_add_cpt_gallery_meta_box()
{
	global $post;
	$gallery = get_post_meta($post->ID, 'ci_cpt_gallery', true);
	?>

	<h2><?php _e('Gallery', 'ci_theme'); ?></h2>
	<p><?php echo sprintf(__('You should upload multiple images for your gallery. You should also set a <strong>Featured Image</strong> that will be used as the cover of the gallery. This can be done by clicking <a href="#" class="ci-upload">here</a>, or by pressing the <strong>Upload</strong> button below, or via the <strong>Add Media <img src="%s" /> button</strong> which is located just below the title.', 'ci_theme'), get_admin_url().'/images/media-button.png'); ?></p>
	<p><input type="button" class="button ci-upload" value="<?php _e('Upload Images', 'ci_theme'); ?>" /></p>
	<?php 
} 
endif;
?>
