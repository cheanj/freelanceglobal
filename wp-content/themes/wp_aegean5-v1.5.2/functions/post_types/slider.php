<?php
//
// Slider Post Type related functions.
//
add_action('init', 'ci_create_cpt_slider');
if( !function_exists('ci_create_cpt_slider') ):
function ci_create_cpt_slider()
{
	$labels = array(
		'name' => _x('Slider Items', 'post type general name', 'ci_theme'),
		'singular_name' => _x('Slider Item', 'post type singular name', 'ci_theme'),
		'add_new' => __('New Slider Item', 'ci_theme'),
		'add_new_item' => __('Add New Slider Item', 'ci_theme'),
		'edit_item' => __('Edit Slider Item', 'ci_theme'),
		'new_item' => __('New Slider Item', 'ci_theme'),
		'view_item' => __('View Slider Item', 'ci_theme'),
		'search_items' => __('Search Slider Items', 'ci_theme'),
		'not_found' =>  __('No Slider Items found', 'ci_theme'),
		'not_found_in_trash' => __('No Slider Items found in the trash', 'ci_theme'), 
		'parent_item_colon' => __('Parent Slider Item:', 'ci_theme')
	);

	$args = array(
		'labels' => $labels,
		'singular_label' => __('Slider Item', 'ci_theme'),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'has_archive' => false,
		'rewrite' => true,
		'menu_position' => 5,
		'supports' => array('title', 'editor', 'thumbnail')
		//'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats') 
	);

	register_post_type( 'slider' , $args );
}
endif;
?>
