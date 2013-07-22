<?php if(ci_setting('newsletter_action')!=''): ?>
	<div class="newsletter-wrap">
		<div class="newsletter">
			<h4><?php ci_e_setting('newsletter_heading'); ?></h4>
			<p class="newsletter-title"><?php ci_e_setting('newsletter_description'); ?></p>
			<form method="post" action="<?php ci_e_setting('newsletter_action'); ?>">
				<p>
					<input id="<?php ci_e_setting('newsletter_email_id'); ?>" name="<?php ci_e_setting('newsletter_email_name'); ?>" type="text" placeholder="<?php _e('Enter your email','ci_theme'); ?>" />
					<input type="submit" value="<?php _e('Submit', 'ci_theme'); ?>" />
				</p>
				<?php
					$fields = ci_setting('newsletter_hidden_fields');
					if(is_array($fields) and count($fields) > 0)
					{
						for( $i = 0; $i < count($fields); $i+=2 )
						{
							if(empty($fields[$i]))
								continue;
							echo '<input type="hidden" name="'.esc_attr($fields[$i]).'" value="'.esc_attr($fields[$i+1]).'" />';
						}
					}
				?>
			</form>
		</div><!-- /newsletter -->
	</div><!-- /newsletter-wrap -->
<?php endif; ?>
