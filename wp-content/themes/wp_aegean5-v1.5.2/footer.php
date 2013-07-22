<!--NEWS SECTION -->
<div id="news-wrap">
	<footer id="footer" class="container">
		
		<?php if(ci_setting('footer_blog_show')=='enabled' or ci_setting('footer_newsletter_show')=='enabled'): ?>
			<div class="row">
				<?php 
					$classes = '';
					if(ci_setting('footer_blog_show')=='enabled' and ci_setting('footer_newsletter_show')=='enabled')
					{
						$classes['blog'] = 'sixteen columns';
						$classes['blog_excerpt'] = 'nine';
						$classes['newsletter'] = 'column one-third omega';
					}
					if(ci_setting('footer_blog_show')=='enabled' and ci_setting('footer_newsletter_show')!='enabled')
					{
						$classes['blog'] = 'sixteen columns';
						$classes['blog_excerpt'] = 'fifteen';
						$classes['newsletter'] = '';
					}
					if(ci_setting('footer_blog_show')!='enabled' and ci_setting('footer_newsletter_show')=='enabled')
					{
						$classes['blog'] = '';
						$classes['blog_excerpt'] = '';
						$classes['newsletter'] = 'sixteen columns';
					}
				?>
				<?php if(ci_setting('footer_blog_show')=='enabled'): ?>
					<div class="<?php echo $classes['blog']; ?>">
					<h1>News and Articles</h1>
					<hr/>
					<div id="news-carousel" class="flexslider">
						<ul class="slides">
							<?php 
								global $post;
								$latest_posts = new WP_Query( array(
									'post_type'=>'post',
									'posts_per_page' => ci_setting('footer_blog_posts'),
									'category_name' => 'news'
								)); 								
							?>
							<?php while ( $latest_posts->have_posts() ) : $latest_posts->the_post(); ?>
							<li class="eight block relative with-action columns alpha">
								<article class="group">
									
									<div>
										<h3 class="italic-head"><a href="<?php the_permalink(); ?>" title="<?php echo __('Permalink to', 'ci_theme').' '.get_the_title(); ?>"><?php the_title(); ?></a></h3>
										
											
											 <?php
											 echo split_content();

												// original content display
												// the_content('<p>Read the rest of this page &raquo;</p>');
												// split content into array
												//$contents = split_content();
												
																								?>
										<?php //global $more;
												//$more = 0;
												?>
												<?php //the_content('Read More'); ?>

												
									</div>
								</article>
							</li><!-- /news item -->
							<?php endwhile; wp_reset_postdata(); ?>
		
						</ul><!-- /news-lst -->
					</div>
					</div><!-- /two-third -->
				<?php endif; ?>
				
				<?php if(ci_setting('footer_newsletter_show')=='enabled'): ?>
					<div class="<?php echo $classes['newsletter']; ?>">
					</div><!-- /one-third -->
				<?php endif; ?>
				
			</div><!-- /row -->
		<?php endif; // if footer_blog_show or footer_newsletter_show ?>	
		
	</footer>	
</div>
<div id="footer-wrap">
	<footer id="footer" class="container">
	
		<?php get_template_part('inc_booking'); ?>
		
		<?php if(ci_setting('footer_blog_show')=='enabled' or ci_setting('footer_newsletter_show')=='enabled'): ?>
			<div class="row">
				<?php 
					$classes = '';
					if(ci_setting('footer_blog_show')=='enabled' and ci_setting('footer_newsletter_show')=='enabled')
					{
						$classes['blog'] = 'column two-thirds alpha';
						$classes['blog_excerpt'] = 'nine';
						$classes['newsletter'] = 'column one-third omega';
					}
					if(ci_setting('footer_blog_show')=='enabled' and ci_setting('footer_newsletter_show')!='enabled')
					{
						$classes['blog'] = 'sixteen columns';
						$classes['blog_excerpt'] = 'fifteen';
						$classes['newsletter'] = '';
					}
					if(ci_setting('footer_blog_show')!='enabled' and ci_setting('footer_newsletter_show')=='enabled')
					{
						$classes['blog'] = '';
						$classes['blog_excerpt'] = '';
						$classes['newsletter'] = 'sixteen columns';
					}
				?>
				<?php if(ci_setting('footer_blog_show')=='enabled'): ?>
					<div class="<?php echo $classes['blog']; ?>">
						<ul class="news-lst">
							<?php 
								global $post;
								$latest_posts = new WP_Query( array(
									'post_type'=>'post',
									'posts_per_page' => ci_setting('footer_blog_posts'),
									'category_name' => 'news'
								)); 								
							?>
							<?php while ( $latest_posts->have_posts() ) : $latest_posts->the_post(); ?>
							<li>
								<article class="group">
									<time class="one columns alpha" datetime="<?php echo get_the_date('Y-m-d'); ?>">
										<b><?php echo get_the_date('d'); ?></b><?php echo get_the_date('M'); ?>
									</time>
									<div class="<?php echo $classes['blog_excerpt']; ?> columns omega">
										<h3><a href="<?php the_permalink(); ?>" title="<?php echo __('Permalink to', 'ci_theme').' '.get_the_title(); ?>"><?php the_title(); ?></a></h3>
										<?php the_excerpt(); ?>
									</div>
								</article>
							</li><!-- /news item -->
							<?php endwhile; wp_reset_postdata(); ?>
		
						</ul><!-- /news-lst -->
					</div><!-- /two-third -->
				<?php endif; ?>
				
				<?php if(ci_setting('footer_newsletter_show')=='enabled'): ?>
					<div class="<?php echo $classes['newsletter']; ?>">
					</div><!-- /one-third -->
				<?php endif; ?>
				
			</div><!-- /row -->
		<?php endif; // if footer_blog_show or footer_newsletter_show ?>
		
		
		<div id="footer-widgets" class="row">
			<div class="one-third column alpha">
				<?php dynamic_sidebar('footer-left'); ?>
			</div>
			<div class="one-third column">
				<?php dynamic_sidebar('footer-middle'); ?>
			</div>
		</div>
		
	</footer>	
</div>

<!-- /footer-wrap -->

		<div class="row credits">
			<div class="twelve columns alpha">
				<?php 
				if(has_nav_menu('ci_footer_menu1'))
					wp_nav_menu( array(
						'theme_location' 	=> 'ci_footer_menu1',
						'fallback_cb' 		=> '',
						'container' 		=> '',
						'menu_id' 			=> '',
						'menu_class' 		=> 'footer-nav group'
					));
				?>
				<?php 
				if(has_nav_menu('ci_footer_menu2'))
					wp_nav_menu( array(
						'theme_location' 	=> 'ci_footer_menu2',
						'fallback_cb' 		=> '',
						'container' 		=> '',
						'menu_id' 			=> '',
						'menu_class' 		=> 'footer-nav group'
					));
				?>
			</div><!-- /twelve.columns -->
			<div class="four columns omega sig">
				<?php echo ci_footer(); ?>
			</div>
		</div><!-- /row -->

<?php wp_footer(); ?>

</body>
</html>
