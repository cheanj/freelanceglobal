<?php
/*
 * Single Latest Posts Lite Shortcode Form
 * Version 1.3
 * Author L'Elite
 * Author URI http://laelite.info/
 * License: GNU General Public License 2.0 (GPL) http://www.gnu.org/licenses/gpl.html
 */
/* 
 * Copyright 2007 - 2012 L'Elite de José SAYAGO (opensource@laelite.info)
 * 'SLPosts Lite', 'SLPosts Pro', 'NLPosts' are unregistered trademarks of L'Elite, 
 * and cannot be re-used in conjuction with the GPL v2 usage of this software 
 * under the license terms of the GPL v2 without permission.
 *
 * Single Latest Posts brings all the awesomeness available
 * in Network Latest Posts to individual WordPress installations.
 *
 */
// Retrieve the WordPress root path
function slp_config_path()
{
    $base = dirname(__FILE__);
    $path = false;
    // Check multiple levels, until find the config file
    if (@file_exists(dirname(dirname($base))."/wp-config.php")){
        $path = dirname(dirname($base));
    } elseif (@file_exists(dirname(dirname(dirname($base)))."/wp-config.php")) {
        $path = dirname(dirname(dirname($base)));
    } elseif (@file_exists(dirname(dirname(dirname(dirname($base))))."/wp-config.php")) {
        $path = dirname(dirname(dirname(dirname($base))));
    } elseif (@file_exists(dirname(dirname(dirname(dirname(dirname($base)))))."/wp-config.php")) {
        $path = dirname(dirname(dirname(dirname(dirname($base)))));
    } elseif (@file_exists(dirname(dirname(dirname(dirname(dirname(dirname($base))))))."/wp-config.php")) {
        $path = dirname(dirname(dirname(dirname(dirname(dirname($base))))));
    } else {
        $path = false;
    }
    // Get the path
    if ($path != false){
        $path = str_replace("\\", "/", $path);
    }
    // Return the path
    return $path;
}
$thumbnail_w = 150;
$thumbnail_h = 150;
$wp_root_path = slp_config_path();
// Load WordPress functions & slposts_Widget class
require_once("$wp_root_path/wp-load.php");
require_once("../classes/single-latest-posts-widget.php");
// Widget object
$widget_obj = new SLposts_Widget();
// Default values
$defaults = array(
    'title'            => NULL,          // Widget title
    'suppress_filters' => FALSE,         // Suppress Query Filters
    'number_posts'     => 10,            // Number of posts to be displayed
    'time_frame'       => 0,             // Time frame to look for posts in days
    'title_only'       => TRUE,          // Display the post title only
    'display_type'     => 'ulist',       // Display content as a: olist (ordered), ulist (unordered), block
    'thumbnail'        => FALSE,         // Display the thumbnail
    'thumbnail_wh'     => '150x150',     // Thumbnail Width & Height in pixels
    'thumbnail_class'  => NULL,          // Thumbnail CSS class
    'thumbnail_filler' => 'placeholder', // Replacement image for posts without thumbnail (placeholder, kittens, puppies)
    'category'         => NULL,          // Category to display
    'tag'              => NULL,          // Tag to display
    'paginate'         => FALSE,         // Paginate results
    'posts_per_page'   => NULL,          // Number of posts per page (paginate needs to be active)
    'excerpt_length'   => NULL,          // Excerpt's length
    'auto_excerpt'     => FALSE,         // Generate excerpt from content
    'excerpt_trail'    => 'text',        // Excerpt's trailing element: text, image
    'full_meta'        => FALSE,         // Display full metadata
    'display_comments' => FALSE,         // Display comments (true or false)
    'post_status'      => 'publish',     // Post status (publish, new, pending, draft, auto-draft, future, private, inherit, trash)
    'css_style'        => NULL,          // Custom CSS _filename_ (ex: custom_style)
    'wrapper_list_css' => 'nav nav-tabs nav-stacked', // Custom CSS classes for the list wrapper
    'wrapper_block_css'=> 'content',     // Custom CSS classes for the block wrapper
    'instance'         => NULL,          // Instance identifier, used to uniquely differenciate each shortcode used
);
// Set an array
$settings = array();
// Parse & merge the settings with the default values
$settings = wp_parse_args( $settings, $defaults );
// Extract elements as variables
extract( $settings );
global $wpdb;
$status_list = $wpdb->get_results("SELECT DISTINCT post_status FROM $wpdb->posts");
$type_list = $wpdb->get_col("SELECT DISTINCT post_type FROM $wpdb->posts");
// Basic HTML Tags
$br = "<br />";
$p_o = "<p>";
$p_c = "<p>";
$widget_form = "<form id='slposts_shortcode' name='slposts_shortcode' method='POST' action=''>";

