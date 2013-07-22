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
				<?php dynamic_sidebar('sidebar-blog'); ?>
			</section>
		<?php endif; ?>
		
		<section class="<?php echo $content_class; ?>">
			<ul class="news-lst">

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<li>
						<article class="group">
							<?php the_post_thumbnail('ci_blog_featured', array('class' => 'scale-with-grid')); ?>
							
							<div class="nine columns omega">
								<h1><a href="<?php the_permalink(); ?>" title="<?php echo sprintf(__('Permalink to %s', 'ci_theme'), get_the_title()); ?>"><?php the_title(); ?></a></h1>
								<?php ci_e_content(); ?>
							</div>
						</article>
					</li><!-- /news item -->
				<?php endwhile; endif; ?>

			</ul><!-- /news-lst -->			

			<?php ci_pagination(); ?>			

		</section><!-- /twelve -->
		
		<?php if ($sidebar_location == 'right'): ?>
			<section id="sidebar" class="five columns omega">
				<?php dynamic_sidebar('sidebar-blog'); ?>
			</section>
		<?php endif; ?>
					
	</div><!-- /row -->
</div><!-- /container -->

<?php get_footer(); ?>
