<?php 
	global $post;
	$q = new WP_Query( array(
		'post_type'=>'slider',
		'posts_per_page' => -1
	)); 
?>

<div id="slider-wrap">
	<div id="home-slider" class="flexslider">
		<ul class="slides">

			<?php while ( $q->have_posts() ) : $q->the_post(); ?>
				<?php 
					global $post;
					$img_id = false;
					$img_url = '';
					if(has_post_thumbnail())
					{
						$img_id = get_post_thumbnail_id($post->ID);
						$img_info = wp_get_attachment_image_src($img_id, 'ci_home_slider');
						if(!empty($img_info))
						{
							$img_url = $img_info[0];
						}
					}
				?>
				<?php if(!empty($img_url)): ?>
					<li>
						<img src="<?php echo $img_url; ?>" class="scale-with-grid" alt="<?php the_title(); ?>" />dfdfdf
					</li>
				<?php endif; ?>
			<?php endwhile; ?>	

			<?php wp_reset_postdata(); ?>

		</ul>

		<div class="flex-captions container"><p></p></div>
	</div><!-- /flexslider -->
</div><!-- /slider -->
