<?php 
/**
 * Class SWP_Testimonial_Widget is to display widget.
*/
class SWP_Testimonial_Widget extends WP_Widget {

	function SWP_Testimonial_Widget(){
		parent::WP_Widget(false,$name="Testimonial Widget",array('description'=>'Display Testimonials'));
	}

	/**
	 * Function widget() contains data to show on frontend.
	 * @param array $args of widget area.  
	 * @param array $instance current settings of widget.
	*/
	function widget($args,$instance){
		global $post;
		global $wp_query;
		extract($args);

		$widget_title=$instance['widget_title'];
		$posts=$instance['post_no'];
		$order=$instance['post_sorting'];
		$effect=$instance['effect'];
		$time=$instance['time'];
		
	?>
		<script type="text/javascript">
	        jQuery(document).ready(function() {
	                var effect = '<?php echo $effect; ?>';
	                if(effect != 'none')
	                {
	                    jQuery('.content_display').cycle({ 
	                        fx: effect, 
	                        timeout: '<?php echo $time; ?>',
	                        random:  1
	                    }); 
	                }
	            });
	    </script>
		
		<?php 
		echo $before_widget; 
	
		if(!empty($widget_title)){ 
			echo $before_title.$widget_title.$after_title;
		} 
		?>
		<div class='content_display'>	
			<?php 
				$output_data = swpt_widget_shortcode_output($posts,$order);
				echo $output_data;
			?>
		</div>
		<?php 
		echo $after_widget; 
	}

	/**
	 * Function update() is to save inserted data.
	 * @param array $new_instance is to store updated values.
	 * @param array $old_instance contains old values.
	*/
	function update($new_instance,$old_instance){
		global $wpdb;
		
		$instance=$old_instance;
		$instance['widget_title']=$new_instance['widget_title'];
		$instance['post_sorting']=$new_instance['post_sorting'];
		$instance['effect']=$new_instance['effect'];

		if(!empty($new_instance['post_no']))
		{
			$postCount = $new_instance['post_no'];
		}
		else{
			$postCount = 1;
		}
		$instance['post_no']=$postCount;

		if(!empty($new_instance['time']))
		{
			$effectTime = $new_instance['time'];
		}
		else{
			$effectTime = 1000;
		}
		$instance['time']=$effectTime;
				
		return $instance;
	}

	/**
	 * Function form() displays form in the widget.
	 * @param array $instance current settings of widget.
	*/
	function form($instance) {
		global $wpdb;
								
		$widget_title=$instance['widget_title'];
		$order=$instance['post_sorting'];
		$effect=$instance['effect'];

		if(!empty($instance['post_no']))
		{
			$posts = $instance['post_no'];
		}
		else{
			$posts = 1;
		}
		
		if(!empty($instance['time']))
		{
			$time=$instance['time'];
		}
		else{
			$time=1000;
		}
		?>
		<p>
			<label for="<?php echo  $this->get_field_id('widget_title'); ?>">Title</label>
			<input type="text" name="<?php echo $this->get_field_name('widget_title'); ?>" id="<?php echo $this->get_field_id('widget_title'); ?>" value="<?php echo $widget_title; ?>" class="widefat">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('post_no'); ?>">Number of Testimonails to show</label>
			<input type="text" name="<?php echo $this->get_field_name('post_no'); ?>" id="<?php echo $this->get_field_id('post_no'); ?>" value="<?php echo $posts; ?>" >
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('post_sorting'); ?>">Order By</label>
			<select name="<?php echo $this->get_field_name('post_sorting'); ?>" id="<?php echo $this->get_field_id('post_sorting'); ?>">
				<option value="asc" <?php if($order=='asc' || $order == "") { ?> selected=selected <?php } ?>>Ascending</option>
				<option value="desc" <?php if($order=='desc') { ?> selected=selected <?php } ?>>Descending</option>
			</select>

		</p>
		<p>
			<label for="<?php echo $this->get_field_id('effect'); ?>">Effect</label>
			<select name="<?php echo $this->get_field_name('effect'); ?>" id="<?php echo $this->get_field_id('effect'); ?>">
				<?php
					$arrEffect = array("blindX","blindY","blindZ","curtainY","fade","fadeZoom","growY","none","scrollUp","scrollDown","scrollLeft","scrollRight","scrollHorz","scrollVert","toss","turnUp","turnDown","zoom"); 
					foreach($arrEffect as $strKey => $strValue)
					{
				?>
				<option value="<?php echo $strValue; ?>" <?php if($effect==$strValue) { ?> selected=selected <?php } ?>><?php echo ucfirst($strValue); ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('time'); ?>">Effect Duration (milliseconds)</label>
			<input type="text" name="<?php echo $this->get_field_name('time'); ?>" id="<?php echo $this->get_field_id('time'); ?>" value="<?php echo $time; ?>" size="5">
		</p>
		<?php
	}
}
?>