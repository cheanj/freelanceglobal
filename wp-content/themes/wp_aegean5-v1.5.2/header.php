<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
	================================================== -->
	<meta charset="utf-8">
	<title><?php ci_e_title(); ?></title>
	
	<!-- Mobile Specific Metas
	================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


	<!-- JS files are loaded via /functions/scripts.php -->

	<!-- CSS files are loaded via /functions/styles.php -->
	
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php do_action('after_open_body_tag'); ?>

<div id="header-wrap">
	<header id="header" class="container">

		<?php ci_e_logo('<h1>', '</h1>'); ?>

		<nav id="navigation" class="ten columns alpha">
			<?php 
				if(has_nav_menu('ci_main_menu'))
					wp_nav_menu( array(
						'theme_location' 	=> 'ci_main_menu',
						'fallback_cb' 		=> '',
						'container' 		=> '',
						'menu_id' 			=> 'nav',
						'menu_class' 		=> 'nav group'
					));
				else
					wp_page_menu();
			?>
		</nav><!-- /navigation -->

		<!---<div id="weather-lang" class="six columns omega">
			<div id="yw" class="four columns alpha">
				<span id="ywloc"></span>
				<span id="ywtem"></span>
			</div>
			<nav id="lang" class="two columns omega">
				<a href="#"><img src="<?php echo get_template_directory_uri() ?>/images/de.png" alt="German" /></a><a href="#"><img src="<?php echo get_template_directory_uri() ?>/images/it.png" alt="Italian" /></a><a href="#"><img src="<?php echo get_template_directory_uri() ?>/images/fr.png" alt="French" /></a>
			</nav>
		</div>- /weather-lang -->
		
	</header><!-- /header -->
</div><!-- /container -->
    <div id="floatMenu">
        <ul>
            <li><a href="#" onclick="return false;"> Home </a></li>
        </ul>
        
       <ul>
            <li><a href="#" onclick="return false;"> Table of content </a></li>
            <li><a href="#" onclick="return false;"> Exam </a></li>
            <li><a href="#" onclick="return false;"> Wiki </a></li>
        </ul>
        
        <ul>
            <li><a href="#" onclick="return false;"> Technical support </a></li>
        </ul>
    </div>
<?php bloginfo('template_directory');?>
<?php
	if (is_page_template('template-front.php')):
		get_template_part('inc_slider');
	else:
		get_template_part('inc_slider');
	endif;
?>

