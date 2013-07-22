<?php
/*
Template Name: Booking form
*/
?>

<?php
	// Sanitize data, or initialize if they don't exist.
	$clientname = isset($_POST['clientname']) ? esc_html(trim($_POST['clientname'])) : '';
	$email = isset($_POST['email']) ? esc_html(trim($_POST['email'])) : '';
	$arrive = isset($_POST['arrive']) ? esc_html(trim($_POST['arrive'])) : '';
	$depart = isset($_POST['depart']) ? esc_html(trim($_POST['depart'])) : '';
	$adults = isset($_POST['adults']) ? intval($_POST['adults']) : '1';
	$children = isset($_POST['children']) ? intval($_POST['children']) : '0';
	$comments = isset($_POST['comments']) ? esc_html(trim($_POST['comments'])) : '';

	if(!empty($_POST['room_select']))
		$room_id = intval($_POST['room_select']);
	elseif(!empty($_GET['room_select']))
		$room_id = intval($_GET['room_select']);
	else
		$room_id = '';
	
	$errorString = '';
	$emailSent = false;
	
	if(isset($_POST['send_booking']))
	{
		// We are here because the form was submitted. Let's validate!

		if(empty($clientname) or mb_strlen($clientname) < 2)
			$errorString .= '<li>'.__('Your name is required', 'ci_theme').'</li>';

		if(empty($email) or !is_email($email))
			$errorString .= '<li>'.__('A valid email is required', 'ci_theme').'</li>';

		if(empty($arrive) or strlen($arrive) != 10)
			$errorString .= '<li>'.__('A complete arrival date is required', 'ci_theme').'</li>';

		if(!checkdate(substr($arrive, 5, 2), substr($arrive, 8, 2), substr($arrive, 0, 4)))
			$errorString .= '<li>'.__('The arrival date must be in the form yyyy/mm/dd', 'ci_theme').'</li>';

		if(empty($depart) or strlen($depart) != 10)
			$errorString .= '<li>'.__('A complete departure date is required', 'ci_theme').'</li>';

		if(!checkdate(substr($depart, 5, 2), substr($depart, 8, 2), substr($depart, 0, 4)))
			$errorString .= '<li>'.__('The departure date must be in the form yyyy/mm/dd', 'ci_theme').'</li>';

		if(empty($adults) or !is_numeric($adults) or intval($adults) < 1)
			$errorString .= '<li>'.__('A number of one or more adults is required', 'ci_theme').'</li>';

		if(!is_numeric($children) or intval($children) < 0)
			$errorString .= '<li>'.__('A number of zero or more children is required', 'ci_theme').'</li>';

		if(empty($room_id) or !is_numeric($room_id) or $room_id < 1)
		{
			$errorString .= '<li>'.__('You must select the room you are interested in', 'ci_theme').'</li>';
		}
		else
		{
			$room = get_post($room_id);
			if($room===null or get_post_type($room)!='room')
			{
				// Someone tried to pass a post id that isn't a room. Kinky.
				$errorString .= '<li>'.__('You must select the room you are interested in', 'ci_theme').'</li>';
			}
		}


		// Alright, lets send the email already!
		if(empty($errorString))
		{
			$mailbody  = __("Name:", 'ci_theme') . " " . $clientname . "\n";
			$mailbody .= __("Email:", 'ci_theme') . " " . $email . "\n";
			$mailbody .= __("Date of arrival:", 'ci_theme') . " " . $arrive . "\n";
			$mailbody .= __("Date of departure:", 'ci_theme') . " " . $depart . "\n";
			$mailbody .= __("Adults:", 'ci_theme') . " " . $adults . "\n";
			$mailbody .= __("Children:", 'ci_theme') . " " . $children . "\n";
			$mailbody .= __("Room:", 'ci_theme') . " " . $room->post_title . "\n";
			$mailbody .= __("Comments:", 'ci_theme') . " " . $comments . "\n";
			$email_address = ci_setting('booking_form_email')!='' ? ci_setting('booking_form_email') : get_option('admin_email');

			// If you want to receive the email using the address of the sender, comment the next $emailSent = ... line
			// and uncomment the one after it.
			// Keep in mind the following comment from the wp_mail() function source:
				/* If we don't have an email from the input headers default to wordpress@$sitename
				* Some hosts will block outgoing mail from this address if it doesn't exist but
				* there's no easy alternative. Defaulting to admin_email might appear to be another
				* option but some hosts may refuse to relay mail from an unknown domain. See
				* http://trac.wordpress.org/ticket/5007.
				*/			
			$emailSent = wp_mail($email_address, ci_setting('logotext').' - '. __('Booking Enquiry', 'ci_theme'), $mailbody);
			//$emailSent = wp_mail($email_address, ci_setting('logotext').' - '. __('Booking Enquiry', 'ci_theme'), $mailbody, 'From: "'.$clientname.'" <'.$email.'>');

		}
		
	}

