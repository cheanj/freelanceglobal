<?php
/*
Template Name: Rooms listing 3 columns
*/
?>
<?php get_header(); ?>

<div id="main" class="container">	
	<?php get_template_part('inc_bc'); ?>
	<?php 
		global $paged;

		$paged = get_query_var('paged') ? get_query_var('paged') : 1;
		$base_category = get_post_meta($post->ID, 'base_rooms_category', true);

		$params = array(
			'paged' => $paged,
			'post_type' => 'room'
		);

		$args_tax = array(
			'tax_query' => array(
				array(
					'taxonomy' => 'room_category',
					'field' => 'id',
					'terms' => $base_category,
					'include_children' => true
				)
			)
		);
	
		if(empty($base_category) or $base_category < 1)
			query_posts($params);
		else
			query_posts(array_merge($params, $args_tax));
	?>	
	<?php
		 $count_rooms = count($wp_query->posts); 
		 $i = 1;
		 $alpha = '';
		 $open	= '';
		 $close = '';
	?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
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
	
			<?php if( ci_setting('room_thumbnail_shows')=='room' ): ?>
				<a href="<?php the_permalink(); ?>" rel="r<?php echo $i; ?>">
			<?php else: ?>
				<a href="<?php echo $room_thumb[0]; ?>" class="fb" rel="r<?php echo $i; ?>">
			<?php endif; ?>
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
	
			<p class="col-action group"> <?php echo sprintf(_x('From <strong>%s</strong> / Night', 'lowest price per night', 'ci_theme'), $room_price); ?> <a href="<?php the_permalink(); ?>" class="link-button"><?php _e('Learn more', 'ci_theme'); ?></a></p>
	
		</article>	
		<?php echo $close; ?>
		
		<?php if (($count_rooms == $i) and ($i % 3 !== 0)) echo "</div>"; ?>
						
		<?php if ($i == 3): ?>
			<div class="row drop-in">
				<?php dynamic_sidebar('rooms-testimonials'); ?>
			</div><!-- /row -->
		<?php endif; ?>
		
		<?php $i++; ?>

	<?php endwhile; endif; ?>

	<?php ci_pagination(); ?>			

	<?php wp_reset_query(); ?>

</div><!-- /container -->

<?php get_footer(); ?>
