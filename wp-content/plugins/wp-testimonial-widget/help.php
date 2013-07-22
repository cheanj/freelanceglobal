<?php 
	global $wpdb;
	wp_register_style( 'swpt_help_css', plugins_url('css/main.css', __FILE__) );
 	wp_enqueue_style( 'swpt_help_css' );
?>
<!-- Information below is to know about how to wirte a shortcode -->
<h2><img src="<?php echo plugins_url('images/help_icon.png', __FILE__); ?>" class="title_img"/> Help for Testimonial</h2>
<p><h3>Widget Information</h3></p>
<p>1. Widget for testimonial is available in widgets area. <p/>
<p>2. You can drag and drop it in any widget area.</p>
<p>3. It has settings to display on frontend. Settings are as follows: </p>
<p>
	<ul class="parameters">
		<li class="list_parameter"><strong>Number of testimonials to show</strong> - how many testimonials you want to show in sidebar.</li>
		<li class="list_parameter"><strong>Order by</strong> - Either <strong>Ascending</strong> or <strong>Descending</strong>.</li>
		<li class="list_parameter"><strong>Effect</strong> - jQuery effect to apply for transition of testimonials. Please find list of available effects below.</li>
		<li class="list_parameter"><strong>time</strong> - Pause time between two testimonials(in milliseconds).</li>
	</ul>
</p>
<p><h3>How to add shortcode</h3></p>
<p>1. The shortcode <strong>[swp-testimonial]</strong> is used to display testimonials on your post or page content.</p>  
<p>2. It has following parameters: </p>  
<p>
	<ul class="parameters">
		<li class="list_parameter"><strong>testimonials</strong> - Number of testimonials to show.</li>
		<li class="list_parameter"><strong>order</strong> - Either <strong>asc</strong> (Ascending) or <strong>desc</strong> (descending).</li>
		<li class="list_parameter"><strong>effects</strong> - jQuery effect to apply for transition of testimonials. Please find list of available effects below.</li>
		<li class="list_parameter"><strong>time</strong> - Pause time between two testimonials(should be in milliseconds).</li>
	</ul>
</p>
<p>3. When you add the shortcode without any parameters, it will show only one recently added testimonial.</p> 

<p><h3>Examples - </h3>
	<ul class="display_effet">
		<li class="list_display" >[swp-testimonial testimonials=4 order=asc effects=scrollVert time=5000]</li>
		<li class="list_display" >[swp-testimonial testimonials=2 effects=zoom]</li>
		<li class="list_display" >[swp-testimonial testimonials=desc effects=toss time=3000]</li>
		<li class="list_display" >[swp-testimonial testimonials=2 order=desc]</li>
		<li class="list_display" >[swp-testimonial testimonials=2 order=desc effects=turnDown time=10000]</li>
	</ul>
</p> 
<p><h3>Available Effects-</h3> 
	<ul class="display_effet_list">
		<li class="list_display" >blindX</li>
		<li class="list_display" >blindY</li>
		<li class="list_display" >blindZ</li>
		<li class="list_display" >curtainY</li>
		<li class="list_display" >fade</li>
		<li class="list_display" >fadeZoom</li>
		<li class="list_display" >growY</li>
		<li class="list_display" >none</li>
		<li class="list_display" >scrollUp</li>
		<li class="list_display" >scrollDown</li>
	</ul>
	<ul class="display_effet_list">
		<li class="list_display" >scrollLeft</li>
		<li class="list_display" >scrollRight</li>
		<li class="list_display" >scrollHorz</li>
		<li class="list_display" >scrollVert</li>
		<li class="list_display" >toss</li>
		<li class="list_display" >turnDown</li>
		<li class="list_display" >zoom</li>
	</ul>
</p>  