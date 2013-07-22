<?php 
if( !class_exists('CI_Book_Room') ):
class CI_Book_Room extends WP_Widget {

	function CI_Book_Room(){
		$widget_ops = array('description' => __('Book current viewing room (for the Rooms Sidebar)', 'ci_theme'));
		$control_ops = array('width' => 300, 'height' => 400);
		parent::WP_Widget('ci_book_room_widget', $name='-= CI Book Room =-', $widget_ops, $control_ops);
	}

	function widget($args, $instance) {
		global $post;

		$ci_price = get_post_meta($post->ID, 'ci_cpt_room_from', true);

		extract($args);

		echo $before_widget;
		echo '<p class="book-now-price">'. sprintf(__('From <strong>%s</strong> per night', 'ci_theme'), $ci_price) . '</p>';
		echo '<p class="book-now-action"><a href="'. add_query_arg('room_select', $post->ID, get_permalink(ci_setting('booking_form_page'))) .'" class="link-button">'. __('Book Now','ci_theme') .'</a> <span>' . __('Immediate confirmation', 'ci_theme') . '</span></p>';
		echo $after_widget;
		
	} // widget

	function update($new_instance, $old_instance){
		return $old_instance;
	} // save

	function form($instance){
		?>
		<p><?php _e('The widget will display a booking button, using the price set in the Room Details of each room.', 'ci_theme'); ?></p>
		<?php
	} // form

} // class


register_widget('CI_Book_Room');

endif; // class_exists
?>
