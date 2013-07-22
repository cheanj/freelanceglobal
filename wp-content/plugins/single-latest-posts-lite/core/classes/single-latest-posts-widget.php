<?php
/*
 * Single Latest Posts Lite Widget
 * Version 1.3
 * Author L'Elite
 * Author URI http://laelite.info/
 * License: GNU General Public License 2.0 (GPL) http://www.gnu.org/licenses/gpl.html
 */
/* 
 * Copyright 2007 - 2013 L'Elite de José SAYAGO (opensource@laelite.info)
 * 'SLPosts Lite', 'SLPosts Pro', 'NLPosts' are unregistered trademarks of L'Elite, 
 * and cannot be re-used in conjuction with the GPL v2 usage of this software 
 * under the license terms of the GPL v2 without permission.
 *
 * Single Latest Posts brings all the awesomeness available
 * in Network Latest Posts to individual WordPress installations.
 *
 */
// Load main functionalities
include_once SLPosts_Root . '/single-latest-posts.php';
/* SLposts_Widget Class extending the WP_Widget class
 *
 * This beauty is used to create a multi-instance widget
 * to be used in any widgetized zone of the themes
 */
class SLposts_Widget extends WP_Widget {
    // Default values
    private $defaults = array(
        /*
         * General settings
         */
        'title'            => NULL,          // Section title
        'title_only'       => TRUE,          // Display the post title only
        'instance'         => NULL,          // Instance identifier, used to uniquely differenciate each shortcode or widget used
        'suppress_filters' => FALSE,         // Suppress Query Filters
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
    /*
	 * Register widget with WordPress
	 */
    public function __construct() {
        parent::__construct(
            'slposts_widget', // Base ID
            'Single Latest Posts Lite', // Name
            array( 'description' => __( 'Single Latest Posts Lite Widget', 'trans-slp' ), ) // Args
        );
    }
    /**
     * Front-end display of widget
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments
     * @param array $instance Saved values from database
     */
    public function widget( $args, $instance ) {
        // Duplicate the instances
        $options = $instance;
        // Thumbnail size
        if( empty($options['thumbnail_wh']) ) {
            // Set the thumbnail_wh variable putting together width and height
            $options['thumbnail_wh'] = (int)$options['thumbnail_w'].'x'.(int)$options['thumbnail_h'];
        }
        // If we couldn't find anything, set some default values
        if ( is_array( $options ) ) {
            // Parse & merge parameters with the defaults
            $options = wp_parse_args( $options, $this->defaults );
        }
        // Set the instance identifier, so each instance of the widget is treated individually
        $options['instance'] = $this->number;
        // If there are passed arguments, transform them into variables
        if( !empty($args) ) { extract( $args ); }
        // Display the widget
        // Start the output buffer to control the display position
        ob_start();
        // Get the posts
        single_latest_posts($options);
        // Open the aside tag (widget placeholder)
        $output_string = "<aside class='widget slposts-widget'>";
        // Grab the content
        $output_string .= ob_get_contents();
        // Close the aside tag
        $output_string .= "</aside>";
        // Clean the output buffer
        ob_end_clean();
        // Put the content where we want
        echo $output_string;
    }
    /**
     * Sanitize widget form values as they are saved
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        // Set an array
        $instance = array();
        // Get the values
        $instance['title']            = strip_tags($new_instance['title']);
        $instance['suppress_filters'] = strip_tags($new_instance['suppress_filters']);
        $instance['number_posts']     = intval($new_instance['number_posts']);
        $instance['time_frame']       = intval($new_instance['time_frame']);
        $instance['title_only']       = strip_tags($new_instance['title_only']);
        $instance['display_type']     = strip_tags($new_instance['display_type']);
        $instance['thumbnail']        = strip_tags($new_instance['thumbnail']);
        $instance['thumbnail_w']      = (int)$new_instance['thumbnail_w'];
        $instance['thumbnail_h']      = (int)$new_instance['thumbnail_h'];
        $instance['thumbnail_class']  = strip_tags($new_instance['thumbnail_class']);
        $instance['thumbnail_filler'] = strip_tags($new_instance['thumbnail_filler']);
        $instance['category']         = strip_tags($new_instance['category']);
        $instance['tag']              = strip_tags($new_instance['tag']);
        $instance['paginate']         = strip_tags($new_instance['paginate']);
        $instance['posts_per_page']   = (int)$new_instance['posts_per_page'];
        $instance['excerpt_length']   = (int)$new_instance['excerpt_length'];
        $instance['auto_excerpt']     = strip_tags($new_instance['auto_excerpt']);
        $instance['full_meta']        = strip_tags($new_instance['full_meta']);
        $instance['post_status']      = strip_tags($new_instance['post_status']);
        $instance['excerpt_trail']    = strip_tags($new_instance['excerpt_trail']);
        $instance['css_style']        = strip_tags($new_instance['css_style']);
        $instance['wrapper_list_css'] = strip_tags($new_instance['wrapper_list_css']);
        $instance['wrapper_block_css']= strip_tags($new_instance['wrapper_block_css']);
        // Width by default
        if( $instance['thumbnail_w'] == '0' ) { $instance['thumbnail_w'] = '150'; }
        // Height by default
        if( $instance['thumbnail_h'] == '0' ) { $instance['thumbnail_h'] = '150'; }
        // Return the sanitized values
        return $instance;
    }
    /**
     * Back-end widget form
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        global $wpdb;
        $status_list = $wpdb->get_results("SELECT DISTINCT post_status FROM $wpdb->posts");
        $type_list = $wpdb->get_col("SELECT DISTINCT post_type FROM $wpdb->posts");
        // Parse & Merge the passed values with the default ones
        $instance = wp_parse_args( $instance, $this->defaults );
        // Extract elements as variables
        extract( $instance, EXTR_SKIP );
        // Basic HTML Tags
        $br = "<br />";
        
        // Accordion +
        $widget_form = "<div id='slp-widget'>";
            /* -- General Settings */
            $widget_form.= "<h4><a href='#' class='slp-sec1'>".__('General Settings','trans-slp')."</a></h4>";

            $widget_form.= "<div class='slp-sec1-cnt'>";

                // ---- title
                $widget_form.= "<label for='".$this->get_field_id('title')."'>" . __('Title','trans-slp') . "</label>";
                $widget_form.= $br;
                $widget_form.= "<input type='text' id='".$this->get_field_id('title')."' name='".$this->get_field_name('title')."' value='$title' />";

                // ---- Title Only
                $widget_form.= $br;
                $widget_form.= "<label for='".$this->get_field_id('title_only')."'>" . __('Titles Only','trans-slp') . "</label>";
                $widget_form.= $br;
                $widget_form.= "<select id='".$this->get_field_id('title_only')."' name='".$this->get_field_name('title_only')."'>";
                if( $title_only == 'true' ) {
                    $widget_form.= "<option value='true' selected='selected'>" . __('Yes','trans-slp') . "</option>";
                    $widget_form.= "<option value='false'>" . __('No','trans-slp') . "</option>";
                } else {
                    $widget_form.= "<option value='true'>" . __('Yes','trans-slp') . "</option>";
                    $widget_form.= "<option value='false' selected='selected'>" . __('No','trans-slp') . "</option>";
                }
                $widget_form.= "</select>";
                $widget_form.= $br;

                // ---- Suppress Filters
                $widget_form.= "<label for='".$this->get_field_id('suppress_filters')."'>" . __('Suppress Query Filters','trans-slp') . "</label>";
                $widget_form.= $br;
                $widget_form.= "<select id='".$this->get_field_id('suppress_filters')."' name='".$this->get_field_name('suppress_filters')."'>";
                if( $suppress_filters == 'true' ) {
                    $widget_form.= "<option value='true' selected='selected'>" . __('Yes','trans-slp') . "</option>";
                    $widget_form.= "<option value='false'>" . __('No','trans-slp') . "</option>";
                } else {
                    $widget_form.= "<option value='true'>" . __('Yes','trans-slp') . "</option>";
                    $widget_form.= "<option value='false' selected='selected'>" . __('No','trans-slp') . "</option>";
                }
                $widget_form.= "</select>";
                $widget_form.= $br;

            $widget_form.= "</div>";

            /* -- Posts Settings */
            $widget_form.= "<h4><a href='#' class='slp-sec2'>".__('Posts Settings','trans-slp')."</a></h4>";

            $widget_form.= "<div class='slp-sec2-cnt'>";

                // ---- Number Posts
                $widget_form.= "<label for='".$this->get_field_id('number_posts')."'>" . __('Number of Posts','trans-slp') . "</label>";
                $widget_form.= $br;
                $widget_form.= "<input type='text' size='3' id='".$this->get_field_id('number_posts')."' name='".$this->get_field_name('number_posts')."' value='$number_posts' />";

                // ---- Time Frame
                $widget_form.= $br;
                $widget_form.= "<label for='".$this->get_field_id('time_frame')."'>" . __('Time Frame in Days','trans-slp') . "</label>";
                $widget_form.= $br;
                $widget_form.= "<input type='text' size='3' id='".$this->get_field_id('time_frame')."' name='".$this->get_field_name('time_frame')."' value='$time_frame' />";

                // ---- Post Status
                $widget_form.= $br;
                $widget_form.= "<label for='".$this->get_field_id('post_status')."'>" . __('Post Status','trans-slp') . "</label>";
                $widget_form.= $br;
                $widget_form.= "<select id='".$this->get_field_id('post_status')."' name='".$this->get_field_name('post_status')."'>";
                if( !empty($status_list) ) {
                    foreach( $status_list as $status_slp ) {
                        if( $status_slp->post_status == $post_status ) {
                            $widget_form.= "<option value='$status_slp->post_status' selected='selected'>" . ucwords($status_slp->post_status) . "</option>";
                        } else {
                            $widget_form.= "<option value='$status_slp->post_status'>" . ucwords($status_slp->post_status) . "</option>";
                        }
                    }
                }
                $widget_form.= "</select>";

                // ---- Category
                $widget_form.= $br;
                $widget_form.= "<label for='".$this->get_field_id('category')."'>" . __('Category','trans-slp') . "</label>";
                $widget_form.= $br;
                $widget_form.= "<input type='text' id='".$this->get_field_id('category')."' name='".$this->get_field_name('category')."' value='$category' />";

                // ---- Tag
                $widget_form.= $br;
                $widget_form.= "<label for='".$this->get_field_id('tag')."'>" . __('Tag','trans-slp') . "</label>";
                $widget_form.= $br;
                $widget_form.= "<input type='text' id='".$this->get_field_id('tag')."' name='".$this->get_field_name('tag')."' value='$tag' />";

                // ---- Excerpt Length
                $widget_form.= $br;
                $widget_form.= "<label for='".$this->get_field_id('excerpt_length')."'>" . __('Excerpt Length','trans-slp') . "</label>";
                $widget_form.= $br;
                $widget_form.= "<input type='text' id='".$this->get_field_id('excerpt_length')."' name='".$this->get_field_name('excerpt_length')."' value='$excerpt_length' />";

                // ---- Auto Excerpt
                $widget_form.= $br;
                $widget_form.= "<label for='".$this->get_field_id('auto_excerpt')."'>" . __('Auto-Excerpt','trans-slp') . "</label>";
                $widget_form.= $br;
                $widget_form.= "<select id='".$this->get_field_id('auto_excerpt')."' name='".$this->get_field_name('auto_excerpt')."'>";
                if( $auto_excerpt == 'true' ) {
                    $widget_form.= "<option value='true' selected='selected'>" . __('Yes','trans-slp') . "</option>";
                    $widget_form.= "<option value='false'>" . __('No','trans-slp') . "</option>";
                } else {
                    $widget_form.= "<option value='true'>" . __('Yes','trans-slp') . "</option>";
                    $widget_form.= "<option value='false' selected='selected'>" . __('No','trans-slp') . "</option>";
                }
                $widget_form.= "</select>";

                // ---- Excerpt Trail
                $widget_form.= $br;
                $widget_form.= "<label for='".$this->get_field_id('excerpt_trail')."'>" . __('Excerpt Trail','trans-slp') . "</label>";
                $widget_form.= $br;
                $widget_form.= "<select id='".$this->get_field_id('excerpt_trail')."' name='".$this->get_field_name('excerpt_trail')."'>";
                if( $excerpt_trail == 'text' || empty($excerpt_trail) ) {
                    $widget_form.= "<option value='text' selected='selected'>" . __('Text','trans-slp') . "</option>";
                    $widget_form.= "<option value='image'>" . __('Image','trans-slp') . "</option>";
                } else {
                    $widget_form.= "<option value='text'>" . __('Text','trans-slp') . "</option>";
                    $widget_form.= "<option value='image' selected='selected'>" . __('Image','trans-slp') . "</option>";
                }
                $widget_form.= "</select>";

                // ---- Full Meta
                $widget_form.= $br;
                $widget_form.= "<label for='".$this->get_field_id('full_meta')."'>" . __('Full Metadata','trans-slp') . "</label>";
                $widget_form.= $br;
                $widget_form.= "<select id='".$this->get_field_id('full_meta')."' name='".$this->get_field_name('full_meta')."'>";
                if( $full_meta == 'true' ) {
                    $widget_form.= "<option value='true' selected='selected'>" . __('Yes','trans-slp') . "</option>";
                    $widget_form.= "<option value='false'>" . __('No','trans-slp') . "</option>";
                } else {
                    $widget_form.= "<option value='true'>" . __('Yes','trans-slp') . "</option>";
                    $widget_form.= "<option value='false' selected='selected'>" . __('No','trans-slp') . "</option>";
                }
                $widget_form.= "</select>";
                $widget_form.= $br;

            $widget_form.= "</div>";

            /* -- Pagination & Sorting */
            $widget_form.= "<h4><a href='#' class='slp-sec3'>".__('Pagination & Sorting','trans-slp')."</a></h4>";

            $widget_form.= "<div class='slp-sec3-cnt'>";

                // ---- Paginate
                $widget_form.= "<label for='".$this->get_field_id('paginate')."'>" . __('Paginate Results','trans-slp') . "</label>";
                $widget_form.= $br;
                $widget_form.= "<select id='".$this->get_field_id('paginate')."' name='".$this->get_field_name('paginate')."'>";
                if( $paginate == 'true' ) {
                    $widget_form.= "<option value='true' selected='selected'>" . __('Yes','trans-slp') . "</option>";
                    $widget_form.= "<option value='false'>" . __('No','trans-slp') . "</option>";
                } else {
                    $widget_form.= "<option value='true'>" . __('Yes','trans-slp') . "</option>";
                    $widget_form.= "<option value='false' selected='selected'>" . __('No','trans-slp') . "</option>";
                }
                $widget_form.= "</select>";

                // ---- Posts per Page
                $widget_form.= $br;
                $widget_form.= "<label for='".$this->get_field_id('posts_per_page')."'>" . __('Posts per Page','trans-slp') . "</label>";
                $widget_form.= $br;
                $widget_form.= "<input type='text' id='".$this->get_field_id('posts_per_page')."' name='".$this->get_field_name('posts_per_page')."' value='$posts_per_page' />";

            $widget_form.= "</div>";

            /* -- Thumbnails Settings */
            $widget_form.= "<h4><a href='#' class='slp-sec4'>".__('Thumbnails','trans-slp')."</a></h4>";

            $widget_form.= "<div class='slp-sec4-cnt'>";

                // ---- Thumbnails
                $widget_form.= "<label for='".$this->get_field_id('thumbnail')."'>" . __('Display Thumbnails','trans-slp') . "</label>";
                $widget_form.= $br;
                $widget_form.= "<select id='".$this->get_field_id('thumbnail')."' name='".$this->get_field_name('thumbnail')."'>";
                if( $thumbnail == 'true' ) {
                    $widget_form.= "<option value='true' selected='selected'>" . __('Show','trans-slp') . "</option>";
                    $widget_form.= "<option value='false'>" . __('Hide','trans-slp') . "</option>";
                } else {
                    $widget_form.= "<option value='true'>" . __('Show','trans-slp') . "</option>";
                    $widget_form.= "<option value='false' selected='selected'>" . __('Hide','trans-slp') . "</option>";
                }
                $widget_form.= "</select>";

                // ---- Thumbnail Size
                $widget_form.= $br;
                $widget_form.= "<fieldset>";
                $widget_form.= "<legend>" . __('Thumbnail Size','trans-slp') . "</legend>";
                $widget_form.= "<label for='".$this->get_field_id('thumbnail_w')."'>" . __('Width','trans-slp') . "</label>";
                $widget_form.= $br;
                $widget_form.= "<input type='text' size='3' id='".$this->get_field_id('thumbnail_w')."' name='".$this->get_field_name('thumbnail_w')."' value='$thumbnail_w' />";
                $widget_form.= $br;
                $widget_form.= "<label for='".$this->get_field_id('thumbnail_h')."'>" . __('Height','trans-slp') . "</label>";
                $widget_form.= $br;
                $widget_form.= "<input type='text' size='3' id='".$this->get_field_id('thumbnail_h')."' name='".$this->get_field_name('thumbnail_h')."' value='$thumbnail_h' />";
                $widget_form.= "</fieldset>";

                // ---- Thumbnail Filler
                $widget_form.= "<label for='".$this->get_field_id('thumbnail_filler')."'>" . __('Thumbnail Replacement','trans-slp') . '</label>';
                $widget_form.= $br;
                $widget_form.= "<select id='".$this->get_field_id('thumbnail_filler')."' name='".$this->get_field_name('thumbnail_filler')."'>";
                switch( $thumbnail_filler ) {
                    case 'placeholder':
                        $widget_form.= "<option value='placeholder' selected='selected'>" . __('Placeholder','trans-slp') . "</option>";
                        $widget_form.= "<option value='kittens'>" . __('Kittens','trans-slp') . "</option>";
                        $widget_form.= "<option value='puppies'>" . __('Puppies','trans-slp') . "</option>";
                        break;
                    case 'kittens':
                        $widget_form.= "<option value='placeholder'>" . __('Placeholder','trans-slp') . "</option>";
                        $widget_form.= "<option value='kittens' selected='selected'>" . __('Kittens','trans-slp') . "</option>";
                        $widget_form.= "<option value='puppies'>" . __('Puppies','trans-slp') . "</option>";
                        break;
                    case 'puppies':
                        $widget_form.= "<option value='placeholder'>" . __('Placeholder','trans-slp') . "</option>";
                        $widget_form.= "<option value='kittens'>" . __('Kittens','trans-slp') . "</option>";
                        $widget_form.= "<option value='puppies' selected='selected'>" . __('Puppies','trans-slp') . "</option>";
                        break;
                    default:
                        $widget_form.= "<option value='placeholder' selected='selected'>" . __('Placeholder','trans-slp') . "</option>";
                        $widget_form.= "<option value='kittens'>" . __('Kittens','trans-slp') . "</option>";
                        $widget_form.= "<option value='puppies'>" . __('Puppies','trans-slp') . "</option>";
                        break;
                }
                $widget_form.= "</select>";

                // ---- Thumbnail Class
                $widget_form.= $br;
                $widget_form.= "<label for='".$this->get_field_id('thumbnail_class')."'>" . __('Thumbnail Class','trans-slp') . "</label>";
                $widget_form.= $br;
                $widget_form.= "<input type='text' id='".$this->get_field_id('thumbnail_class')."' name='".$this->get_field_name('thumbnail_class')."' value='$thumbnail_class' />";
                $widget_form.= $br;

            $widget_form.= "</div>";

            /* -- Display Settings */
            $widget_form.= "<h4><a href='#' class='slp-sec5'>".__('Style Settings','trans-slp')."</a></h4>";

            $widget_form.= "<div class='slp-sec5-cnt'>";

                // ---- Display Type
                $widget_form.= "<label for='".$this->get_field_id('display_type')."'>" . __('Display Type','trans-slp') . '</label>';
                $widget_form.= $br;
                $widget_form.= "<select id='".$this->get_field_id('display_type')."' name='".$this->get_field_name('display_type')."'>";
                switch( $display_type ) {
                    // Unordered list
                    case 'ulist':
                        $widget_form.= "<option value='ulist' selected='selected'>" . __('Unordered List','trans-slp') . "</option>";
                        $widget_form.= "<option value='olist'>" . __('Ordered List','trans-slp') . "</option>";
                        $widget_form.= "<option value='block'>" . __('Blocks','trans-slp') . "</option>";
                        break;
                    // Ordered list
                    case 'olist':
                        $widget_form.= "<option value='ulist'>" . __('Unordered List','trans-slp') . "</option>";
                        $widget_form.= "<option value='olist' selected='selected'>" . __('Ordered List','trans-slp') . "</option>";
                        $widget_form.= "<option value='block'>" . __('Blocks','trans-slp') . "</option>";
                        break;
                    // Block
                    case 'block':
                        $widget_form.= "<option value='ulist'>" . __('Unordered List','trans-slp') . "</option>";
                        $widget_form.= "<option value='olist'>" . __('Ordered List','trans-slp') . "</option>";
                        $widget_form.= "<option value='block' selected='selected'>" . __('Blocks','trans-slp') . "</option>";
                        break;
                    // Unordered list by default
                    default:
                        $widget_form.= "<option value='ulist' selected='selected'>" . __('Unordered List','trans-slp') . "</option>";
                        $widget_form.= "<option value='olist'>" . __('Ordered List','trans-slp') . "</option>";
                        $widget_form.= "<option value='block'>" . __('Blocks','trans-slp') . "</option>";
                        break;
                }
                $widget_form.= "</select>";

                // ---- CSS Style
                $widget_form.= $br;
                $widget_form.= "<label for='".$this->get_field_id('css_style')."'>" . __('Custom CSS Filename','trans-slp') . "</label>";
                $widget_form.= $br;
                $widget_form.= "<input type='text' id='".$this->get_field_id('css_style')."' name='".$this->get_field_name('css_style')."' value='$css_style' />";

                // ---- CSS Wrapper List
                $widget_form.= $br;
                $widget_form.= "<label for='".$this->get_field_id('wrapper_list_css')."'>" . __('Custom CSS Class for the list wrapper','trans-slp') . "</label>";
                $widget_form.= $br;
                $widget_form.= "<input type='text' id='".$this->get_field_id('wrapper_list_css')."' name='".$this->get_field_name('wrapper_list_css')."' value='$wrapper_list_css' />";

                // ---- CSS Wrapper Block
                $widget_form.= $br;
                $widget_form.= "<label for='".$this->get_field_id('wrapper_block_css')."'>" . __('Custom CSS Class for the block wrapper','trans-slp') . "</label>";
                $widget_form.= $br;
                $widget_form.= "<input type='text' id='".$this->get_field_id('wrapper_block_css')."' name='".$this->get_field_name('wrapper_block_css')."' value='$wrapper_block_css' />";

            $widget_form.= "</div>";

        $widget_form.= "</div>";
        // Accordion -
        echo $widget_form;
    }
}
?>