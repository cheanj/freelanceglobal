<?php
add_action( 'widgets_init', 'ci_widgets_init' );
if( !function_exists('ci_widgets_init') ):
function ci_widgets_init() {

	register_sidebar(array(
		'name' => __( 'Homepage', 'ci_theme'),
		'id' => 'homepage',
		'description' => __( '3 widgets under the slider. Use the CI Page widget.', 'ci_theme'),
		'before_widget' => '<article id="%1$s" class="one-third block column">',
		'after_widget' => '</article>',
		'before_title' => '<h1>',
		'after_title' => '</h1>'
	));		

	register_sidebar(array(
		'name' => __( 'Blog Sidebar', 'ci_theme'),
		'id' => 'sidebar-blog',
		'description' => __( 'Sidebar on blog pages', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="double"><span>',
		'after_title' => '<span></h3>'
	));
	
	register_sidebar(array(
		'name' => __( 'Rooms Sidebar', 'ci_theme'),
		'id' => 'sidebar-room',
		'description' => __( 'Sidebar for the room pages', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="double"><span>',
		'after_title' => '<span></h3>'
	));
	
	register_sidebar(array(
		'name' => __( 'Pages Sidebar', 'ci_theme'),
		'id' => 'sidebar-pages',
		'description' => __( 'Sidebar for pages', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="double"><span>',
		'after_title' => '<span></h3>'
	));

	register_sidebar(array(
		'name' => __( 'Footer Left', 'ci_theme'),
		'id' => 'footer-left',
		'description' => __( 'Widget area on the footer (left column).', 'ci_theme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s group">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="double"><span>',
		'after_title' => '</span></h3>'
	));	

	register_sidebar(array(
		'name' => __( 'Footer Middle', 'ci_theme'),
		'id' => 'footer-middle',
		'description' => __( 'Widget area on the footer (middle column).', 'ci_theme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s group">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="double"><span>',
		'after_title' => '</span></h3>'
	));	

	register_sidebar(array(
		'name' => __( 'Footer Right', 'ci_theme'),
		'id' => 'footer-right',
		'description' => __( 'Widget area on the footer (right column).', 'ci_theme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s group">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="double"><span>',
		'after_title' => '</span></h3>'
	));	

	
	register_sidebar(array(
		'name' => __( 'Footer Social Links', 'ci_theme'),
		'id' => 'footer-social',
		'description' => sprintf(__( 'Social links on footer. Use the Socials Ignited widget, available from %s', 'ci_theme'), 'http://wordpress.org/plugins/socials-ignited/'),
		'before_widget' => '<div id="%1$s" class="widget %2$s group">',
		'after_widget' => '</div>',
		'before_title' => '',
		'after_title' => ''
	));	
	
	register_sidebar(array(
		'name' => __( 'Rooms Testimonial', 'ci_theme'),
		'id' => 'rooms-testimonials',
		'description' => __( 'Display a client testimonial in the Rooms listing page under the first 2 or 3 rooms (Depending on the template)', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="double"><span>',
		'after_title' => '<span></h3>'
	));
	
	register_sidebar(array(
		'name' => __( 'Galleries Testimonial', 'ci_theme'),
		'id' => 'galleries-testimonials',
		'description' => __( 'Display a client testimonial in the Galleries listing page under the first 2 or 3 galleries (Depending on the template)', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="double"><span>',
		'after_title' => '<span></h3>'
	));
	
	register_sidebar(array(
		'name' => __( 'Homepage Testimonial', 'ci_theme'),
		'id' => 'home-testimonials',
		'description' => __( 'Display a client testimonial in the Homepage under the 3 boxes', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '',
		'after_title' => ''
	));									

}
endif;
?>