?>

<?php get_header(); ?>

<div id="main" class="container">
	
	<?php get_template_part('inc_bc'); ?>
	
	<div class="row">
		<section class="content sixteen columns alpha group single">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<article class="group">
					<div class="row">
						
						<h2><?php the_title(); ?></h2>
						<?php ci_e_content(); ?>
	
						<?php if(!empty($errorString)): ?>
							<ul id="formerrors">
								<?php echo $errorString; ?>
							</ul>
						<?php endif; ?>
	
						<?php if($emailSent===true): ?>
							<p id="formsuccess"><?php _e('You booking enquiry has been sent. We will contact you as soon as possible.', 'ci_theme'); ?></p>
						<?php endif; ?>
	
						<?php if(  !isset($_POST['send_booking'])  or  (isset($_POST['send_booking']) and !empty($errorString))  ): ?>
							<form action="<?php the_permalink(); ?>" id="booking-form" method="post" class="group">
								
								<div class="row">
									<p class="eight columns alpha">
										<label for="clientname"><?php _e('Name', 'ci_theme'); ?></label>
										<input name="clientname" type="text" value="<?php echo esc_attr($clientname);?>" />
									</p>
									
									<p class="eight columns omega">
										<label for="email"><?php _e('Email', 'ci_theme'); ?></label>
										<input name="email" type="text" class="email" value="<?php echo esc_attr($email); ?>" />
									</p>
		
									<p class="eight columns alpha">
										<label for="arrive"><?php _e('Arrive', 'ci_theme'); ?></label>
										<input name="arrive" type="text" class="calendar" value="<?php echo esc_attr($arrive); ?>" />
									</p>
									
									<p class="eight columns omega">
										<label for="depart"><?php _e('Depart', 'ci_theme'); ?></label>
										<input name="depart" type="text" class="calendar" value="<?php echo esc_attr($depart); ?>" />
									</p>
									
									<p class="eight columns alpha">
										<label for="adults"><?php _e('Adults', 'ci_theme'); ?></label>
										<input name="adults" type="text" value="<?php echo esc_attr($adults); ?>" />
									</p>
		
									<p class="eight columns omega">
										<label for="children"><?php _e('Children', 'ci_theme'); ?></label>
										<input name="children" type="text" value="<?php echo esc_attr($children); ?>" />
									</p>

									<p class="eight columns alpha omega">
										<label for="room_select"><?php _e('Room', 'ci_theme'); ?></label>
										<?php 
											wp_dropdown_posts(array(
												'id' => 'room_select',
												'post_type' => 'room',
												'selected' => $room_id
											), 'room_select'); 
										?>
									</p>

									<p class="sixteen columns alpha">
										<label for="comments"><?php _e('Comments', 'ci_theme'); ?></label>
										<textarea name="comments" rows="5" cols="50"><?php echo esc_textarea($comments); ?></textarea>
									</p>
	
									<p class="sixteen columns alpha">
										<input type="submit" name="send_booking" value="<?php _e('Send', 'ci_theme'); ?>" />
									</p>
								</div>
							</form>
						<?php endif; ?>	
	
					</div><!-- /row -->
				</article>
			<?php endwhile; endif; ?>
		</section><!-- /content -->
	</div><!-- /row -->
</div><!-- /container -->

<?php get_footer(); ?>
