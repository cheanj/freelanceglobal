<?php 
	get_template_part('panel/constants');

	load_theme_textdomain( 'ci_theme', get_template_directory() . '/lang' );

	// This is the main options array. Can be accessed as a global in order to reduce function calls.
	$ci = get_option(THEME_OPTIONS);
	$ci_defaults = array();

	// The $content_width needs to be before the inclusion of the rest of the files, as it is used inside of some of them.
	if ( ! isset( $content_width ) ) $content_width = 640;

	//
	// Let's bootstrap the theme.
	//
	get_template_part('panel/bootstrap');


	//
	// Define our various image sizes.
	//
	add_theme_support( 'post-thumbnails' );
	add_image_size('ci_home_widgets', 500, 250, true );
	add_image_size('ci_home_slider', 1920, 750, true);
	add_image_size('ci_page_header', 2200, 230, true);
	add_image_size('ci_blog_featured', 630, 150, true);
	add_image_size('ci_room_2col', 450, 220, true);
	add_image_size('ci_room_slider', 920, 390, true);
	add_image_size('ci_room_related', 640, 240, true);

	add_fancybox_support();

	// Let the user choose a color scheme on each post individually.
	add_ci_theme_support('post-color-scheme', array('page', 'post', 'room'));


add_filter( 'post_limits', 'my_post_limits' );
function my_post_limits( $limit ) {
    if ( is_search() ) {
        return 'LIMIT 0, 2';
    }
    return $limit;
}

if ( function_exists('register_sidebar') )
    register_sidebar(array(
  'name'=>'Testimonials',
  'before_widget' => '<li id="%1$s" class="widget %2$s"><div>',
  'after_widget' => "</div></li>\n",
  'before_title' => '<h2>',
  'after_title' => "</h2>\n",
    ));

function split_content2() {
    global $more;
    $more = true;
    $content = preg_split('/<span id="more-\d+"><\/span>/i', get_the_content('more'));
    // first content section in column1
    $ret = '<div id="column1" class="content-column1">'. array_shift($content). '</div>';
    // remaining content sections in column2
    if (!empty($content)) $ret .= '<div id="column2" class="content-column2">'. implode($content). '</div>';
    return apply_filters('the_content', $ret);
}



function split_content() {
    global $more;
    $more = true;
    $content = preg_split('/<span id="more-\d+"><\/span>/i', get_the_content('more'));
    // first content section in column1

    $firstSection = array_shift($content);

    $content_first =  explode(" ", $firstSection);
    $countW = count($content_first);
    $split_w = round($countW/2);
?>
<div class="content-column1">
<?php for ($i=0;$i<=$split_w;$i++) {
	echo $content_first[$i]. ' ';
	$halfPoint = $i;
} echo $content_first[$i].' '; $halfPoint = $i; ?>
</div>
    <div class="content-column2">
    	<?php for ($i=$halfPoint;$i<=$countW;$i++) print $content_first[$i].' '; ?>
    </div>

<?php

}
?>