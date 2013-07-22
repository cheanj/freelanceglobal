<?php
/*
Template Name: Homepage
*/
?>

<?php get_header(); ?>

<div id="main" class="container front-container">
	<div class="row">
		<?php dynamic_sidebar('homepage'); ?>
	</div>
	<div class="row drop-in">
		<?php dynamic_sidebar('home-testimonials');	?>
	</div><!-- /row -->
</div><!-- /container -->

<?php get_footer(); ?>
