<?php
/*
Template Name: Gallery listing 3 columns
*/
?>
<?php get_header(); ?>

<div id="main" class="container">	
	<?php get_template_part('inc_bc'); ?>	
	<?php 
		global $paged;
		$params = array(
			'paged' => $paged,
			'post_type' => 'gallery'
		);
		query_posts($params);
	?>	
	<?php
		$count_rooms = count($wp_query->posts); 
		$i = 1;
		$alpha = '';
		$open	= '';
		$close = '';
	?>
	<?php if (have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php
			if ($i % 3 === 1):
				$alpha = 'alpha';
				$open 	= '<div class="row">';
				$close = '';
			elseif ($i % 3 === 2):
				$alpha = '';
				$open 	= '';
				$close = '';
			else:
				$alpha = 'omega';
				$open 	= '';
				$close = '</div>';
			endif;

			$room_price = get_post_meta($post->ID, 'ci_cpt_room_from', true);
			$room_offer = get_post_meta($post->ID, 'ci_cpt_room_offer', true);
		?>
		
		<?php echo $open; ?>	
		<article class="one-third block relative with-action column <?php echo $alpha; ?>">

			<?php $room_thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large'); ?>
	
			<a href="<?php echo $room_thumb[0] ?>" class="fb" rel="r<?php echo $i; ?>">
				<h1><?php the_title(); ?></h1>			
				<figure>
					<?php if (!empty($room_offer)): ?>
						<img src="<?php echo get_template_directory_uri() ?>/images/dummy/bg_offer.png" alt="<?php echo esc_attr(__('Offer', 'ci_theme')); ?>" class="ribbon" />
					<?php endif; ?>

					<?php the_post_thumbnail('ci_room_2col', array('class' => 'scale-with-grid')); ?>
				</figure>
				<?php ci_e_content(); ?>
				<div class="overlay"></div>
			</a>
	
			<?php
				$args = array(
					'post_type' => 'attachment', 
					'numberposts' => -1, 
					'post_status' => null, 
					'post_parent' => $post->ID, 
					'orderby' => 'menu_order ID', 
					'order' => 'ASC'
				);
				$attachments = get_posts($args);
			?>
			<div class="hidden">
				<?php
					$image_count = count($attachments);
					if($image_count > 0):
						foreach ( $attachments as $attachment )
						{
							$attr = array( 'alt'   => trim(strip_tags( get_post_meta($attachment->ID, '_wp_attachment_image_alt', true) )));											
							$img_attrf = wp_get_attachment_image_src( $attachment->ID, 'large' );
							echo '<a href="'. $img_attrf[0] .'" rel="r' . $i . '" class="fb">'.wp_get_attachment_image( $attachment->ID, 'large', false, $attr ).'</a>';
						}
					endif;
				?>
			</div>
			<p class="col-action group"><strong><?php echo $image_count+1; ?></strong> <?php _e('Photos', 'ci_theme'); ?> <a href="<?php echo $room_thumb[0] ?>" class="fb link-button" rel="r<?php echo $i; ?>"><?php _e('View set', 'ci_theme'); ?></a></p>
		</article>	
		<?php echo $close; ?>
		
		<?php if (($count_rooms == $i) and ($i % 3 !== 0)) echo "</div>"; ?>
						
		<?php if ($i == 3): ?>
			<div class="row drop-in">
				<?php dynamic_sidebar('galleries-testimonials'); ?>
			</div><!-- /row -->
		<?php endif; ?>
		
		<?php $i++;?>

	<?php endwhile; endif; ?>

	<?php ci_pagination(); ?>			

	<?php wp_reset_query(); ?>

</div><!-- /container -->

<?php get_footer(); ?>
