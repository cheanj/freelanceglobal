<?php
/*
Plugin Name: Single Latest Posts Lite
Plugin URI: http://wordpress.org/extend/plugins/single-latest-posts-lite/
Description: Display the latest posts available in your WordPress blog using functions, shortcodes or widgets.
Version: 1.3
Author: L'Elite
Author URI: http://laelite.info/
License: GNU General Public License 2.0 (GPL) http://www.gnu.org/licenses/gpl.html
*/
/***********************

++++++ TERMINAR DE INTEGRAR EL FOOTER_META PARA SACAR (FALTAN WIDGET Y TINYMCE OPCIONES)
++++++ VERSION 1.2.6

************************/
/**
 *
 * Copyright 2007 - 2013 L'Elite de José SAYAGO (opensource@laelite.info)
 * 'SLPosts Lite', 'SLPosts Pro', 'NLPosts' are unregistered trademarks of L'Elite, 
 * and cannot be re-used in conjuction with the GPL v2 usage of this software 
 * under the license terms of the GPL v2 without permission.
 *
 * Single Latest Posts brings all the awesomeness available
 * in Network Latest Posts to individual WordPress installations.
 *
 */
// Config File
require_once dirname( __FILE__ ) . '/single-latest-posts-config.php';
/* Single Latest Posts Main Function
 *
 * Where the magic happens ;)
 *
 * List of Parameters
 *
 * -- @title              : Widget/Shortcode main title (section title)
 * -- @number_posts       : Number of posts to retrieve.
 * -- @time_frame         : Period of time to retrieve the posts from in days. Ex: 5 means, find all articles posted in the last 5 days
 * -- @title_only         : Display post titles only, if false then excerpts will be shown
 * -- @display_type       : How to display the articles, as an: unordered list (ulist), ordered list (olist) or block elements
 * -- @thumbnail          : If true then thumbnails will be shown, if active and not found then a placeholder will be used instead
 * -- @thumbnail_wh       : Thumbnails size, width and height in pixels, while using the shortcode or a function this parameter must be passed like: '80x80'
 * -- @thumbnail_class    : Thumbnail class, set a custom class (alignleft, alignright, center, etc)
 * -- @thumbnail_filler   : Placeholder to use if the post's thumbnail couldn't be found, options: placeholder, kittens, puppies (what?.. I can be funny sometimes)
 * -- @category           : Category you want to display. Ex: cats means, pull posts saved under the category cats
 * -- @tag                : Same as categoy WordPress treats both taxonomies the same way
 * -- @paginate           : Display results by pages, if used then the parameter posts_per_page must be specified, otherwise pagination won't be displayed
 * -- @posts_per_page     : Set the number of posts to display by page (paginate must be activated)
 * -- @excerpt_length     : Set the excerpt's length in case you think it's too long for your needs Ex: 40 means, 40 words
 * -- @auto_excerpt       : If true then it will generate an excerpt from the post content, it's useful for those who forget to use the Excerpt field in the post edition page
 * -- @excerpt_trail      : Set the type of trail you want to append to the excerpts: text, image. The text will be _more_, the image is inside the plugin's img directory and it's called excerpt_trail.png
 * -- @full_meta          : Display the date and the author of the post, for the date/time each blog time format will be used
 * -- @display_comments   : Display comments count, this parameter depends on full_meta, if full_meta is not active this parameter will not show anything even if it's active, false by default
 * -- @post_status        : Specify the status of the posts you want to display: publish, new, pending, draft, auto-draft, future, private, inherit, trash
 * -- @css_style          : Use a custom CSS style instead of the one included by default, useful if you want to customize the front-end display: filename (without extension), this file must be located where your active theme CSS style is located
 * -- @wrapper_list_css   : Custom CSS classes for the list wrapper
 * -- @wrapper_block_css  : Custom CSS classes for the block wrapper
 * -- @instance           : This parameter is intended to differentiate each instance of the widget/shortcode/function you use, it's required in order for the asynchronous pagination links to work
 * -- @suppress_filters   : This parameter is specially useful when dealing with WP_Query custom filters, if you are using a plugin like Advanced Category Excluder then you must set this value to YES/TRUE
 */
