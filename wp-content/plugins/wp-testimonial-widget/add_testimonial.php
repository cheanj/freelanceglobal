<script type="text/javascript">
jQuery.noConflict();
	jQuery(document).ready(function() {
	});
</script>
<?php
 	global $wpdb;

 	/*wp_register_style( 'swpt_css', plugins_url('css/basic.css', __FILE__) );
 	wp_enqueue_style( 'swpt_css' );*/

 	$strTbl = $wpdb->prefix."swp_testimonial";
	$strPageListingParam ="testimonial";
	$arrWhere = array();
	if(!empty($_POST['description']))
	{
		substr($_POST['description'],0,500);
	}
	
	//check blank data & add record
	if (!empty($_POST['addTesti']))
	{
		//call function add_update_testi to add / edit record
		if($_POST['id'] != "")
		{
			$arrWhere = array("id" => $_POST['id'] );
			unset($_POST['id']);
		}
		//remove submit button & remove blank field
		unset($_POST['addTesti']);
		$arrData = array();
		$arrData = array_filter($_POST);
		$arrMsg = array();
		
		if(count($arrData ) > 0)
		{
			$boolAdded = swpt_add_update_testi($strTbl,$arrData,$arrWhere);	
			if(!empty($arrWhere) && $boolAdded )
			{
				$arrMsg = array('msg' => 'Testimonial Updated.','msgClass' =>'updated');
				
			}
			elseif (empty($arrWhere) && $boolAdded) {
				$arrMsg = array('msg' => 'Testimonial Added.','msgClass' =>'updated');
				
			}
			else
			{
				$arrMsg = array('msg' => 'Error occured while saving your testimonial.','msgClass' =>'error');
			}
		}
	}

	if(isset($_GET['testimonial']))
	{
		$intEditId = $_GET['testimonial'];
		if($intEditId > 0)
		{
			$arrWhere = array("id = $intEditId");	
			$arrTestiData = swpt_edit_data($strTbl,$arrWhere);
		}
	}
?>
<div class="wrap">
 	<div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
 	<?php
		if(isset($intEditId))
		{
			$strLabel = "Edit";
		}
		else
		{
			$strLabel = "Add";
		}
	?>
	<h2> <?php echo $strLabel; ?> Testimonial</h2>
	<?php if(isset($arrMsg) && !empty($arrMsg)){ ?>
		<div class="<?php echo $arrMsg['msgClass']; ?>">
		<p><?php echo $arrMsg['msg']; ?></p>
	</div>
	<?php } 
	?>
	<div id="col-container">
		<div id="col-left">
			<div class="col-wrap">
				<div class="form-wrap">
					<h3>
						<?php if(isset($intEditId)) { ?>
						<a href="?page=add_new" class="add-new-h2">Add New</a>
						<?php } ?>
					</h3>
					<form class="validate" action="" method="post" id="add_testi">
						<div class="form-field form-required">
							<label for="Company">Company Name</label>
							<input type="text" size="40" value="<?php if(isset($arrTestiData->company)) {  echo stripslashes($arrTestiData->company);} ?>" id="company" name="company">
						</div>
						<div class="form-field">
							<label for="Website">Website URL</label>
							<input type="text" size="40" value="<?php if(isset($arrTestiData->website)) {echo $arrTestiData->website;} ?>" id="website" name="website">
						</div>
						<div class="form-field form-required">
							<label for="Description">Testimonial</label>
							<textarea name ='description' cols="51" rows="7" maxlength="500" ><?php if(isset($arrTestiData->description)) {echo stripslashes($arrTestiData->description);} ?></textarea>
							<p>Maximum 500 characters are allowed.</p>
						</div>
						<p class="submit">
							<?php 
								$strBtn = 'Add';
								if(isset($_GET['testimonial']))
								{
									$strBtn = 'Update';
								}
							?>
							<input type="hidden" value="<?php if(isset($_GET['testimonial'])){ echo $arrTestiData->id;} ?>" name="id">
							<input type="submit" value="<?php echo $strBtn; ?>" class="button" id="addTestis" name="addTesti">
							<a href="?page=<?php echo $strPageListingParam; ?>" class="cancel_link">Cancel</a>
						</p>
					</form>
				</div>
			</div>
		</div><!-- /col-left -->
	</div><!-- /col-container -->
</div>