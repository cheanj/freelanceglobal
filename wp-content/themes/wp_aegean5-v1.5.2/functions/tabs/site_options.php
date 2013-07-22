<?php global $ci, $ci_defaults, $load_defaults; ?>
<?php if ($load_defaults===TRUE): ?>
<?php
	add_filter('ci_panel_tabs', 'ci_add_tab_site_options', 10);
	if( !function_exists('ci_add_tab_site_options') ):
		function ci_add_tab_site_options($tabs) 
		{ 
			$tabs[sanitize_key(basename(__FILE__, '.php'))] = __('Site Options', 'ci_theme'); 
			return $tabs; 
		}
	endif;

	// Default values for options go here.
	// $ci_defaults['option_name'] = 'default_value';
	// or
	// load_panel_snippet( 'snippet_name' );

	$ci_defaults['weather_code']	= 'GRXX0044';
	$ci_defaults['weather_unit']	= 'c';

	load_panel_snippet('logo');
	load_panel_snippet('favicon');
	load_panel_snippet('touch_favicon');
	load_panel_snippet('footer_text');

?>
<?php else: ?>
	
	<?php load_panel_snippet('logo'); ?>

	<fieldset class="set">
		<p class="guide"><?php _e('You can display the weather temperature for your location. <a href="http://edg3.co.uk/snippets/weather-location-codes/">Go to this website</a> enter your city and press search. Copy and paste in the following field the code. For example for Athens, Greece the code is <strong>GRXX0004</strong>', 'ci_theme'); ?></p>
		<?php ci_panel_input('weather_code', __('Weather Code', 'ci_theme')); ?>
		<?php 
			$weather_unit_options = array(
				'c' => __('C - Celcius', 'ci_theme'),
				'f' => __('F - Fahrenheit', 'ci_theme')
			);
			ci_panel_dropdown('weather_unit', $weather_unit_options, __('Temperature Unit. "c" for Celsius or "f" for Fahrenheit', 'ci_theme')); 
		?>
	</fieldset>

	<?php load_panel_snippet('favicon'); ?>

	<?php load_panel_snippet('touch_favicon'); ?>

	<?php load_panel_snippet('footer_text'); ?>
	
	<?php load_panel_snippet('sample_content'); ?>

<?php endif; ?>
