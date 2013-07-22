<?php
//
// Uncomment one of the following two. Their functions are in panel/generic.php
//
//add_action('wp_enqueue_scripts', 'ci_enqueue_modernizr');
add_action('wp_enqueue_scripts', 'ci_print_html5shim');


// This function lives in panel/generic.php
add_action('wp_footer', 'ci_print_selectivizr', 100);



add_action('init', 'ci_register_theme_scripts');
if( !function_exists('ci_register_theme_scripts') ):
function ci_register_theme_scripts()
{
	//
	// Register all scripts here, both front-end and admin. 
	// There is no need to register them conditionally, as the enqueueing can be conditional.
	//
	wp_register_script('jquery-dropkick', get_child_or_parent_file_uri('/js/dropkick.js'), array('jquery'), false, true);
	wp_register_script('jquery-ui', get_child_or_parent_file_uri('/js/jquery-ui-1.8.21.custom.min.js'), array('jquery'), false, true);
    wp_enqueue_script( 'html5gallery', get_template_directory_uri() . '/html5gallery/html5gallery.js');
	wp_register_script('jquery-slider', get_child_or_parent_file_uri('/js/slider.js'), array('jquery'), false, true);

	wp_register_script('ci-front-scripts', get_child_or_parent_file_uri('/js/jquery.scripts.js'),
		array(
			//'jquery',
			'jquery-superfish',
			'jquery-flexslider',
			'jquery-dropkick',
			'jquery-ui',
			'jquery-slider'
		),
		false, true);
}
endif;



add_action('wp_enqueue_scripts', 'ci_enqueue_theme_scripts');
if( !function_exists('ci_enqueue_theme_scripts') ):
function ci_enqueue_theme_scripts()
{
	//
	// Enqueue all (or most) front-end scripts here.
	// They can be also enqueued from within template files.
	//	
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	wp_enqueue_script('ci-front-scripts');
	
	$params['weather_code'] = (string)ci_setting('weather_code');
	$params['weather_unit'] = (string)ci_setting('weather_unit');
	wp_localize_script('ci-front-scripts', 'ThemeOption', $params);

}
endif;


if( !function_exists('ci_enqueue_admin_theme_scripts') ):
add_action('admin_enqueue_scripts','ci_enqueue_admin_theme_scripts');
function ci_enqueue_admin_theme_scripts() 
{
	global $pagenow;

	//
	// Enqueue here scripts that are to be loaded on all admin pages.
	//

	if(is_admin() and $pagenow=='themes.php' and isset($_GET['page']) and $_GET['page']=='ci_panel.php')
	{
		//
		// Enqueue here scripts that are to be loaded only on CSSIgniter Settings panel.
		//

	}
}
endif;



add_action('wp_footer', 'ci_print_remove_img_width_height', 110);
if( !function_exists('ci_print_remove_img_width_height') ):
function ci_print_remove_img_width_height()
{	
	?>
	<!--[if (gte IE 6)&(lte IE 8)]>
		<script type="text/javascript">
			var imgs, i, w;
			var imgs = document.getElementsByTagName( 'img' );
			for( i = 0; i < imgs.length; i++ ) {
				w = imgs[i].getAttribute( 'width' );
				imgs[i].removeAttribute( 'width' );
				imgs[i].removeAttribute( 'height' );
			}
		</script>
	<![endif]-->
	<?php
}
endif;

?>