function single_latest_posts( $parameters ) {
    // Global variables
    global $wpdb;
    $total = 0;
    // Default values
    $defaults = array(
        /*
         * General settings
         */
        'title'            => NULL,          // Section title
        'title_only'       => TRUE,          // Display the post title only
        'instance'         => NULL,          // Instance identifier, used to uniquely differenciate each shortcode or widget used
        'suppress_filters' => FALSE,         // Suppress query filters
        /*
         * Posts Settings
         */
        'number_posts'     => 10,            // Number of posts to be displayed
        'time_frame'       => 0,             // Time frame to look for posts in days
        'post_status'      => 'publish',     // Post status (publish, new, pending, draft, auto-draft, future, private, inherit, trash)
        'category'         => NULL,          // Category to display
        'tag'              => NULL,          // Tag to display
        'excerpt_length'   => NULL,          // Excerpt's length
        'auto_excerpt'     => FALSE,         // Generate excerpt from content
        'excerpt_trail'    => 'text',        // Excerpt's trailing element: text, image
        'full_meta'        => FALSE,         // Display full metadata
        'footer_meta'      => FALSE,         // Display footer metadata
        'display_comments' => FALSE,         // Display comments' count (true or false)
        /*
         * Pagination & Sorting
         */
        'paginate'         => FALSE,         // Paginate results
        'posts_per_page'   => NULL,          // Number of posts per page (paginate must be activated)
        /*
         * Thumbnail settings
         */
        'thumbnail'        => FALSE,         // Display the thumbnail
        'thumbnail_wh'     => '150x150',     // Thumbnail Width & Height in pixels
        'thumbnail_filler' => 'placeholder', // Replacement image for posts without thumbnail (placeholder, kittens, puppies)
        'thumbnail_class'  => NULL,          // Thumbnail CSS class
        /*
         * Display Settings
         */
        'display_type'     => 'ulist',       // Display content as a: olist (ordered), ulist (unordered), block
        'css_style'        => NULL,          // Custom CSS _filename_ (ex: custom_style)
        'wrapper_list_css' => 'nav nav-tabs nav-stacked', // Custom CSS classes for the list wrapper
        'wrapper_block_css'=> 'content',     // Custom CSS classes for the block wrapper
    );
    // Parse & merge parameters with the defaults
    $settings = wp_parse_args( $parameters, $defaults );
    // Paranoid mode activated (yes I'm a security freak)
    foreach($settings as $parameter => $value) {
        if( !is_array( $value ) ) {
            if( !is_numeric($value) 
                && $parameter != 'title' 
                && $parameter != 'instance'
                && $parameter != 'thumbnail_class'
                && $parameter != 'css_style'
                && $parameter != 'wrapper_list_css'
                && $parameter != 'wrapper_block_css' ) {
                // Strip & lowercase everything
                $settings[$parameter] = trim( strip_tags( strtolower( $value ) ) );
            } else {
                // Strip everything
                $settings[$parameter] = strip_tags($value);
            }
        }
    }
    // Extract each parameter as its own variable
    extract( $settings, EXTR_SKIP );
    // If no instance was set, make one
    if( empty($instance) ) { $instance = 'default'; }
    // HTML Tags
    $html_tags = slp_display_type($display_type, $instance, $wrapper_list_css, $wrapper_block_css);
    // If Custom CSS
    if( !empty($css_style) ) {
        // If RTL
        if( is_rtl() ) {
            // Tell WordPress this plugin is switching to RTL mode
            /* Set the text direction to RTL
             * This two variables will tell load-styles.php
             * load the Dashboard in RTL instead of LTR mode
             */
            global $wp_locale, $wp_styles;
            $wp_locale->text_direction = 'rtl';
            $wp_styles->text_direction = 'rtl';
        }
        // File path
        $cssfile = get_stylesheet_directory_uri().'/'.$css_style.'.css';
        // Load styles
        slp_load_styles($cssfile);
    }
    // Tag
    if( !empty($tag) ) {
        $tag = str_split($tag,strlen($tag));
    }
    // Category
    if( !empty($category) ) {
        $category = str_split($category,strlen($category));
    }
    $date_format = get_option('date_format');
    // Paranoid ;)
    $time_frame = (int)$time_frame;
    // Orderby
    $orderby = 'post_date';
    // Categories or Tags
    if( !empty($category) && !empty($tag) ) {
        $args = array(
            'tax_query' => array(
                'relation' => 'OR',
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $category
                ),
                array(
                    'taxonomy' => 'post_tag',
                    'field' => 'slug',
                    'terms' => $tag
                )
            ),
            'numberposts' => $number_posts,
            'post_status' => $post_status,
            'orderby' => $orderby
        );
    }
    // Categories only
    if( !empty($category) && empty($tag) ) {
        $args = array(
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $category
                )
            ),
            'numberposts' => $number_posts,
            'post_status' => $post_status,
            'orderby' => $orderby
        );
    }
    // Tags only
    if( !empty($tag) && empty($category) ) {
        $args = array(
            'tax_query' => array(
                array(
                    'taxonomy' => 'post_tag',
                    'field' => 'slug',
                    'terms' => $tag
                )
            ),
            'numberposts' => $number_posts,
            'post_status' => $post_status,
            'orderby' => $orderby
        );
    }
    // Everything by Default
    if( empty($category) && empty($tag) ) {
        // By default
        $args = array(
            'numberposts' => $number_posts,
            'post_status' => $post_status,
            'orderby' => $orderby
        );
    }
    // Suppress Query Filters
    if( $suppress_filters == 'true' || $suppress_filters == true ) {
        $args['suppress_filters'] = true;
    }
    $posts_list = slp_get_posts($args, $time_frame);
    // Put everything inside an array for sorting purposes
    foreach( $posts_list as $post ) {
        // Access all post data
        setup_postdata($post);
        // Put everything inside another array using the modified date as
        // the array keys
        $all_posts[$post->post_modified] = $post;
        // The guid is the only value which can differenciate a post from
        // others in the whole network
        $all_permalinks[$post->guid] = get_permalink($post->ID);
    }
    // If no content was found
    if( empty( $all_posts ) ) {
        echo '
        <div id="slposts">
            <div class="slp-alert">
            <button type="button" class="slp-close" data-dismiss="alert">×</button>
            '.__('Sorry, I could not find content matching your parameters.','trans-slp').'
            </div>
        </div>
        ';
        // Close the door and get out of here
        return;
    }

    if( function_exists( 'ace_init' ) ) {

    }
    // Open content box
    echo $html_tags['content_o'];
    // slposts title
    if( !empty($title) ) {
        // Open widget title box
        echo $html_tags['wtitle_o'];
        // Print the title
        echo $title;
        // Close widget title box
        echo $html_tags['wtitle_c'];
    }
    // Open wrapper
    echo $html_tags['wrapper_o'];
    // Paginate results
    if( $paginate && $posts_per_page ) {
        // Page number
        $pag = isset( $_GET['pag'] ) ? abs( (int) $_GET['pag'] ) : 1;
        // Break all posts into pages
        $pages = array_chunk($all_posts, $posts_per_page);
        // Set the page number variable
        add_query_arg('pag','%#%');
        // Print out the posts
        foreach( $pages[$pag-1] as $field ) {
            // Open item box
            echo $html_tags['item_o'];
            // Thumbnails
            if( $thumbnail === 'true' ) {
                // Open thumbnail container
                echo $html_tags['thumbnail_o'];
                // Open thumbnail item placeholder
                echo $html_tags['thumbnail_io'];
                // Put the dimensions into an array
                $thumbnail_size = str_replace('x',',',$thumbnail_wh);
                $thumbnail_size = explode(',',$thumbnail_size);
                // Get the thumbnail
                $thumb_html = get_the_post_thumbnail($field->ID,$thumbnail_size,array('class' => $thumbnail_class));
                // If there is a thumbnail
                if( !empty($thumb_html) ) {
                    // Display the thumbnail
                    echo "<a href='".$all_permalinks[$field->guid]."'>$thumb_html</a>";
                // Thumbnail not found
                } else {
                    // Put a placeholder with the post title
                    switch($thumbnail_filler) {
                        // Placeholder provided by Placehold.it
                        case 'placeholder':
                            echo "<a href='".$all_permalinks[$field->guid]."'><img src='http://placehold.it/".$thumbnail_wh."&text=".$field->post_title."' alt='".$field->post_title."' title='".$field->post_title."' /></a>";
                            break;
                        // Just for fun Kittens thanks to PlaceKitten
                        case 'kittens':
                            echo "<a href='".$all_permalinks[$field->guid]."'><img src='http://placekitten.com/".$thumbnail_size[0]."/".$thumbnail_size[1]."' alt='".$field->post_title."' title='".$field->post_title."' /></a>";
                            break;
                        // More fun Puppies thanks to PlaceDog
                        case 'puppies':
                            echo "<a href='".$all_permalinks[$field->guid]."'><img src='http://placedog.com/".$thumbnail_size[0]."/".$thumbnail_size[1]."' alt='".$field->post_title."' title='".$field->post_title."' /></a>";
                            break;
                        // Boring by default ;)
                        default:
                            echo "<a href='".$all_permalinks[$field->guid]."'><img src='http://placehold.it/".$thumbnail_wh."&text=".$field->post_title."' alt='".$field->post_title."' title='".$field->post_title."' /></a>";
                            break;
                    }
                }
                // Caption Wrapper
                echo $html_tags['caption_o'];
                // Open title box
                echo $html_tags['title_o'];
                // Print the title
                echo "<a href='".$all_permalinks[$field->guid]."'>".$field->post_title."</a>";
                // Close the title box
                echo $html_tags['title_c'];
                if( $full_meta === 'true' ) {
                    // Open meta box
                    echo $html_tags['meta_o'];
                    // Set metainfo
                    $author = get_user_by('id',$field->post_author);
                    $format = get_option('date_format');
                    $datepost = date_i18n($format, strtotime(trim( $field->post_date) ) );
                    $author_url = get_author_posts_url($author->ID);
                    if( $display_comments === 'true' ) {
                        $comments_args = array(
                            'post_id' => $field->ID,
                            'count' => true
                        );
                        $count_comments = "<a href='".get_comments_link( $field->ID )."'><i class='slpicon-comment'></i> ".get_comments( $comments_args )."</a>";
                        // Print metainfo
                        if( !is_rtl() ) {
                            echo $datepost . ' ' . $count_comments;
                        } else {
                            echo $count_comments . ' - ' . $datepost;
                        }
                    } else {
                        // Print metainfo
                        echo $datepost;
                    }
                    // Close meta box
                    echo $html_tags['meta_c'];
                }
                // Print the content
                if( $title_only === 'false' ) {
                    // Open excerpt wrapper
                    echo $html_tags['excerpt_o'];
                    // Custom Excerpt
                    if( $auto_excerpt != 'true' ) {
                        // Print out the excerpt
                        echo slp_custom_excerpt($excerpt_length, $field->post_excerpt, $all_permalinks[$field->guid],$excerpt_trail);
                    // Extract excerpt from content
                    } else {
                        // If post has excerpt then print that
                        if( !empty( $field->post_excerpt ) ) {
                            echo slp_custom_excerpt( $excerpt_length, $field->post_excerpt, $all_permalinks[$field->guid],$excerpt_trail );
                        // Otherwise, create one from content
                        } else {
                            // Get the excerpt
                            echo slp_custom_excerpt($excerpt_length, $field->post_content, $all_permalinks[$field->guid],$excerpt_trail);
                        }
                    }
                    // Close excerpt wrapper
                    echo $html_tags['excerpt_c'];
                }
                if( $full_meta == 'true' && $footer_meta == 'true' ) {
                    /* translators: used between list items, there is a space after the comma */
                    $categories_list = get_the_category_list( __( ', ', 'trans-slp' ) , '', $field->ID);
                    /* translators: used between list items, there is a space after the comma */
                    $tag_list = get_the_tag_list( '', __( ', ', 'trans-slp' ), '', $field->ID );
                    if ( '' != $tag_list ) {
                        $utility_text = __( 'This entry was posted in %1$s and tagged %2$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'trans-slp' );
                    } elseif ( '' != $categories_list ) {
                        $utility_text = __( 'This entry was posted in %1$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'trans-slp' );
                    } else {
                        $utility_text = __( 'This entry was posted by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'trans-slp' );
                    }
                    echo $html_tags['meta_fo'];
                    printf(
                        $utility_text,
                        $categories_list,
                        $tag_list,
                        esc_url( get_permalink() ),
                        the_title_attribute( 'echo=0' ),
                        $author->display_name,
                        esc_url( get_author_posts_url( get_the_author_meta( 'ID', $author->ID ) ) )
                    );
                    echo $html_tags['meta_fc'];
                }
                // Caption Wrapper
                echo $html_tags['caption_c'];
                // Close thumbnail item placeholder
                echo $html_tags['thumbnail_ic'];
                // Close thumbnail container
                echo $html_tags['thumbnail_c'];
            } else {
                // Caption Wrapper
                echo $html_tags['caption_o'];
                // Open title box
                echo $html_tags['title_o'];
                // Print the title
                echo "<a href='".$all_permalinks[$field->guid]."'>".$field->post_title."</a>";
                // Close the title box
                echo $html_tags['title_c'];
                if( $full_meta === 'true' ) {
                    // Open meta box
                    echo $html_tags['meta_o'];
                    // Set metainfo
                    $author = get_user_by('id',$field->post_author);
                    $format = get_option('date_format');
                    $datepost = date_i18n($format, strtotime(trim( $field->post_date) ) );
                    $author_url = get_author_posts_url($author->ID);
                    if( $display_comments === 'true' ) {
                        $comments_args = array(
                            'post_id' => $field->ID,
                            'count' => true
                        );
                        $count_comments = "<a href='".get_comments_link( $field->ID )."'><i class='slpicon-comment'></i> ".get_comments( $comments_args )."</a>";
                        // Print metainfo
                        if( !is_rtl() ) {
                            echo $datepost . ' ' . $count_comments;
                        } else {
                            echo $count_comments . ' - ' . $datepost;
                        }
                    } else {
                        // Print metainfo
                        echo $datepost;
                    }
                    // Close meta box
                    echo $html_tags['meta_c'];
                }
                // Print the content
                if( $title_only === 'false' ) {
                    // Open excerpt wrapper
                    echo $html_tags['excerpt_o'];
                    // Custom Excerpt
                    if( $auto_excerpt != 'true' ) {
                        // Print out the excerpt
                        echo slp_custom_excerpt($excerpt_length, $field->post_excerpt, $all_permalinks[$field->guid],$excerpt_trail);
                    // Extract excerpt from content
                    } else {
                        // If post has excerpt then print that
                        if( !empty( $field->post_excerpt ) ) {
                            echo slp_custom_excerpt( $excerpt_length, $field->post_excerpt, $all_permalinks[$field->guid],$excerpt_trail );
                        // Otherwise, create one from content
                        } else {
                            // Get the excerpt
                            echo slp_custom_excerpt($excerpt_length, $field->post_content, $all_permalinks[$field->guid],$excerpt_trail);
                        }
                    }
                    // Close excerpt wrapper
                    echo $html_tags['excerpt_c'];
                }
                if( $full_meta == 'true' && $footer_meta == 'true' ) {
                    /* translators: used between list items, there is a space after the comma */
                    $categories_list = get_the_category_list( __( ', ', 'trans-slp' ) , '', $field->ID);
                    /* translators: used between list items, there is a space after the comma */
                    $tag_list = get_the_tag_list( '', __( ', ', 'trans-slp' ), '', $field->ID );
                    if ( '' != $tag_list ) {
                        $utility_text = __( 'This entry was posted in %1$s and tagged %2$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'trans-slp' );
                    } elseif ( '' != $categories_list ) {
                        $utility_text = __( 'This entry was posted in %1$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'trans-slp' );
                    } else {
                        $utility_text = __( 'This entry was posted by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'trans-slp' );
                    }
                    echo $html_tags['meta_fo'];
                    printf(
                        $utility_text,
                        $categories_list,
                        $tag_list,
                        esc_url( get_permalink() ),
                        the_title_attribute( 'echo=0' ),
                        $author->display_name,
                        esc_url( get_author_posts_url( get_the_author_meta( 'ID', $author->ID ) ) )
                    );
                    echo $html_tags['meta_fc'];
                }
                // Caption Wrapper
                echo $html_tags['caption_c'];
            }
            // Close item box
            echo $html_tags['item_c'];
        }
        // Print out pagination menu
        for($i=1; $i< count($pages)+1; $i++) {
            // Count the number of pages
            $total += 1;
        }
        echo "<script>console.log('".count($pages)."')</script>";
        // Open pagination wrapper
        echo $html_tags['pagination_o'];
        echo paginate_links( array(
            'base' => add_query_arg( 'pag', '%#%' ),
            'format' => '',
            'prev_text' => __('&laquo;','trans-slp'),
            'next_text' => __('&raquo;','trans-slp'),
            'total' => $total,
            'current' => $pag,
            'type' => 'list'
        ));
        // Close pagination wrapper
        echo $html_tags['pagination_c'];
        // Close wrapper
        echo $html_tags['wrapper_c'];
        /*
         * jQuery function
         * Asynchronous pagination links
         */
        echo '
        <script type="text/javascript" charset="utf-8">
            //<![CDATA[
            jQuery(document).ready(function(){
                jQuery(".slp-instance-'.$instance.' .slp-pagination a").live("click", function(e){
                    e.preventDefault();
                    var link = jQuery(this).attr("href");
                    jQuery(".slp-instance-'.$instance.' .slposts-wrapper").html("<style type=\"text/css\">p.loading { text-align:center;margin:0 auto; padding:20px; }</style><p class=\"loading\"><img src=\"'.plugins_url('core/img/loader.gif', __FILE__) .'\" /></p>");
                    jQuery(".slp-instance-'.$instance.' .slposts-wrapper").fadeOut("slow",function(){
                        jQuery(".slp-instance-'.$instance.' .slposts-wrapper").load(link+" .slp-instance-'.$instance.' .slposts-wrapper > *").fadeIn(3000);
                    });

                });
            });
            //]]>
        </script>';
        // Close content box
        echo $html_tags['content_c'];
    // Without pagination
    } else {
        // Print out the posts
        foreach( $all_posts as $field ) {
            // Open item box
            echo $html_tags['item_o'];
            // Thumbnails
            if( $thumbnail === 'true' ) {
                // Open thumbnail container
                echo $html_tags['thumbnail_o'];
                // Open thumbnail item placeholder
                echo $html_tags['thumbnail_io'];
                // Put the dimensions into an array
                $thumbnail_size = str_replace('x',',',$thumbnail_wh);
                $thumbnail_size = explode(',',$thumbnail_size);
                // Get the thumbnail
                $thumb_html = get_the_post_thumbnail($field->ID,$thumbnail_size,array('class' => $thumbnail_class));
                // If there is a thumbnail
                if( !empty($thumb_html) ) {
                    // Display the thumbnail
                    echo "<a href='".$all_permalinks[$field->guid]."'>$thumb_html</a>";
                // Thumbnail not found
                } else {
                    // Put a placeholder with the post title
                    switch($thumbnail_filler) {
                        // Placeholder provided by Placehold.it
                        case 'placeholder':
                            echo "<a href='".$all_permalinks[$field->guid]."'><img src='http://placehold.it/".$thumbnail_wh."&text=".$field->post_title."' alt='".$field->post_title."' title='".$field->post_title."' /></a>";
                            break;
                        // Just for fun Kittens thanks to PlaceKitten
                        case 'kittens':
                            echo "<a href='".$all_permalinks[$field->guid]."'><img src='http://placekitten.com/".$thumbnail_size[0]."/".$thumbnail_size[1]."' alt='".$field->post_title."' title='".$field->post_title."' /></a>";
                            break;
                        // More fun Puppies thanks to PlaceDog
                        case 'puppies':
                            echo "<a href='".$all_permalinks[$field->guid]."'><img src='http://placedog.com/".$thumbnail_size[0]."/".$thumbnail_size[1]."' alt='".$field->post_title."' title='".$field->post_title."' /></a>";
                            break;
                        // Boring by default ;)
                        default:
                            echo "<a href='".$all_permalinks[$field->guid]."'><img src='http://placehold.it/".$thumbnail_wh."&text=".$field->post_title."' alt='".$field->post_title."' title='".$field->post_title."' /></a>";
                            break;
                    }
                }
                // Caption Wrapper
                echo $html_tags['caption_o'];
                // Open title box
                echo $html_tags['title_o'];
                // Print the title
                echo "<a href='".$all_permalinks[$field->guid]."'>".$field->post_title."</a>";
                // Close the title box
                echo $html_tags['title_c'];
                if( $full_meta === 'true' ) {
                    // Open meta box
                    echo $html_tags['meta_o'];
                    // Set metainfo
                    $author = get_user_by('id',$field->post_author);
                    $format = get_option('date_format');
                    $datepost = date_i18n($format, strtotime(trim( $field->post_date) ) );
                    $author_url = get_author_posts_url($author->ID);
                    if( $display_comments === 'true' ) {
                        $comments_args = array(
                            'post_id' => $field->ID,
                            'count' => true
                        );
                        $count_comments = "<a href='".get_comments_link( $field->ID )."'><i class='slpicon-comment'></i> ".get_comments( $comments_args )."</a>";
                        // Print metainfo
                        if( !is_rtl() ) {
                            echo $datepost . ' ' . $count_comments;
                        } else {
                            echo $count_comments . ' - ' . $datepost;
                        }
                    } else {
                        // Print metainfo
                        echo $datepost;
                    }
                    // Close meta box
                    echo $html_tags['meta_c'];
                }
                // Print the content
                if( $title_only === 'false' ) {
                    // Open excerpt wrapper
                    echo $html_tags['excerpt_o'];
                    // Custom Excerpt
                    if( $auto_excerpt != 'true' ) {
                        // Print out the excerpt
                        echo slp_custom_excerpt($excerpt_length, $field->post_excerpt, $all_permalinks[$field->guid],$excerpt_trail);
                    // Extract excerpt from content
                    } else {
                        // If post has excerpt then print that
                        if( !empty( $field->post_excerpt ) ) {
                            echo slp_custom_excerpt( $excerpt_length, $field->post_excerpt, $all_permalinks[$field->guid],$excerpt_trail );
                        // Otherwise, create one from content
                        } else {
                            // Get the excerpt
                            echo slp_custom_excerpt($excerpt_length, $field->post_content, $all_permalinks[$field->guid],$excerpt_trail);
                        }
                    }
                    // Close excerpt wrapper
                    echo $html_tags['excerpt_c'];
                }
                if( $full_meta == 'true' && $footer_meta == 'true' ) {
                    /* translators: used between list items, there is a space after the comma */
                    $categories_list = get_the_category_list( __( ', ', 'trans-slp' ) , '', $field->ID);

                    /* translators: used between list items, there is a space after the comma */
                    $tag_list = get_the_tag_list( '', __( ', ', 'trans-slp' ), '', $field->ID );
                    if ( '' != $tag_list ) {
                        $utility_text = __( 'This entry was posted in %1$s and tagged %2$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'trans-slp' );
                    } elseif ( '' != $categories_list ) {
                        $utility_text = __( 'This entry was posted in %1$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'trans-slp' );
                    } else {
                        $utility_text = __( 'This entry was posted by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'trans-slp' );
                    }
                    echo $html_tags['meta_fo'];
                    printf(
                        $utility_text,
                        $categories_list,
                        $tag_list,
                        esc_url( get_permalink() ),
                        the_title_attribute( 'echo=0' ),
                        $author->display_name,
                        esc_url( get_author_posts_url( get_the_author_meta( 'ID', $author->ID ) ) )
                    );
                    echo $html_tags['meta_fc'];
                }
                // Caption Wrapper
                echo $html_tags['caption_c'];
                // Close thumbnail item placeholder
                echo $html_tags['thumbnail_ic'];
                // Close thumbnail container
                echo $html_tags['thumbnail_c'];
            } else {
                // Caption Wrapper
                echo $html_tags['caption_o'];
                // Open title box
                echo $html_tags['title_o'];
                // Print the title
                echo "<a href='".$all_permalinks[$field->guid]."'>".$field->post_title."</a>";
                // Close the title box
                echo $html_tags['title_c'];
                if( $full_meta === 'true' ) {
                    // Open meta box
                    echo $html_tags['meta_o'];
                    // Set metainfo
                    $author = get_user_by('id',$field->post_author);
                    $format = get_option('date_format');
                    $datepost = date_i18n($format, strtotime(trim( $field->post_date) ) );
                    $author_url = get_author_posts_url($author->ID);
                    if( $display_comments === 'true' ) {
                        $comments_args = array(
                            'post_id' => $field->ID,
                            'count' => true
                        );
                        $count_comments = "<a href='".get_comments_link( $field->ID )."'><i class='slpicon-comment'></i> ".get_comments( $comments_args )."</a>";
                        // Print metainfo
                        if( !is_rtl() ) {
                            echo $datepost . ' ' . $count_comments;
                        } else {
                            echo $count_comments . ' - ' . $datepost;
                        }
                    } else {
                        // Print metainfo
                        echo $datepost;
                    }
                    // Close meta box
                    echo $html_tags['meta_c'];
                }
                // Print the content
                if( $title_only === 'false' ) {
                    // Open excerpt wrapper
                    echo $html_tags['excerpt_o'];
                    // Custom Excerpt
                    if( $auto_excerpt != 'true' ) {
                        // Print out the excerpt
                        echo slp_custom_excerpt($excerpt_length, $field->post_excerpt, $all_permalinks[$field->guid],$excerpt_trail);
                    // Extract excerpt from content
                    } else {
                        // If post has excerpt then print that
                        if( !empty( $field->post_excerpt ) ) {
                            echo slp_custom_excerpt( $excerpt_length, $field->post_excerpt, $all_permalinks[$field->guid],$excerpt_trail );
                        // Otherwise, create one from content
                        } else {
                            // Get the excerpt
                            echo slp_custom_excerpt($excerpt_length, $field->post_content, $all_permalinks[$field->guid],$excerpt_trail);
                        }
                    }
                    // Close excerpt wrapper
                    echo $html_tags['excerpt_c'];
                }
                if( $full_meta == 'true' && $footer_meta == 'true' ) {
                    /* translators: used between list items, there is a space after the comma */
                    $categories_list = get_the_category_list( __( ', ', 'trans-slp' ) , '', $field->ID);

                    /* translators: used between list items, there is a space after the comma */
                    $tag_list = get_the_tag_list( '', __( ', ', 'trans-slp' ), '', $field->ID );
                    if ( '' != $tag_list ) {
                        $utility_text = __( 'This entry was posted in %1$s and tagged %2$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'trans-slp' );
                    } elseif ( '' != $categories_list ) {
                        $utility_text = __( 'This entry was posted in %1$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'trans-slp' );
                    } else {
                        $utility_text = __( 'This entry was posted by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'trans-slp' );
                    }
                    echo $html_tags['meta_fo'];
                    printf(
                        $utility_text,
                        $categories_list,
                        $tag_list,
                        esc_url( get_permalink() ),
                        the_title_attribute( 'echo=0' ),
                        $author->display_name,
                        esc_url( get_author_posts_url( get_the_author_meta( 'ID', $author->ID ) ) )
                    );
                    echo $html_tags['meta_fc'];
                }
                // Caption Wrapper
                echo $html_tags['caption_c'];
            }
            // Close item box
            echo $html_tags['item_c'];
        }
        // Close wrapper
        echo $html_tags['wrapper_c'];
        // Close content box
        echo $html_tags['content_c'];
    }
    // Reset post data
    wp_reset_postdata();
}
/** 
 * Shortcode Function
 *
 * @var    array attributes passed to the main function
 * @return string shortcode
 */
function single_latest_posts_shortcode($atts) {
    if( !empty($atts) ) {
        // Legacy mode due to variable renaming
        // So existent shorcodes don't break ;)
        foreach( $atts as $key => $value ) {
            switch( $key ) {
                case 'number':
                    $atts['number_posts'] = $value;
                    break;
                case 'days':
                    $atts['time_frame'] = $value;
                    break;
                case 'titleonly':
                    $atts['title_only'] = $value;
                    break;
                case 'begin_wrap':
                    $atts['before_wrap'] = $value;
                    break;
                case 'end_wrap':
                    $atts['after_wrap'] = $value;
                    break;
                case 'blogid':
                    $atts['blog_id'] = $value;
                    break;
                case 'cat':
                    $atts['category'] = $value;
                    break;
                default:
                    $atts[$key] = $value;
                    break;
            }
        }
        extract($atts);
    }
    // Start the output buffer to control the display position
    ob_start();
    // Get the posts
    single_latest_posts($atts);
    // Output the content
    $shortcode = ob_get_contents();
    // Clean the output buffer
    ob_end_clean();
    // Put the content where we want
    return $shortcode;
}
// Add the shortcode functionality
add_shortcode('slposts','single_latest_posts_shortcode');
/** 
 * Limit excerpt length
 * @count: excerpt length
 * @content: excerpt content
 * @permalink: link to the post
 * return customized @excerpt
 */
function slp_custom_excerpt($count, $content, $permalink, $excerpt_trail){
    if($count == 0 || $count == 'null') { $count = 55; }
    /* Strip shortcodes
     * Due to an incompatibility issue between Visual Composer
     * and WordPress strip_shortcodes hook, I'm stripping
     * shortcodes using regex. (27-09-2012)
     *
     * $content = strip_tags(strip_shortcodes($content));
     *
     * replaced by
     *
     * $content = preg_replace("/\[(.*?)\]/i", '', $content);
     * $content = strip_tags($content);
     */
    $content = preg_replace("/\[(.*?)\]/i", '', $content);
    $content = strip_tags($content);
    // Get the words
    $words = explode(' ', $content, $count + 1);
    // Check if the content exceeds the number of words specified
    if( count($words) > $count ) {
        // Pop off the rest
        array_pop($words);
        // Add ellipsis
        array_push($words, '...');
    } else {
        // Add a blank space
        array_push($words, ' ');
    }
    // Add white spaces
    $content = implode(' ', $words);
    // Add the trail
    switch( $excerpt_trail ) {
        // Text
        case 'text':
            $content = $content.'<a href="'.$permalink.'">'.__('more','trans-slp').'</a>';
            break;
        // Image
        case 'image':
            if( !is_rtl() ) {
                $content = $content.'<a href="'.$permalink.'"><img src="'.plugins_url('core/img/excerpt_trail.png', __FILE__) .'" alt="'.__('more','trans-slp').'" title="'.__('more','trans-slp').'" /></a>';
            } else {
                $content = $content.'<a href="'.$permalink.'"><img src="'.plugins_url('core/img/excerpt_trail-rtl.png', __FILE__) .'" alt="'.__('more','trans-slp').'" title="'.__('more','trans-slp').'" /></a>';
            }
            break;
        // Text by default
        default:
            $content = $content.'<a href="'.$permalink.'">'.__('more','trans-slp').'</a>';
            break;
    }
    // Return the excerpt
    return $content;
}
/**
 * HTML tags
 * Styling purposes
 * @display_type: ulist, olist, block, inline
 * return @html_tags
 */
function slp_display_type($display_type, $instance, $wrapper_list_css, $wrapper_block_css) {
    // Instances
    if( !empty($instance) ) { $slp_instance = "slp-instance-$instance"; }
    // Display Types
    switch($display_type) {
        // Unordered list
        case "ulist":
            $html_tags = array(
                'wrapper_o' => "<ul class='slposts-wrapper slposts-ulist $wrapper_list_css'>",
                'wrapper_c' => "</ul>",
                'wtitle_o' => "<h2 class='slposts-ulist-wtitle'>",
                'wtitle_c' => "</h2>",
                'item_o' => "<li class='slposts-ulist-litem'>",
                'item_c' => "</li>",
                'content_o' => "<div class='slposts-container slposts-ulist-container $slp_instance'>",
                'content_c' => "</div>",
                'meta_o' => "<span class='slposts-ulist-meta'><i class='slpicon-calendar'></i> ",
                'meta_c' => "</span>",
                'meta_fo' => "<span class='slposts-ulist-metafooter'><i class='slpicon-bookmark'></i> ",
                'meta_fc' => "</span>",
                'thumbnail_o' => "<ul class='slposts-ulist-thumbnail slp-thumbnails'>",
                'thumbnail_c' => "</ul>",
                'thumbnail_io' => "<li class='slposts-ulist-thumbnail-litem slp-span3'><div class='thumbnail'>",
                'thumbnail_ic' => "</div></li>",
                'pagination_o' => "<div class='slposts-ulist-pagination slp-pagination'>",
                'pagination_c' => "</div>",
                'title_o' => "<h3 class='slposts-ulist-title'>",
                'title_c' => "</h3>",
                'excerpt_o' => "<ul class='slposts-ulist-excerpt'><li>",
                'excerpt_c' => "</li></ul>",
                'caption_o' => "<div class='slposts-caption'>",
                'caption_c' => "</div>"
            );
            break;
        // Ordered list
        case "olist":
            $html_tags = array(
                'wrapper_o' => "<ol class='slposts-wrapper slposts-olist $wrapper_list_css'>",
                'wrapper_c' => "</ol>",
                'wtitle_o' => "<h2 class='slposts-olist-wtitle'>",
                'wtitle_c' => "</h2>",
                'item_o' => "<li class='slposts-olist-litem'>",
                'item_c' => "</li>",
                'content_o' => "<div class='slposts-container slposts-olist-container $slp_instance'>",
                'content_c' => "</div>",
                'meta_o' => "<span class='slposts-olist-meta'><i class='slpicon-calendar'></i> ",
                'meta_c' => "</span>",
                'meta_fo' => "<span class='slposts-olist-metafooter'><i class='slpicon-bookmark'></i> ",
                'meta_fc' => "</span>",
                'thumbnail_o' => "<ul class='slposts-olist-thumbnail slp-thumbnails'>",
                'thumbnail_c' => "</ul>",
                'thumbnail_io' => "<li class='slposts-olist-thumbnail-litem slp-span3'>",
                'thumbnail_ic' => "</li>",
                'pagination_o' => "<div class='slposts-olist-pagination slp-pagination'>",
                'pagination_c' => "</div>",
                'title_o' => "<h3 class='slposts-olist-title'>",
                'title_c' => "</h3>",
                'excerpt_o' => "<ul class='slposts-olist-excerpt'><li>",
                'excerpt_c' => "</li></ul>",
                'caption_o' => "<div class='slposts-caption'>",
                'caption_c' => "</div>"
            );
            break;
        // Block
        case "block":
            $html_tags = array(
                'wrapper_o' => "<div class='slposts-wrapper slposts-block $wrapper_block_css'>",
                'wrapper_c' => "</div>",
                'wtitle_o' => "<h2 class='slposts-block-wtitle'>",
                'wtitle_c' => "</h2>",
                'item_o' => "<div class='slposts-block-item'>",
                'item_c' => "</div>",
                'content_o' => "<div class='slposts-container slposts-block-container $slp_instance'>",
                'content_c' => "</div>",
                'meta_o' => "<span class='slposts-block-meta'><i class='slpicon-calendar'></i> ",
                'meta_c' => "</span>",
                'meta_fo' => "<span class='slposts-block-metafooter'><i class='slpicon-bookmark'></i> ",
                'meta_fc' => "</span>",
                'thumbnail_o' => "<ul class='slposts-block-thumbnail slp-thumbnails'>",
                'thumbnail_c' => "</ul>",
                'thumbnail_io' => "<li class='slposts-block-thumbnail-litem slp-span3'>",
                'thumbnail_ic' => "</li>",
                'pagination_o' => "<div class='slposts-block-pagination slp-pagination'>",
                'pagination_c' => "</div>",
                'title_o' => "<h3 class='slposts-block-title'>",
                'title_c' => "</h3>",
                'excerpt_o' => "<div class='slposts-block-excerpt'><p>",
                'excerpt_c' => "</p></div>",
                'caption_o' => "<div class='slposts-caption'>",
                'caption_c' => "</div>"
            );
            break;
        default:
            // Unordered list
            $html_tags = array(
                'wrapper_o' => "<ul class='slposts-wrapper slposts-ulist $wrapper_list_css'>",
                'wrapper_c' => "</ul>",
                'wtitle_o' => "<h2 class='slposts-ulist-wtitle'>",
                'wtitle_c' => "</h2>",
                'item_o' => "<li class='slposts-ulist-litem'>",
                'item_c' => "</li>",
                'content_o' => "<div class='slposts-container slposts-ulist-container $slp_instance'>",
                'content_c' => "</div>",
                'meta_o' => "<span class='slposts-ulist-meta'><i class='slpicon-calendar'></i> ",
                'meta_c' => "</span>",
                'meta_fo' => "<span class='slposts-ulist-metafooter'><i class='slpicon-bookmark'></i> ",
                'meta_fc' => "</span>",
                'thumbnail_o' => "<ul class='slposts-ulist-thumbnail slp-thumbnails'>",
                'thumbnail_c' => "</ul>",
                'thumbnail_io' => "<li class='slposts-ulist-thumbnail-litem slp-span3'>",
                'thumbnail_ic' => "</li>",
                'pagination_o' => "<div class='slposts-ulist-pagination slp-pagination'>",
                'pagination_c' => "</div>",
                'title_o' => "<h3 class='slposts-ulist-title'>",
                'title_c' => "</h3>",
                'excerpt_o' => "<ul class='slposts-ulist-excerpt'><li>",
                'excerpt_c' => "</li></ul>",
                'caption_o' => "<div class='slposts-caption'>",
                'caption_c' => "</div>"
            );
            break;
    }
    // Return tags
    return $html_tags;
}
/**
 * Init function
 * Plugin initialization
 */
function single_latest_posts_init() {
    // Check for the required API functions
    if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
        return;
    // Register functions
    wp_register_sidebar_widget('slposts-sb-widget',__("Single Latest Posts",'trans-slp'),"single_latest_posts_widget");
    wp_register_widget_control('slposts-control',__("Single Latest Posts",'trans-slp'),"single_latest_posts_control");
    wp_register_style('slpcss-form', plugins_url('/core/css/form_style.css', __FILE__));
    wp_register_style('slpcss-juiform', plugins_url('/core/js/jquery-ui/css/smoothness/jquery-ui.css', __FILE__));
    wp_register_style( 'slpcss-widget', plugins_url('/core/css/widget_style.css', __FILE__) );
    wp_enqueue_style( 'slpcss-widget' );
    wp_enqueue_style('slpcss-form');
    wp_enqueue_style('slpcss-juiform');
    register_uninstall_hook(__FILE__, 'single_latest_posts_uninstall');
}
/**
 * Load Languages
 */
function slp_load_languages() {
    // Set the textdomain for translation purposes
    load_plugin_textdomain('trans-slp', false, basename( dirname( __FILE__ ) ) . '/languages/');
}
/**
 * Load Scripts
 * Load needed scripts and textdomain
 */
function slp_load_scripts() {
    // Load plugins
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-accordion');
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_script('slpaccordion',plugin_dir_url(__FILE__) .'core/js/slposts-accordion.js');
    return;
}
/**
 * Load jQuery
 */
function slp_load_jquery() {
    wp_enqueue_script('jquery');
    return;
}
/**
 * Load CSS Styles
 * Load front-end stylesheets
 */
function slp_load_styles( $css_style ) {
    if( !empty( $css_style ) ) {
        // Unload default style
        wp_deregister_style( 'slpcss' );
        // Load custom style
        wp_register_style( 'slp-custom' ,$css_style);
        wp_enqueue_style( 'slp-custom' );
    } else {
        // Unload custom style
        wp_deregister_style( 'slp-custom' );
        if( is_rtl() ) {
            // Deregister the LTR style
            wp_deregister_style("slpcss");
            // Register the RTL style
            wp_register_style( "slpcss-rtl", plugins_url("core/css/default_style-rtl.css", __FILE__) );
            // Load the style
            wp_enqueue_style( "slpcss-rtl" );
        } else {
            // Load default style
            wp_register_style( 'slpcss', plugins_url('core/css/default_style.css', __FILE__) );
            wp_enqueue_style( 'slpcss' );
        }
    }
    return;
}
/**
 * Load Widget
 * using create_function to support PHP versions < 5.3
 */
add_action( 'widgets_init', create_function( '', '
    /* Check RTL
     * This function cannot be called from the single_latest_posts_init function
     * due to a loading hierarchy issue, if used there it will not
     * recognize the is_rtl() WordPress function
     */
    if( is_rtl() ) {
        // Tell WordPress this plugin is switching to RTL mode
        global $wp_locale, $wp_styles;
        /* Set the text direction to RTL
         * This two variables will tell load-styles.php
         * load the Dashboard in RTL instead of LTR mode
         */
        $wp_locale->text_direction = "rtl";
        $wp_styles->text_direction = "rtl";
    }
    // Load the class
    return register_widget( "SLposts_Widget" );
' ) );
/**
 * Uninstall function
 * Provides uninstall capabilities
 */
function single_latest_posts_uninstall() {
    // Delete options
    delete_option('widget_slposts_widget');
    // Delete the shortcode hook
    remove_shortcode('slposts');
}
/**
 * TinyMCE Shortcode Plugin
 * Add a slposts button to the TinyMCE editor
 * this will simplify the way it is used
 */
// TinyMCE button settings
function slp_shortcode_button() {
    if ( current_user_can('edit_posts') && current_user_can('edit_pages') ) {
        add_filter('mce_external_plugins', 'slp_shortcode_plugin');
        add_filter('mce_buttons', 'slp_register_button');
    }
}
// Hook the button into the TinyMCE editor
function slp_register_button($buttons) {
    array_push($buttons, "|" , "slposts");
    return $buttons;
}
// Load the TinyMCE slposts shortcode plugin
function slp_shortcode_plugin($plugin_array) {
   $plugin_array['slposts'] = plugin_dir_url(__FILE__) .'core/js/slp_tinymce_button.js';
   return $plugin_array;
}
/**
 * My custom get_posts function extending default capabilities
 *
 * @uses $wpdb
 * @uses WP_Query::query() See for more default arguments and information.
 * @link http://codex.wordpress.org/Template_Tags/get_posts
 *
 * @param array $args Optional. Overrides defaults.
 * @return array List of posts.
 */
function slp_get_posts($args = null, $time_frame) {
    $defaults = array(
      'numberposts' => 10, 'offset' => 0,
      'category' => 0, 'orderby' => 'post_date',
      'order' => 'DESC', 'include' => array(),
      'exclude' => array(), 'meta_key' => '',
      'meta_value' =>'', 'post_type' => 'post',
      'suppress_filters' => false
    );

    $slp_args = wp_parse_args( $args, $defaults );
    if ( empty( $slp_args['post_status'] ) )
      $slp_args['post_status'] = ( 'attachment' == $slp_args['post_type'] ) ? 'inherit' : 'publish';
    if ( ! empty($slp_args['numberposts']) && empty($slp_args['posts_per_page']) )
      $slp_args['posts_per_page'] = $slp_args['numberposts'];
    if ( ! empty($slp_args['category']) )
      $slp_args['cat'] = $slp_args['category'];
    if ( ! empty($slp_args['include']) ) {
      $slp_incposts = wp_parse_id_list( $slp_args['include'] );
      $slp_args['posts_per_page'] = count($slp_incposts);  // only the number of posts included
      $slp_args['post__in'] = $slp_incposts;
    } elseif ( ! empty($slp_args['exclude']) )
      $slp_args['post__not_in'] = wp_parse_id_list( $slp_args['exclude'] );

    $slp_args['ignore_sticky_posts'] = true;
    $slp_args['no_found_rows'] = true;
    if( !empty($time_frame) ) {
        // Nasty hack to access this variable from inside callback filters
        $GLOBALS['slp_time_frame'] = (int)$time_frame;
        function filter_where( $where ) {
            $days = (int)$GLOBALS['slp_time_frame'];
            $where .= " AND post_date >= '".date('Y-m-d', strtotime("-$days days"))."'";
            return $where;
        }
        add_filter( 'posts_where', 'filter_where' );
    }
    $slp_get_posts = new WP_Query;
    $results = $slp_get_posts->query($slp_args);
    if( !empty($time_frame) ) {
        remove_filter( 'posts_where', 'filter_where' );
        // Unset the nasty global
        unset($GLOBALS['slp_time_frame']);
    }
    return $results;
}
// Load styles
add_action('wp_head','slp_load_styles',10,1);
// Run this stuff
add_action("admin_enqueue_scripts","single_latest_posts_init");
// Hook Scripts
add_action('admin_enqueue_scripts', 'slp_load_scripts');
add_action('wp_enqueue_scripts', 'slp_load_jquery');
// Languages
add_action('plugins_loaded', 'slp_load_languages');
// Hook the shortcode button into TinyMCE
add_action('init', 'slp_shortcode_button');
?>