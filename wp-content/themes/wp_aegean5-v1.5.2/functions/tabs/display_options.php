<?php global $ci, $ci_defaults, $load_defaults, $content_width; ?>
<?php if ($load_defaults===TRUE): ?>
<?php
	add_filter('ci_panel_tabs', 'ci_add_tab_display_options', 30);
	if( !function_exists('ci_add_tab_display_options') ):
		function ci_add_tab_display_options($tabs) 
		{ 
			$tabs[sanitize_key(basename(__FILE__, '.php'))] = __('Display Options', 'ci_theme'); 
			return $tabs; 
		}
	endif;
	
	// Default values for options go here.
	// $ci_defaults['option_name'] = 'default_value';
	// or
	// load_panel_snippet( 'snippet_name' );
	load_panel_snippet('excerpt');
	load_panel_snippet('seo');
	load_panel_snippet('comments');

	$ci_defaults['default_header_bg'] 			= ''; // Holds the URL of the image file to use as header background
	$ci_defaults['default_header_bg_hidden'] 	= ''; // Holds the attachment ID of the image file to use as header background
	$ci_defaults['blog_sidebar']				= 'left';
	$ci_defaults['show_related_posts']			= 'enabled';
	$ci_defaults['show_bc']						= 'disabled';
	$ci_defaults['room_thumbnail_shows']		= 'lightbox';
	$ci_defaults['footer_blog_show'] 			= 'enabled';
	$ci_defaults['footer_blog_posts'] 			= 2;
	$ci_defaults['footer_newsletter_show'] 		= 'enabled';



	add_filter('ci_featured_image_post_types', 'ci_add_featured_img_cpt');
	if( !function_exists('ci_add_featured_img_cpt') ):
	function ci_add_featured_img_cpt($post_types)
	{
		//$post_types[] = 'room';
		return $post_types;		
	}
	endif;
	load_panel_snippet('featured_image_single');


	// Set our full width template width.
	add_filter('ci_full_template_width', 'ci_fullwidth_width');
	if( !function_exists('ci_full_template_width') ):
	function ci_fullwidth_width()
	{ 
		return 940; 
	}
	endif;
	load_panel_snippet('featured_image_fullwidth');
	
?>
<?php else: ?>
		
	<fieldset class="set">
		<p class="guide"><?php _e('Upload or select an image to be used as the default header background on your blog section. This will be displayed only on listing pages and when the currently showing post has no featured image attached. For best results, use a high resolution image, more than 1920 pixels wide.', 'ci_theme'); ?></p>
		<fieldset>
			<?php ci_panel_upload_image('default_header_bg', __('Upload a header image', 'ci_theme')); ?>
			<input type="hidden" class="uploaded-id" name="<?php echo THEME_OPTIONS; ?>[default_header_bg_hidden]" value="<?php echo $ci['default_header_bg_hidden']; ?>" />
		</fieldset>
	</fieldset>
	
	<fieldset class="set">
		<p class="guide"><?php _e('Sidebar location. Left or Right. This affects blog listing, pages and single templates of all types.', 'ci_theme'); ?></p>
		<?php ci_panel_radio('blog_sidebar', 'blog_sidebar_left', 'left', __('Left sidebar', 'ci_theme')); ?>
		<?php ci_panel_radio('blog_sidebar', 'blog_sidebar_right', 'right', __('Right sidebar', 'ci_theme')); ?>
	</fieldset>


	<?php load_panel_snippet('excerpt'); ?>	

	<?php load_panel_snippet('seo'); ?>	

	<?php load_panel_snippet('comments'); ?>	

	<?php load_panel_snippet('featured_image_single'); ?>

	<?php load_panel_snippet('featured_image_fullwidth'); ?>
	
	<fieldset class="set">
		<p class="guide"><?php _e('You can enable or disable the Breadcrumbs. If you enable them, you need to install the <a href="http://wordpress.org/extend/plugins/breadcrumb-navxt/">Breadcrumb NavXT</a> plugin.' , 'ci_theme'); ?></p>
		<?php ci_panel_checkbox('show_bc', 'enabled', __('Show Breadcrumbs', 'ci_theme')); ?>
	</fieldset>
	
	<fieldset class="set">
		<p class="guide"><?php _e('You can enable or disable the "Related posts" sections that appear on Rooms, just below the content.' , 'ci_theme'); ?></p>
		<?php ci_panel_checkbox('show_related_posts', 'enabled', __('Show Related Posts', 'ci_theme')); ?>
	</fieldset>
		
	<fieldset class="set">
		<p class="guide"><?php _e('Select what you want to happen when the room thumbnail gets clicked.', 'ci_theme'); ?></p>
		<?php ci_panel_radio('room_thumbnail_shows', 'room_thumbnail_shows_lightbox', 'lightbox', __('View image in lightbox', 'ci_theme')); ?>
		<?php ci_panel_radio('room_thumbnail_shows', 'room_thumbnail_shows_room', 'room', __('View room page', 'ci_theme')); ?>
	</fieldset>

	<fieldset class="set">
		<p class="guide"><?php _e('You can enable or disable the blog posts and the newsletter subscription form that appear on the footer. Disabling one of the two, will stretch the other to fill the space.' , 'ci_theme'); ?></p>
		<?php ci_panel_checkbox('footer_blog_show', 'enabled', __('Show blog posts on footer', 'ci_theme')); ?>
		<fieldset class="mt5">
			<?php ci_panel_input('footer_blog_posts', __('Number of blog posts to show', 'ci_theme')); ?>
		</fieldset>

		<?php ci_panel_checkbox('footer_newsletter_show', 'enabled', __('Show newsletter subscription form on footer', 'ci_theme')); ?>
	</fieldset>

		
<?php endif; ?>