$widget_form.= "<h2>".__('Single Latest Posts Shortcode Settings','trans-slp')."</h2>";
$widget_form.= "<hr />";

$widget_form.= "<div id='slptabs'>";
$widget_form.= '<ul>';
    $widget_form.= '<li><a href="#tab1" class="tab1">'.__('General Settings','trans-slp').'</a></li>';
    $widget_form.= '<li><a href="#tab2" class="tab2">'.__('Posts','trans-slp').'</a></li>';
    $widget_form.= '<li><a href="#tab3" class="tab3">'.__('Pagination','trans-slp').'</a></li>';
    $widget_form.= '<li><a href="#tab4" class="tab4">'.__('Thumbnails','trans-slp').'</a></li>';
    $widget_form.= '<li><a href="#tab5" class="tab5">'.__('Style Settings','trans-slp').'</a></li>';
$widget_form.= '</ul>';

$widget_form.= "<hr />";
$widget_form.= $br;

// General Settings
$widget_form.= "<div id='tab1'>";
    // title
    $widget_form.= "<label for='title'>" . __('Title','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<input type='text' id='title' name='title' value='$title' />";
    $widget_form.= $br;

    // title_only
    $widget_form.= "<label for='title_only'>" . __('Titles Only','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<select id='title_only' name='title_only'>";
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
    $widget_form.= "<label for='suppress_filters'>" . __('Suppress Query Filters','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<select id='suppress_filters' name='suppress_filters'>";
    if( $suppress_filters == 'true' ) {
        $widget_form.= "<option value='true' selected='selected'>" . __('Yes','trans-slp') . "</option>";
        $widget_form.= "<option value='false'>" . __('No','trans-slp') . "</option>";
    } else {
        $widget_form.= "<option value='true'>" . __('Yes','trans-slp') . "</option>";
        $widget_form.= "<option value='false' selected='selected'>" . __('No','trans-slp') . "</option>";
    }
    $widget_form.= "</select>";
    $widget_form.= $br;

    // Instance
    $widget_form.= "<label for='instance'>" . __('Instance Identifier','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<input type='text' id='instance' name='instance' value='$instance' />";

    $widget_form.= $br;
    $widget_form.= "<input type='button' class='slposts_shortcode_submit' value='".__('Insert Shortcode','trans-slp')."' />";

$widget_form.= "</div>";

// Posts Settings
$widget_form.= "<div id='tab2'>";

    // number_posts
    $widget_form.= "<label for='number_posts'>" . __('Number of Posts','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<input type='text' size='3' id='number_posts' name='number_posts' value='$number_posts' />";
    $widget_form.= $br;

    // time_frame
    $widget_form.= "<label for='time_frame'>" . __('Time Frame in Days','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<input type='text' size='3' id='time_frame' name='time_frame' value='$time_frame' />";
    $widget_form.= $br;

    // post_status
    $widget_form.= $br;
    $widget_form.= "<label for='post_status'>" . __('Post Status','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<select id='post_status' name='post_status'>";
    if( !empty($status_list) ) {
        foreach( $status_list as $status_slp ) {
            $widget_form.= "<option value='$status_slp->post_status'>" . ucwords($status_slp->post_status) . "</option>";
        }
    }
    $widget_form.= "</select>";

    // category
    $widget_form.= $br;
    $widget_form.= "<label for='category'>" . __('Category','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<input type='text' id='category' name='category' value='$category' />";

    // tag
    $widget_form.= $br;
    $widget_form.= "<label for='tag'>" . __('Tag','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<input type='text' id='tag' name='tag' value='$tag' />";

    // excerpt_length
    $widget_form.= $br;
    $widget_form.= "<label for='excerpt_length'>" . __('Excerpt Length','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<input type='text' id='excerpt_length' name='excerpt_length' value='$excerpt_length' />";

    // auto_excerpt
    $widget_form.= $br;
    $widget_form.= "<label for='auto_excerpt'>" . __('Auto-Excerpt','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<select id='auto_excerpt' name='auto_excerpt'>";
    if( $auto_excerpt == 'true' ) {
        $widget_form.= "<option value='true' selected='selected'>" . __('Yes','trans-slp') . "</option>";
        $widget_form.= "<option value='false'>" . __('No','trans-slp') . "</option>";
    } else {
        $widget_form.= "<option value='true'>" . __('Yes','trans-slp') . "</option>";
        $widget_form.= "<option value='false' selected='selected'>" . __('No','trans-slp') . "</option>";
    }
    $widget_form.= "</select>";

    // excerpt_trail
    $widget_form.= $br;
    $widget_form.= "<label for='excerpt_trail'>" . __('Excerpt Trail','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<select id='excerpt_trail' name='excerpt_trail'>";
    if( $excerpt_trail == 'text' || empty($excerpt_trail) ) {
        $widget_form.= "<option value='text' selected='selected'>" . __('Text','trans-slp') . "</option>";
        $widget_form.= "<option value='image'>" . __('Image','trans-slp') . "</option>";
    } else {
        $widget_form.= "<option value='text'>" . __('Text','trans-slp') . "</option>";
        $widget_form.= "<option value='image' selected='selected'>" . __('Image','trans-slp') . "</option>";
    }
    $widget_form.= "</select>";

    // full_meta
    $widget_form.= $br;
    $widget_form.= "<label for='full_meta'>" . __('Full Metadata','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<select id='full_meta' name='full_meta'>";
    if( $full_meta == 'true' ) {
        $widget_form.= "<option value='true' selected='selected'>" . __('Yes','trans-slp') . "</option>";
        $widget_form.= "<option value='false'>" . __('No','trans-slp') . "</option>";
    } else {
        $widget_form.= "<option value='true'>" . __('Yes','trans-slp') . "</option>";
        $widget_form.= "<option value='false' selected='selected'>" . __('No','trans-slp') . "</option>";
    }
    $widget_form.= "</select>";

    // display_comments
    $widget_form.= $br;
    $widget_form.= "<label for='display_comments'>" . __('Display Comments','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<select id='display_comments' name='display_comments'>";
    if( $display_comments == 'true' ) {
        $widget_form.= "<option value='true' selected='selected'>" . __('Yes','trans-slp') . "</option>";
        $widget_form.= "<option value='false'>" . __('No','trans-slp') . "</option>";
    } else {
        $widget_form.= "<option value='true'>" . __('Yes','trans-slp') . "</option>";
        $widget_form.= "<option value='false' selected='selected'>" . __('No','trans-slp') . "</option>";
    }
    $widget_form.= "</select>";

    $widget_form.= $br;
    $widget_form.= "<input type='button' class='slposts_shortcode_submit' value='".__('Insert Shortcode','trans-slp')."' />";

$widget_form.= "</div>";

// Pagination & Sorting Settings
$widget_form.= "<div id='tab3'>";

    // paginate
    $widget_form.= $br;
    $widget_form.= "<label for='paginate'>" . __('Paginate Results','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<select id='paginate' name='paginate'>";
    if( $paginate == 'true' ) {
        $widget_form.= "<option value='true' selected='selected'>" . __('Yes','trans-slp') . "</option>";
        $widget_form.= "<option value='false'>" . __('No','trans-slp') . "</option>";
    } else {
        $widget_form.= "<option value='true'>" . __('Yes','trans-slp') . "</option>";
        $widget_form.= "<option value='false' selected='selected'>" . __('No','trans-slp') . "</option>";
    }
    $widget_form.= "</select>";

    // posts_per_page
    $widget_form.= $br;
    $widget_form.= "<label for='posts_per_page'>" . __('Posts per Page','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<input type='text' id='posts_per_page' name='posts_per_page' value='$posts_per_page' />";

    $widget_form.= $br;
    $widget_form.= "<input type='button' class='slposts_shortcode_submit' value='".__('Insert Shortcode','trans-slp')."' />";

$widget_form.= "</div>";

// Thumbnails Settings
$widget_form.= "<div id='tab4'>";


    // thumbnail
    $widget_form.= $br;
    $widget_form.= "<label for='thumbnail'>" . __('Display Thumbnails','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<select id='thumbnail' name='thumbnail'>";
    if( $thumbnail == 'true' ) {
        $widget_form.= "<option value='true' selected='selected'>" . __('Show','trans-slp') . "</option>";
        $widget_form.= "<option value='false'>" . __('Hide','trans-slp') . "</option>";
    } else {
        $widget_form.= "<option value='true'>" . __('Show','trans-slp') . "</option>";
        $widget_form.= "<option value='false' selected='selected'>" . __('Hide','trans-slp') . "</option>";
    }
    $widget_form.= "</select>";
    $widget_form.= $br;

    // Thumbnail Size
    $widget_form.= "<fieldset>";
    $widget_form.= "<legend>" . __('Thumbnail Size','trans-slp') . "</legend>";
    $widget_form.= "<label for='thumbnail_w'>" . __('Width','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<input type='text' size='3' id='thumbnail_w' name='thumbnail_w' value='$thumbnail_w' />";
    $widget_form.= $br;
    $widget_form.= "<label for='thumbnail_h'>" . __('Height','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<input type='text' size='3' id='thumbnail_h' name='thumbnail_h' value='$thumbnail_h' />";
    $widget_form.= "</fieldset>";

    // thumbnail_filler
    $widget_form.= "<label for='thumbnail_filler'>" . __('Thumbnail Replacement','trans-slp') . '</label>';
    $widget_form.= $br;
    $widget_form.= "<select id='thumbnail_filler' name='thumbnail_filler'>";
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

    // thumbnail_class
    $widget_form.= $br;
    $widget_form.= "<label for='thumbnail_class'>" . __('Thumbnail Class','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<input type='text' id='thumbnail_class' name='thumbnail_class' value='$thumbnail_class' />";

    $widget_form.= $br;
    $widget_form.= "<input type='button' class='slposts_shortcode_submit' value='".__('Insert Shortcode','trans-slp')."' />";

$widget_form.= "</div>";

// Display Settings
$widget_form.= "<div id='tab5'>";

    // display_type
    $widget_form.= "<label for='display_type'>" . __('Display Type','trans-slp') . '</label>';
    $widget_form.= $br;
    $widget_form.= "<select id='display_type' name='display_type'>";
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

    // css_style
    $widget_form.= $br;
    $widget_form.= "<label for='css_style'>" . __('Custom CSS Filename','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<input type='text' id='css_style' name='css_style' value='$css_style' />";

    // wrapper_list_css
    $widget_form.= $br;
    $widget_form.= "<label for='wrapper_list_css'>" . __('Custom CSS Class for the list wrapper','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<input type='text' id='wrapper_list_css' name='wrapper_list_css' value='$wrapper_list_css' />";

    // wrapper_block_css
    $widget_form.= $br;
    $widget_form.= "<label for='wrapper_block_css'>" . __('Custom CSS Class for the block wrapper','trans-slp') . "</label>";
    $widget_form.= $br;
    $widget_form.= "<input type='text' id='wrapper_block_css' name='wrapper_block_css' value='$wrapper_block_css' />";

    $widget_form.= $br;
    $widget_form.= "<input type='button' class='slposts_shortcode_submit' value='".__('Insert Shortcode','trans-slp')."' />";

$widget_form.= "</div>";

$widget_form.= "</form>";

echo $widget_form;
?>
<script type="text/javascript" charset="utf-8">
    //<![CDATA[
    jQuery('#slposts_shortcode').ready(function(){
        jQuery('#slposts_shortcode label').each(function(){
            jQuery(this).prepend('<i class="slpicon-leaf"></i> ');
        });
        jQuery('#slptabs').tabs();
    });
    jQuery('.slposts_shortcode_submit').click(function(){
        // Count words
        function slp_countWords(s) {
            return s.split(/[ \t\r\n]/).length;
        }
        // Get the form fields
        var values = {};
        jQuery('#TB_ajaxContent form :input').each(function(index,field) {
            if( field.id != undefined && field.id != '' ) {
                name = '#TB_ajaxContent form #'+field.id;
                values[jQuery(name).attr('id')] = jQuery(name).val();
            }
        });
        // Default values
        var defaults = new Array();
        defaults['title'] = null;
        defaults['suppress_filters'] = 'false';
        defaults['number_posts'] = '10';
        defaults['time_frame'] = '0';
        defaults['title_only'] = 'true';
        defaults['display_type'] = 'ulist';
        defaults['thumbnail'] = 'false';
        defaults['thumbnail_wh'] = '150x150';
        defaults['thumbnail_class'] = null;
        defaults['thumbnail_filler'] = 'placeholder';
        defaults['category'] = null;
        defaults['tag'] = null;
        defaults['paginate'] = 'false';
        defaults['posts_per_page'] = null;
        defaults['excerpt_length'] = null;
        defaults['auto_excerpt'] = 'false';
        defaults['full_meta'] = 'false';
        defaults['display_comments'] = 'false';
        defaults['post_status'] = 'publish';
        defaults['excerpt_trail'] = 'text';
        defaults['css_style'] = null;
        defaults['wrapper_list_css'] = 'nav nav-tabs nav-stacked';
        defaults['wrapper_block_css'] = 'content';
        defaults['instance'] = null;
        // Set the thumbnail size
        if( values.thumbnail_w && values.thumbnail_h ) {
            var thumbnail_wh = values.thumbnail_w+'x'+values.thumbnail_h;
            values['thumbnail_wh'] = thumbnail_wh;
            values['thumbnail_w'] = 'null';
            values['thumbnail_h'] = 'null';
        }
        // Clear the submit button so the shortcode doesn't take its value
        values['slposts_shortcode_submit'] = null;
        // Build the shortcode
        var slp_shortcode = '[slposts';
        // Get the settings and values
        for( settings in values ) {
            // If they're not empty or null
            if( values[settings] && values[settings] != 'null') {
                // And they're not the default values
                if( values[settings] != defaults[settings] ) {
                    // Count words
                    if( slp_countWords(String(values[settings])) > 1 ) {
                        // If more than 1 or a big single string, add quotes to the key=value
                        slp_shortcode += ' '+settings +'="'+ values[settings]+'"';
                    } else {
                        // Otherwise, add the key=value
                        slp_shortcode += ' '+settings +'='+ values[settings];
                    }
                }
            }
        }
        // Close the shortcode
        slp_shortcode += ']';
        // insert the shortcode into the active editor
        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, slp_shortcode);
        // close Thickbox
        tb_remove();
    });
    //]]>
</script>