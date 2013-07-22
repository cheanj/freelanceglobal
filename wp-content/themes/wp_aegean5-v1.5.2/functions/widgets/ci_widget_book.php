<?php 
if( !class_exists('CI_Book') ):
class CI_Book extends WP_Widget {

	function CI_Book(){
		$widget_ops = array('description' => __('Book now widget', 'ci_theme'));
		$control_ops = array('width' => 300, 'height' => 400);
		parent::WP_Widget('ci_book_widget', $name='-= CI Book Now =-', $widget_ops, $control_ops);
	}

	function widget($args, $instance) {
		extract($args);
		$ci_price = $instance['ci_price'];
		echo $before_widget;
		echo '<p class="book-now-price">'. sprintf(__('From <strong>%s</strong> per night', 'ci_theme'), $ci_price) . '</p>';
		echo '<p class="book-now-action"><a href="'. get_permalink(ci_setting('booking_form_page')) .'" class="link-button">'. __('Book Now','ci_theme') .'</a> <span>' . __('Immediate confirmation', 'ci_theme') . '</span></p>';
		echo $after_widget;
	} // widget

	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['ci_price'] = stripslashes($new_instance['ci_price']);
		return $instance;
	} // save

	function form($instance){
		$instance = wp_parse_args( (array) $instance, array('ci_price'=>''));
		$ci_price = htmlspecialchars($instance['ci_price']);
		?>
		<p><?php _e('The widget will display a generic booking button, using the price set below. Useful for non-room pages.', 'ci_theme'); ?></p>
		<?php
		echo '<p><label>' . 'Price:' . '</label><input id="' . $this->get_field_id('ci_price') . '" name="' . $this->get_field_name('ci_price') . '" type="text" value="' . esc_attr($ci_price) . '" class="widefat" /></p>';
	} // form

} // class

register_widget('CI_Book');

endif; // class_exists
?>
