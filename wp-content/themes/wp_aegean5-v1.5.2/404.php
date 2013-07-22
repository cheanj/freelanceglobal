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
			
			<h2><?php _e('Not found', 'ci_theme'); ?></h2>
			<p><?php _e( 'Oh, no! The page you requested could not be found. Perhaps searching will help...', 'ci_theme' ); ?></p>

			<form role="search" method="get" id="search-body" action="<?php echo esc_url(home_url('/')); ?>">
				<div>
					<input type="text" name="s" id="s-body" value="<?php echo (get_search_query()!="" ? get_search_query() : __('Search...', 'ci_theme') ); ?>" size="18" onfocus="if (this.value == '<?php _e('Search...', 'ci_theme'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Search...', 'ci_theme'); ?>';}" />
					<input type="submit" id="searchsubmit-body" value="<?php _e('Search', 'ci_theme'); ?>" />
				</div>
			</form>

			<script type="text/javascript">
				// focus on search field after it has loaded
				document.getElementById('s-body') && document.getElementById('s-body').focus();
			</script>

		</section><!-- /twelve -->
		
		<?php if ($sidebar_location == 'right'): ?>
			<section id="sidebar" class="five columns omega">
				<?php dynamic_sidebar('sidebar-blog'); ?>
			</section>
		<?php endif; ?>
					
	</div><!-- /row -->
</div><!-- /container -->

<?php get_footer(); ?>
