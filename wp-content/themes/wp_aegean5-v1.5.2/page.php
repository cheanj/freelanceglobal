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
	
	<div class="row">
		
		<?php if ($sidebar_location == 'left'): ?>
			<section id="sidebar" class="five columns alpha">
				<?php dynamic_sidebar('sidebar-pages'); ?>
			</section>
		<?php endif; ?>
		
		<section class="<?php echo $content_class; ?>">
			<div class="news-lst single">

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<article class="group">
						<?php ci_the_post_thumbnail(array('class' => 'scale-with-grid')); ?>
						<div class="row">
							<div class="eleven columns alpha group">
								<h1><?php the_title(); ?></h1>
								<?php ci_e_content(); ?>
								<?php has_readmore(); ?>
							</div>	
						</div><!-- /row -->
						<?php comments_template(); ?>
					</article>
				<?php endwhile; endif; ?>

			</div><!-- /news-lst -->
		</section><!-- /twelve -->
		
		<?php if ($sidebar_location == 'right'): ?>
			<section id="sidebar" class="five columns omega">
				<?php dynamic_sidebar('sidebar-pages'); ?>
			</section>
		<?php endif; ?>

	</div><!-- /row -->
</div><!-- /container -->

<?php get_footer(); ?>
