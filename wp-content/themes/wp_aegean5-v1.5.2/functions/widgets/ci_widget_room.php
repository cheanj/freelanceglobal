<?php 
if( !class_exists('CI_Room_Widget') ):
class CI_Room_Widget extends WP_Widget {

	function CI_Room_Widget(){
		$widget_ops = array('description' => __('Displays a room', 'ci_theme'));
		$control_ops = array('width' => 300, 'height' => 400);
		parent::WP_Widget('ci_room_widget', $name='-= CI Room =-', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance) {
		global $post;
		$old_post = $post;
				
		extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$post_id = $instance['post_id'];

		$post = get_post($post_id);

		echo $before_widget;
		echo '<div class="ci_widget_room">';

		if($post)
		{
			setup_postdata($post);
			if (empty($title)) $title = get_the_title();
			$ci_img = get_the_post_thumbnail($post->ID, 'ci_home_widgets');
			$ci_img = str_replace( 'class="', 'class="scale-with-grid ', $ci_img );
			echo '<a href="'. get_permalink() .'">';
			echo $before_title . $title . $after_title;
			echo '<figure>' . $ci_img . '</figure>';
			the_excerpt();
			echo '</a>';
		}

		echo "</div>";
		echo $after_widget;

		$post = $old_post;
		setup_postdata($post);
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = stripslashes($new_instance['title']);
		$instance['post_id'] = intval($new_instance['post_id']);
		return $instance;
	}
	 
	function form($instance){
		$instance = wp_parse_args( (array) $instance, array('post_id' => 0, 'title'=>'') );
		$post_id = intval($instance['post_id']);
		$title = htmlspecialchars($instance['title']);
		echo '<p><label for="'.$this->get_field_id('title').'">' . __('Title (leave empty to use the room\'s title):', 'ci_theme') . '</label><input id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" class="widefat" /></p>';
		echo '<p><label for="'.$this->get_field_id('post_id').'">'.__('Room to show:', 'ci_theme').'</label></p>';
		wp_dropdown_posts( array(
			'post_type' => 'room',
			'selected' => $post_id,
			'id' => $this->get_field_id('post_id')
		), $this->get_field_name('post_id'));
	}

} // class

register_widget('CI_Room_Widget');

endif; // class_exists
?>
