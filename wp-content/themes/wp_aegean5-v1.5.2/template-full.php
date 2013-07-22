<?php
/*
Template Name: Full Width, No Sidebar
*/
?>
<?php get_header(); ?>

<div id="main" class="container">

	<?php get_template_part('inc_bc'); ?>

	<div class="row">
		<section class="content sixteen columns alpha group single">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<article class="group">
					<div class="row">
						<?php ci_the_post_thumbnail_full(array('class' => 'scale-with-grid')); ?>
						<div class="sixteen columns alpha group">
						
							<?php ci_e_content(); ?>
						</div>
					</div><!-- /row -->
					<?php comments_template(); ?>
				</article>
			<?php endwhile; endif; ?>
		</section><!-- /content -->
	</div><!-- /row -->
</div><!-- /container -->

<?php get_footer(); ?>
