<?php 
	global $post;

	$img_url = ci_setting('default_header_bg');
	$img_id = ci_setting('default_header_bg_hidden');

	// Assign first the fallback image. It will be replaced next if another featured image exists.
	if(!empty($img_url) and !empty($img_id))
	{
		$img_info = wp_get_attachment_image_src($img_id, 'ci_page_header');
	}

	// Replace the header image if the post/page has a featured image assigned
	if(is_single() or is_page())
	{
		if(has_post_thumbnail() and get_post_meta($post->ID, 'ci_cpt_room_featured_header', true) != 'disabled')
		{
			$img_id = get_post_thumbnail_id($post->ID);
			$img_info = wp_get_attachment_image_src($img_id, 'ci_page_header');
			if(!empty($img_info))
			{
				$img_url = $img_info[0];
			}

		}
	}


?>
<div id="page-header" style="background:url(<?php echo $img_url; ?>) center;"></div><!-- /page-header -->
