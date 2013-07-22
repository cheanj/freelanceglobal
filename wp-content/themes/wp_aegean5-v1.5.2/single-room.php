<?php get_header(); ?>

<div id="main" class="container">
	
	<?php
		$sidebar_location = ci_setting('blog_sidebar');
		$content_class = '';
		if ($sidebar_location == 'left'):
			$content_class = 'content eleven columns omega group';
		else:
			$content_class = 'content eleven columns alpha group';
		endif;	
	?>

	<?php get_template_part('inc_bc'); ?>
	
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
		<?php 
			global $post;
			
			// Exclude the featured image from the slider, if it appears on the header.
			if( get_post_meta($post->ID, 'ci_cpt_room_featured_header', true) == 'disabled' )
				$exclude_id = array();	
			else
				$exclude_id = array(get_post_thumbnail_id());	

			$args = array( 
				'post__not_in' => $exclude_id, 
				'post_type' => 'attachment', 
				'post_mime_type' => 'image',
				'numberposts' => -1, 
				'post_status' => null, 
				'post_parent' => $post->ID,
				'order' => 'ASC',
				'orderby' => 'menu_order ID'
			);
			$attachments = get_posts($args);
			$image_count = count($attachments);	
			$slider_enabled = get_post_meta($post->ID, 'ci_cpt_room_slider', true)!='disabled' ? true : false;
		?>
		<?php if($slider_enabled and $image_count > 0): ?>
			<div class="row room-gallery">
				<div id="room-gallery" class="flexslider">
					<ul class="slides">
						<?php
							foreach ( $attachments as $attachment )
							{
								$ci_img_large = wp_get_attachment_image_src( $attachment->ID, 'large' );
								$ci_img = wp_get_attachment_image_src( $attachment->ID, 'ci_room_slider' );											
								echo '<li><a href="' . $ci_img_large[0] . '" class="fb" rel="room-slider"><img src="' . $ci_img[0] .'" /><div class="overlay2" style="display: none;"></div></a></li>';
							}
						?>
					</ul><!-- /slides -->	
				</div><!-- /#room-gallery -->

				<?php if($image_count > 1): ?>
					<div id="room-carousel" class="flexslider">
						<ul class="slides">
							<?php
								foreach ( $attachments as $attachment )
								{
									$ci_img = wp_get_attachment_image( $attachment->ID, 'ci_room_slider' );
									echo '<li>' . $ci_img .'</li>';
								}
							?>
						</ul><!-- /slides -->
					</div>
				<?php endif; ?>

			</div><!-- /.room-gallery -->
		<?php endif; ?>
	
	<?php endwhile; endif; ?>
	
	<div class="row">

		<?php if ($sidebar_location == 'left'): ?>
			<section id="sidebar" class="five columns alpha">
				<?php dynamic_sidebar('sidebar-room'); ?>
			</section>
		<?php endif; ?>
		
		<section class="<?php echo $content_class; ?>">

			<?php $amenities = get_post_meta($post->ID, 'ci_cpt_room_amenities', true); ?>
			<?php if(count($amenities) > 0 and (!empty($amenities))): ?>
				<h2><?php _e('Amenities', 'ci_theme'); ?></h2>
				<p id="amenities">
					<?php
						foreach($amenities as $am)
						{
							echo '<span>'.$am.'</span>';
						} 
					?>
				</p>	
			<?php endif; ?>
			<?php ci_e_content(); ?>
			
			<?php 
				$args = array(
					'post_type' => get_post_type(),
					'numberposts' => 1,
					'post_status' => 'publish',
					'post__not_in' => array( get_the_ID() ),
					'orderby' => 'rand'
				);
				$related_posts = get_posts( $args );
			?>
			
			<?php if ( ci_setting( 'show_related_posts' ) == 'enabled' ): ?>
				<h2 class="double"><span><?php _e('You might also like','ci_theme'); ?></span></h2>
				<div class="row">			
					<?php
						global $post;
						$old_post = $post;
		
						foreach ( $related_posts as $post ) {
							setup_postdata($post);
							$attr = array(
								'title' => trim( strip_tags( $post->post_title ) )
							);
							$url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'ci_room_related');
							$url_large = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
							$room_price = get_post_meta($post->ID, 'ci_cpt_room_from', true);
							$room_offer = get_post_meta($post->ID, 'ci_cpt_room_offer', true);	 
							?>
								<article class="eleven block relative with-action columns alpha">
									<a href="<?php echo $url_large[0]; ?>" class="fb">
										<h1><?php the_title(); ?></h1>
										<figure>
											<?php if (!empty($room_offer)): ?>
												<img src="<?php echo get_template_directory_uri(); ?>/images/dummy/bg_offer.png" alt="<?php echo esc_attr(__('Offer', 'ci_theme')); ?>" class="ribbon" />
											<?php endif; ?>	
											<img src="<?php echo $url[0]; ?>" class="scale-with-grid" alt="" />
										</figure>
										
										<div class="overlay"></div>
									</a>
									<p class="col-action group"> <?php echo sprintf(_x('From <strong>%s</strong> / Night', 'lowest price per night', 'ci_theme'), $room_price); ?> <a href="<?php the_permalink(); ?>" class="link-button"><?php _e('Learn more', 'ci_theme'); ?></a></p>
								</article>
							<?php
						}
						$post = $old_post;
						setup_postdata($post);
					?>
				</div><!-- /row -->
			<?php endif; ?>
		
		</section>
	
		<?php if ($sidebar_location == 'right'): ?>
			<section id="sidebar" class="five columns omega">
				<?php dynamic_sidebar('sidebar-room'); ?>
			</section>
		<?php endif; ?>

	</div><!-- /row -->
</div><!-- /container -->

<?php get_footer(); ?>
