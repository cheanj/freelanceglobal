<?php if(ci_setting('booking_form_page')!=''): ?>
	<div id="booking">
		<form method="post" class="container" action="<?php echo get_permalink(ci_setting('booking_form_page')); ?>">
			<p class="three columns alpha">
				<label for="arrive"><?php _e('Arrival', 'ci_theme'); ?></label>
				<input name="arrive" type="text" class="calendar" placeholder="<?php _e('Arrival date', 'ci_theme'); ?>" />
			</p>
			<p class="three columns">
				<label for="depart"><?php _e('Departure', 'ci_theme'); ?></label>
				<input name="depart" type="text" class="calendar" placeholder="<?php _e('Departure date', 'ci_theme'); ?>" />
			</p>
			<p class="two columns">
				<label for="adults"><?php _e('Adults', 'ci_theme'); ?></label>
				<input name="adults" type="text" class="count" placeholder="0" />
			</p>
			<p class="two columns">
				<label for="children"><?php _e('Children', 'ci_theme'); ?></label>
				<input name="children" type="text" class="count" placeholder="2" />
			</p>

			<p class="two columns room-select">
				<label for="room_select"><?php _e('Room', 'ci_theme'); ?></label>
				<?php 
					$selected = '';
					if(is_singular() and get_post_type()=='room')
						$selected = get_the_ID();
						
					wp_dropdown_posts(array(
						'id' => 'room_select',
						'post_type' => 'room',
						'selected' => $selected
					), 'room_select'); 
				?>
			</p>

			<p class="four columns omega">
				<input type="submit" value="<?php _e('Check Availability', 'ci_theme'); ?>" />
			</p>
		</form>
	</div><!-- /booking -->
<?php endif; ?>
