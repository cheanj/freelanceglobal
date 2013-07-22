<?php

/*
Plugin Name: DynamicWP Contact Form
Plugin URI: http://www.dynamicwp.net/plugins/free-plugin-dynamicwp-contact-form/
Description: Contact form, hidden in the left of your page. If  contact form button clicked, the contact form appears with sliding effect.
Author: Reza Erauansyah
Version: 1.0
Author URI: http://www.dynamicwp.net
*/

if (!class_exists("DynamicwpContactForm")) {
	class DynamicwpContactForm {
		var $adminOptionsName = "DynamicwpContactFormAdminOptions";
		function DynamicwpContactForm() { //constructor
			
		}
		function init() {
			$this->getAdminOptions();
		}
		//Returns an array of admin options
		function getAdminOptions() {
			$contactAdminOptions = array(
				'emailaddress' => '',
				'facebook' => '',
				'twitter' => '',
				'linkedin' => '',
				'stumbleupon' => '',
				'tumbler' => '',
				'delicious' => '',
				'flickr' => ''
				);
			$contactOptions = get_option($this->adminOptionsName);
			if (!empty($contactOptions)) {
				foreach ($contactOptions as $key => $option)
					$contactAdminOptions[$key] = $option;
			}				
			update_option($this->adminOptionsName, $contactAdminOptions);
			return $contactAdminOptions;
		}
		
		//Add jquery
		function mycontactpunc(){
			   wp_deregister_script('jquery');
			   wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"), false, '');
	 		  wp_enqueue_script('jquery');
		}
			
		function mycontactstyle(){?>
			<style type="text/css">
				#dwp-contact-button { position: fixed; top:110px; right: 0; width: 43px; outline: none; }
				.dwpcontact-page{ position: fixed; top: 100px; right: -354px; padding: 10px 20px 5px 20px; background: #444; -moz-border-radius: 5px; -khtml-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 314px; color: #FFF; }
				.dwpcontact-page .contact-label{display: block;}
				.dwpcontact-page #nameinput, .dwpcontact-page #emailinput, .dwpcontact-page #subjectinput, .dwpcontact-page #commentinput{width: 300px; padding: 6px; margin: 0 0 8px 0; border: 1px solid #DDD; background: #DFDFDF; color: #222;-moz-border-radius: 3px; -khtml-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px;   box-shadow: inset 5px 5px 5px #ccc;  -moz-box-shadow: inset 5px 5px 5px #ccc;  -webkit-box-shadow: inset 5px 5px 5px #ccc; -khtml-box-shadow: inset 5px 5px 5px #ccc;}
				.dwpcontact-page #commentinput{width: 300px;color: #222;}
				.dwpcontact-page #submitinput{background: #DFDFDF; margin-top: 5px; border: none; padding: 2px 5px; -moz-border-radius: 3px; -khtml-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px;}
				.dwpcontact-page .message-error{ padding: 2px 4px; color: #DA4310; border: 1px solid  #F7A68A; -moz-border-radius: 5px; -khtml-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;background: #FEF4F1; display: block; text-align: center;}
				.dwpcontact-page .message-success{ padding: 2px 4px; color: #8FA943; border: 1px solid  #C2E1AA; -moz-border-radius: 5px; -khtml-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;background: #F5FAF1; display: block	; text-align: center;}
				.dwp-contact-button-wrap{margin-top: 10px; margin-bottom: 10px;}
				.dwp-contact-button-wrap img{float: right; margin-left: 10px;}
				#dwp-contact-button h2 {  background: none repeat scroll 0 0 #E95B0C;color: #FFFFFF; -webkit-transform: rotate(-90deg); }
				#wp-contact-button {transform: rotate(-90deg);}
			</style>	
			
		<?php	}

		//Add contact script
		function mycontactscript(){
			$contactOptions = $this->getAdminOptions();

			$emailaddress = $contactOptions['emailaddress'];
			$facebook = $contactOptions['facebook'];
			$twitter = $contactOptions['twitter'];
			$linkedin = $contactOptions['linkedin'];
			$stumbleupon = $contactOptions['stumbleupon'];
			$tumbler = $contactOptions['tumbler'];
			$flickr = $contactOptions['flickr'];
			$delicious = $contactOptions['delicious'];
 
			$linkss = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
			echo "<script type=\"text/javascript\" charset=\"utf-8\" src=\"".$linkss."jquery.form.js\"></script>";

			echo "
			<script type=\"text/javascript\">

				var echa = jQuery.noConflict();
				echa(document).ready(function() {
					echa(\"#dwp-contact-button\").click(function() {
						echa(\".dwpcontact-page\").animate({ right: parseInt(echa(\".dwpcontact-page\").css(\"right\"),10) == 0 ? -354 :  0 });
						echa(\"#dwp-contact-button\").animate({ right: parseInt(echa(\"#dwp-contact-button\").css(\"right\"),10) == 0 ? 354 :  0 });
						return false;
					});
				});

				 jQuery.noConflict();
				 jQuery(document).ready(function(){
					  jQuery('#contact').ajaxForm(function(data) {
						 if (data==1){
							 jQuery('#success').fadeIn(\"slow\");
							 jQuery('#bademail').fadeOut(\"slow\");
							 jQuery('#badserver').fadeOut(\"slow\");
							 jQuery('#contact').resetForm();
							 }
							 else if (data==2){
								 jQuery('#badserver').fadeIn(\"slow\");
							  }
							 else if (data==3){
								 jQuery('#bademail').fadeIn(\"slow\");
							}
						});
					});
			</script> ";?>
<div class="dwp-contact-wrapper">
			<div id="dwp-contact-button"><h2>Contact Us</h2></div>
			<div class="dwpcontact-page" style="float: right;">
					<label class="contact-label" for="name">Your name </label>
					
					<label class="contact-label" for="email">Your email </label>
					
						<div class="clear"></div>
					<label class="contact-label" for="subject">Subject </label>
						
						<div class="clear"></div>
					<label class="contact-label" for="comment">Your message </label>
					
						<div class="clear"></div>
					
				
				
				<div style="clear: both;"></div>
				
				<span style="font-size: 9px; color: #AAA;">plugin by <a style="color: #FFF;" href="http://www.dynamicwp.net">DynamicWP</a><span>
			</div>
			
<div style="clear: both;"></div>
</div>
		<?php
		}	

		//Prints out the admin page
		function printAdminPage() {
					$contactOptions = $this->getAdminOptions();
										
					if (isset($_POST['update_DynamicwpContactFormSettings'])) { 
						if (isset($_POST['emailaddress'])) {
							$contactOptions['emailaddress'] = $_POST['emailaddress'];
						}
						if (isset($_POST['facebook'])) {
							$contactOptions['facebook'] = $_POST['facebook'];
						}
						if (isset($_POST['twitter'])) {
							$contactOptions['twitter'] = $_POST['twitter'];
						}
						if (isset($_POST['linkedin'])) {
							$contactOptions['linkedin'] = $_POST['linkedin'];
						}
						if (isset($_POST['stumbleupon'])) {
							$contactOptions['stumbleupon'] = $_POST['stumbleupon'];
						}
						if (isset($_POST['tumbler'])) {
							$contactOptions['tumbler'] = $_POST['tumbler'];
						}
						if (isset($_POST['tumbler'])) {
							$contactOptions['tumbler'] = $_POST['tumbler'];
						}
						if (isset($_POST['flickr'])) {
							$contactOptions['flickr'] = $_POST['flickr'];
						}
						if (isset($_POST['delicious'])) {
							$contactOptions['delicious'] = $_POST['delicious'];
						}
						
						update_option($this->adminOptionsName, $contactOptions);
						
						?>
						
						<div class="updated"><p><strong><?php _e("Settings Updated.", "DynamicwpContactForm");?></strong></p></div>
						
						<?php } ?>
						<div class="wrap">
							<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
							<h2><a href="http://www.dynamicwp.net">DynamicWP</a> Contact Form</h2>
							
							<div style="width: 50%; ">
								<h2>Email Address</h2>
								<b><label for="dwpemailaddress">email address : </label></b><br />
								<input type="text" id="dwpemailaddress" name="emailaddress" value="<?php echo $contactOptions['emailaddress'];?>" style="width: 50%; " /><br />
								<small>enter email address, where you received massage from contact form</small>

								<br />
								<hr />
								<br />
								<h2>Social Button</h2>
								<b><label for="dwptwitter">twitter link : </label></b><br />
								<input type="text" id="dwptwitter" name="twitter" value="<?php echo $contactOptions['twitter'];?>" style="width: 50%; " /><br />
								<small>Enter link to your twitter account account  here (use full link, with http://) </small>
				
								<br />

								<b><label for="dwpfacebook">facebook: </label></b><br />
								<input type="text" id="dwpfacebook" name="facebook" value="<?php echo $contactOptions['facebook'];?>" style="width: 50%; " /><br />
								<small>Enter link to your facebook account(use full link, with http://)</small>
								<br />
								<b><label for="dwplinkedin">linkedin : </label></b><br />
								<input type="text" name="linkedin" id="dwplinkedin" value="<?php echo $contactOptions['linkedin'];?>" style="width: 50%;" /><br />
								<small>Enter link to your linkedin account. </small>

								<br />

								<b><label for="dwpstumbleupon">StumbleUpon: </label></b><br />
								<input type="text" id="dwpstumbleupon" name="stumbleupon" value="<?php echo $contactOptions['stumbleupon'];?>" style="width: 50%;" /><br />
								<small>Enter link to your stumbleupon account</small>

								<br />
								<b><label for="dwptumbler">Tumbler : </label></b><br />
								<input type="text" id="dwptumbler" name="tumbler" value="<?php echo $contactOptions['tumbler'];?>" style="width: 50%;" /><br />
								<small>Enter link to your tumbler account</small>
								<br />

								<br />
								<b><label for="dwpflickr">Flickr : </label></b><br />
								<input type="text" id="dwpflickr" name="flickr" value="<?php echo $contactOptions['flickr'];?>" style="width: 50%;" /><br />
								<small>Enter link to your Flickr account</small>
								<br />

								<br />
								<b><label for="dwpdelicious">Delicious : </label></b><br />
								<input type="text" id="dwpdelicious" name="delicious" value="<?php echo $contactOptions['delicious'];?>" style="width: 50%;" /><br />
								<small>Enter link to your delicious account</small>
								<br />

							</div>

							<div style="clear:both;"></div>
							
							<div class="submit">
								<input type="submit" name="update_DynamicwpContactFormSettings" value="<?php _e('Update Settings', 'DynamicwpContactForm') ?>" />	
							</div>
							</form>
						</div>
					<?php
				}//End function printAdminPage()
	
	}

} //End Class DynamicwpContactForm

if (class_exists("DynamicwpContactForm")) {
	$contact_plugin = new DynamicwpContactForm();
}

//Initialize the admin panel
if (!function_exists("DynamicwpContactForm_ap")) {
	function DynamicwpContactForm_ap() {
		global $contact_plugin;
		if (!isset($contact_plugin)) {
			return;
		}
		if (function_exists('add_options_page')) {
	add_options_page('<b style="color: #C50606;">DynamicWP Contact Form</b>', '<b style="color: #C50606;">DynamicWP Contact Form</b>', 9, basename(__FILE__), array(&$contact_plugin, 'printAdminPage'));
		}
	}	
}

//Actions and Filters	
if (isset($contact_plugin)) {
	//Actions
	add_action('admin_menu', 'DynamicwpContactForm_ap');
	add_action('activate_contact/contact.php',  array(&$contact_plugin, 'init'));
	
	if(!is_admin()){
	add_action('init', array(&$contact_plugin, 'mycontactpunc')); 
	add_action('wp_footer', array(&$contact_plugin, 'mycontactscript'));
	add_action('wp_head', array(&$contact_plugin, 'mycontactstyle'));
	}
}


?>
