<?php 
if( !class_exists('CI_Testimonial') ):
class CI_Testimonial extends WP_Widget {
	function CI_Testimonial(){
		$widget_ops = array('description' => __('Testimonial widget', 'ci_theme'));
		$control_ops = array('width' => 300, 'height' => 400);
		parent::WP_Widget('ci_testimonial_widget', $name='-= CI Testimonial =-', $widget_ops, $control_ops);
	}

	function widget($args, $instance) {
		extract($args);
		$ci_cite = $instance['ci_cite'];
		$ci_testimonial = $instance['ci_testimonial']; 		
		echo $before_widget;
		echo "<blockquote>";
		echo "<p>" . $ci_testimonial . "</p>";
		echo "<cite>" . $ci_cite . "</cite>";
		echo "</blockquote>";
		echo $after_widget;
	} // widget

	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['ci_cite'] = stripslashes($new_instance['ci_cite']);
		$instance['ci_testimonial'] = stripslashes($new_instance['ci_testimonial']);
		return $instance;
	} // save

	function form($instance){
		$instance = wp_parse_args( (array) $instance, array('ci_cite'=>'', 'ci_testimonial'=>'') );
		$ci_cite = htmlspecialchars($instance['ci_cite']);
		$ci_testimonial = htmlspecialchars($instance['ci_testimonial']);
		echo '<p><label>' . __('Cite:', 'ci_theme') . '</label><input id="' . $this->get_field_id('ci_cite') . '" name="' . $this->get_field_name('ci_cite') . '" type="text" value="' . $ci_cite . '" class="widefat" /></p>';
		echo '<p><label>' . __('Testimonial:', 'ci_theme') . '</label><textarea cols="30" rows="10" id="' . $this->get_field_id('ci_testimonial') . '" name="' . $this->get_field_name('ci_testimonial') . '" class="widefat" >'. $ci_testimonial .'</textarea></p>';
	} // form
} // class

register_widget('CI_Testimonial');

endif; // class_exists
?>
