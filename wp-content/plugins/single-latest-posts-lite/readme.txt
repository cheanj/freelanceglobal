=== Single Latest Posts Lite ===
Contributors: L'Elite
Donate link: http://laelite.info
Tags: recent posts, shortcode, widget, latest posts, single installation
Requires at least: 3.0
Tested up to: 3.5.1
Stable tag: 1.3

This plugin allows you to pull all the recent posts from your WordPress blog and display them the way you want

== Description ==

Display recent posts by category or tag (multiples in the premium version), thumbnails, titles only or excerpts (automatic excerpts available), pagination and more.

== Installation ==

1. Upload `slposts-lite folder` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. If you want to use the Widget, you can add the Single Latest Posts widget under 'Appearance->Widgets'
4. If you want to use the Shortcode, go to a page or post then click the SLPosts icon (red button in the TinyMCE editor) or use [slposts] (that's it, seriously!)

= Shortcode Options =

This is an just an example with the default values which means I could have used `[slposts]` instead, but this will show you how the parameters
are passed. For more examples please visit the Network Latest Post website.

`[slposts title=NULL
          suppress_filters=FALSE
          number_posts=10
          time_frame=0
          title_only=TRUE
          display_type=ulist
          thumbnail=FALSE
          thumbnail_wh=80x80
          thumbnail_class=NULL
          thumbnail_filler=placeholder
          category=NULL
          tag=NULL
          paginate=FALSE
          posts_per_page=NULL
          excerpt_length=NULL
          auto_excerpt=FALSE
          excerpt_trail=text
          full_meta=FALSE
          display_comments=FALSE
          post_status=publish
          css_style=NULL
          wrapper_list_css='nav nav-tabs nav-stacked'
          wrapper_block_css=content
          instance=NULL
]`

* @title              : Widget/Shortcode main title (section title)
* @number_posts       : Number of posts BY blog to retrieve. Ex: 10 means, retrieve 10 posts for each blog found in the network
* @time_frame         : Period of time to retrieve the posts from in days. Ex: 5 means, find all articles posted in the last 5 days
* @title_only         : Display post titles only, if false then excerpts will be shown
* @display_type       : How to display the articles, as an: unordered list (ulist), ordered list (olist) or block elements
* @thumbnail          : If true then thumbnails will be shown, if active and not found then a placeholder will be used instead
* @thumbnail_wh       : Thumbnails size, width and height in pixels, while using the shortcode or a function this parameter must be passed like: '80x80'
* @thumbnail_class    : Thumbnail class, set a custom class (alignleft, alignright, center, etc)
* @thumbnail_filler   : Placeholder to use if the post's thumbnail couldn't be found, options: placeholder, kittens, puppies (what?.. I can be funny sometimes)
* @category           : Category you want to display. Ex: cats means, retrieve posts published under the category cats
* @tag                : Same as categoy WordPress treats both taxonomies the same way
* @paginate           : Display results by pages, if used then the parameter posts_per_page must be specified, otherwise pagination won't be displayed
* @posts_per_page     : Set the number of posts to display by page (paginate must be activated)
* @excerpt_length     : Set the excerpt's length in case you think it's too long for your needs Ex: 40 means, 40 words (55 by default)
* @auto_excerpt       : If true then it will generate an excerpt from the post content, it's useful for those who forget to use the Excerpt field in the post edition page
* @excerpt_trail      : Set the type of trail you want to append to the excerpts: text, image. The text will be _more_, the image is inside the plugin's img directory and it's called excerpt_trail.png
* @full_meta          : Display the date and the author of the post, for the date/time each blog time format will be used
* @display_comments   : Display comments count, full_meta must be active in order for this parameter to work (true to activate, false by default)
* @post_status        : Specify the status of the posts you want to display: publish, new, pending, draft, auto-draft, future, private, inherit, trash
* @css_style          : Use a custom CSS style instead of the one included by default, useful if you want to customize the front-end display: filename (without extension), this file must be located where your active theme CSS style is located, this parameter should be used only once by page (it will affect all shorcodes/widgets included in that page)
* @wrapper_list_css   : Custom CSS classes for the list wrapper
* @wrapper_block_css  : Custom CSS classes for the block wrapper
* @instance           : This parameter is intended to differenciate each instance of the widget/shortcode/function you use, it's required in order for the asynchronous pagination links to work
* @suppress_filters   : This parameter is specially useful when dealing with WP_Query custom filters, if you are using a plugin like Advanced Category Excluder then you must set this value to YES/TRUE

== Changelog ==

= 1.3 =
* Improvement: Added suppress_filters parameter for third party plugins support. This parameter when set to TRUE reset query filters.

= 1.2.5 =
* Improvement: Ellipsis are now displayed only when excerpt length exceeds the limit specified through excerpt_length.

= 1.2.4 =
* Improvement: now when using auto_excerpt=true, excerpts will be generated only for posts without one.
* Bug fix: excerpts were cropped exceeding the value specified through the excerpt_length parameter.
* Bug fix: parameters containing uppercase values were being ignored.

= 1.2.3 =
* Added support for translated date formats.

= 1.2.2 =
* Bug fix: widget thumbnail size was being reset by default data.

= 1.2.1 =
* HTML improvement to simplify visual customization

= 1.2 =
* Loading jQuery UI libraries included in the WordPress core

= 1.1 =
* Support for WordPress 3.5

= 1.0 =
* Initial release

== Screenshots ==
1. Posts Output
2. Multi-instance Widget
3. Shortcodes
4. TinyMCE Form to set shortcodes

== Frequently Asked Questions ==

= What do I need in order to make this plugin work for me? =
Technically nothing, but the pagination feature uses jQuery to load the content without reloading the page. It's prettier that way but it's up to you (pagination is not Javascript dependant, no jQuery = no fancy loading effects that's all). jQuery is included by default in WordPress, so you don't need to do anything or add anything.

= I can't see the thumbnails =
Your theme have to support thumbnails, just add this to the function.php inside your theme folder:
`add_theme_support('post-thumbnails');`

= Can I pull posts from custom post types? =
Not in this version, you can buy Single Latest Posts (pro) which includes custom post type capabilities. Please visit http://single-latest-posts.laelitenetwork.com

= How can I display posts from multiple categories and/or tags? =
Single Latest Posts (pro) allows you to display posts from multiple categories and/or tags. Please visit http://single-latest-posts.laelitenetwork.com

= What else is missing from the Lite version? =
Full post content, random posts, sorting capabilities, custom thumbnails and custom default stylesheets options.