<!-- Start of Post Wrap -->

<div class="eight block relative columns alpha">
	<!-- This is the output of the post TITLE -->
	
	<div class="<?php the_title();?>-icon">
		<h2><?php the_title(); ?></h2>
	</div>
<hr/>
	
	<!-- This is the output of the EXCERPT -->
	<div class="entry-summary">
		<div class="entry-txt-cont">
		<?php global $more;
		$more = 0;
		?>
		<?php the_content('Read More'); ?>
		<?php if ( get_post_meta( get_the_ID(), 'ic_label', true ) ) : ?>
		</div>

		<h2 class="italic-head"><?php echo get_post_meta( get_the_ID(), 'ic_label', true ) ?></h2>
		<?php endif; ?>		
		<?php //the_post_thumbnail('ci_blog_featured', array('class' => 'scale-with-grid')); ?>
		
		<?php if ( get_post_meta( get_the_ID(), 'ic_videos', true ) ) : ?>
	        <div class="videos">
				<div style="display:none;margin-left:-15px;" class="html5gallery" data-skin="gallery" data-width="450" data-height="200">
				<?php	

						//$video = get_post_meta(get_the_ID(), 'ic_videos', true);
						//$v_url = explode('vimeo=', $video);	                           		
						//$video_source = 'http://player.vimeo.com/video/';					
						//foreach ($v_url as $key => $value) { 	
						//$vid = trim($value);	
							
						//$xml = simplexml_load_file("http://vimeo.com/api/v2/video/".$vid.".xml");
						//$xml = $xml->video;
					
						//$xml_pic = $xml->thumbnail_small;	

						//	if($value != ''){								
				?>
  					 <!--<a href="<?php echo $video_source.$value?>?title=1&amp;byline=0&amp;portrait=0&amp;autoplay=0"><img src="<?php echo $xml_pic?>" alt="Vimeo Video"></a> -->
				<?php
						//	}
						//}

							
					?>
				

					
			</div>
		</div>

		<div class="video_description">
			<?php if ( get_post_meta( get_the_ID(), 'ic_test_video', true ) ) : ?>
				<h3><?php echo get_post_meta( get_the_ID(), 'ic_test_video', true ) ?></h3>
			<?php endif; ?>
		
			<?php if ( get_post_meta( get_the_ID(), 'ic_video_description', true ) ) : ?>
                
					<?php echo get_post_meta( get_the_ID(), 'ic_video_description', true ) ?>
				
		<?php endif; ?>
		</div>
		<?php endif; ?>
                 
		
<?php if ( get_post_meta( get_the_ID(), 'testimony', true ) ) : ?>	

<?php dynamic_sidebar('Testimonials'); ?>

<?php endif; ?>
		
	</div>
	<div class="clear"></div>

</div>

<!-- // End of Post Wrap -->
