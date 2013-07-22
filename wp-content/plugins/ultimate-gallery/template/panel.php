<style>

.addwindow {
	
	position:relative:
	border: 2px;
	display: none;
	
}
.ultimateitemfull<?php echo $id; ?> {
	
	margin: 10px;
	padding: 10px;
	border: 2px solid #555;
	<?php
	if($_POST['id']!=$id) {
		echo 'display: none;';
	}
	?>
	
}


.ultimatedelete<?php echo $id; ?>{
	
	
	display: none;
	
}
.edititem {
	
	position:relative:
	border: 2px;
	display: none;
	margin: 8px;
	line-height:250%;
	padding: 8px;
	background-color:#CCC;
	
}
</style>
    <script type="text/javascript">

        jQuery(document).ready( function () { 
		
		
		var uploadID<?php echo $id; ?> = ''; /*setup the var in a global scope*/

jQuery('.upload-button<?php echo $id; ?>').click(function() {
	
	

//uploadID = jQuery(this).prev('input');
uploadID<?php echo $id; ?> = jQuery(this).prev('input');


window.send_to_editor = function(html) {

var textt=html;


if(textt.search("img")!=-1) imgurl = jQuery('img',html).attr('src');

else {

	imgurl = jQuery(html).attr('href');

}

uploadID<?php echo $id; ?>.val(imgurl)
tb_remove();
}


tb_show('', 'media-upload.php?type=image&amp;amp;amp;amp;TB_iframe=true&uploadID<?php echo $id; ?>=' + uploadID<?php echo $id; ?>);

return false;
});



		
		
          
	jQuery('.editultimate<?php echo $id; ?>').click(function() {
		
		
	if(jQuery('.ultimateitemfull<?php echo $id; ?>').css("display")=="none") jQuery('.ultimateitemfull<?php echo $id; ?>').show();
	else jQuery('.ultimateitemfull<?php echo $id; ?>').css("display", "none")
	
	
	
	return false;
	
	
})
	

	jQuery('.deletebuton<?php echo $id; ?>').click(function() {
		
		
		
			if(jQuery('.ultimatedelete<?php echo $id; ?>').css("display")=="none") jQuery('.ultimatedelete<?php echo $id; ?>').show();
	else jQuery('.ultimatedelete<?php echo $id; ?>').css("display", "none")
		

	
	
	
	return false;
	
	
})	
		 
	jQuery('.additem').click(function() {
		
		
		
	//jQuery('.widget-wp_ultimate-__i__-savewidget').trigger('click');
	jQuery('input[name=operation]').val('1');
	jQuery('.addwindow').show();
	
	
	
	return false;
	
	
})

	jQuery('.deleteitem').click(function() {
		
		
		
	//jQuery('.widget-wp_ultimate-__i__-savewidget').trigger('click');
	jQuery('input[name=operation]').val('2');
	jQuery('.addwindow').show();
	
	
	
	return false;
	
	
})

	jQuery('.cancel').click(function() {
		
		
		
	//jQuery('.widget-wp_ultimate-__i__-savewidget').trigger('click');
	jQuery('input[name=operation]').val('0');
	jQuery('.addwindow').hide();
	
	
	
	return false;
	
	
})

jQuery('.<?php echo $id; ?>editbutton').click(function() {
		
		
		
	//jQuery('.widget-wp_ultimate-__i__-savewidget').trigger('click');
	

	if(jQuery('#<?php echo $id; ?>edit'+jQuery(this).attr("rel")).css("display")=="none") { 
		
		jQuery('#<?php echo $id; ?>edit'+jQuery(this).attr("rel")).show()
		jQuery(this).text("-")
	}
	else { 
		jQuery(this).text(' Edit ')
		jQuery('#<?php echo $id; ?>edit'+jQuery(this).attr("rel")).css("display", "none")
	}
	return false;
	
	
})

		  
        });

    </script>

	  <legend><strong>Ultimate <?php echo $id; ?>.</strong> To insert this gallery write in your pages or your posts the code below: <strong>[ultimate <?php echo $id; ?> /]</strong>. You can also insert the gallery using the widget "ultimate video".  <button class="editultimate<?php echo $id; ?>"> Edit Ultimate <?php echo $id; ?></button></legend> 



<div class="ultimateitemfull<?php echo $id; ?>"> 
	<form method="post" action="">
		<fieldset>
<label >Title: </label><input id="stitle<?php echo $id; ?>" name="stitle<?php echo $id; ?>" type="text" value="<?php echo $title; ?>" />
              <hr />
             
              <input name="operation" type="hidden" id="operation" value="0" />
               <input name="itemselect<?php echo $id; ?>" type="hidden" id="itemselect<?php echo $id; ?>" value="" />
<h2>VIDEOS:</h2>               
            <button class="additem">Add Video</button> <button class="deleteitem">Delete Videos</button> <input type='submit' name='' value='Save' class="button-primary" />
            <div class="addwindow">
             <hr />
           <input type='submit' name='' value='OK' /><button class="cancel">Cancel</button>
            
            </div>
             <hr />
            <ul>
            <?php
			
			// items
			$cont=0;
			if($values!="") {
				$items=explode("kh6gfd57hgg", $values);
				$cont=1;
				foreach ($items as &$value) {
					if(count($items)>$cont) {
					$item=explode("t6r4nd", $value);
					
					 
					 echo '<li><input name="item'.$cont.'" type="checkbox" value="hide" /><img src="'.$item[2].'" width="60px"/><input name="title'.$cont.'" type="text" value="'.$item[0].'" /><button class="'.$id.'editbutton" rel="'.$cont.'"> Edit </button>
					 
					 <div id="'.$id.'edit'.$cont.'" class="edititem">
					
					
					Video Url(Youtube or flv files):<br/>
					 ';
					 
					
					echo '<input name="video'.$cont.'" type="text" value="'.$item[4].'" class="upload'.$id.'" size="70" /> 
					 <input class="upload-button'.$id.'" name="wsl-image-add" type="button" value="SELECT VIDEO FILE(only flv files)" /><br/>
					  Image thumbnail:<br/>
					 <input type="text" name="image'.$cont.'" value="'.$item[2].'" class="upload'.$id.'" size="70"/>
					 <input class="upload-button'.$id.'" name="wsl-image-add" type="button" value="Change thumbnail" /><br/>
					 Description:<br/><textarea name="description'.$cont.'" rows="5" cols="80" id="description'.$cont.'" >'.$item[1].'</textarea><br/>
					
					  Active: <input name="link'.$cont.'" type="checkbox" id="link'.$cont.'" value="1"';
					 
					 if($item[3]=="1") echo 'checked="checked"';
					 
					 echo ' /><br/>
					 ORDER: <input name="order'.$cont.'" type="text" value="'.$cont.'" size="4"/><br/>
					  <hr />
					  <input type=\'submit\' name=\'\' value=\'Save\' class="button-primary" />
					 </div>
					 </li>';
					 $cont++;
					}
					 
				}
			}
			 $cont--;
			echo '</ul><input class="widefat" name="total" type="hidden" id="total" value="'.$cont.'" />';
			
	
			
			
			?>
 
            <hr />
<h2>CONFIGURATION:</h2>            


<h3>PLUGIN SIZES</h3>
           <label>Plugin width(Number with % or px): </label> <input type='text' id='width<?php echo $id; ?>'  name='width<?php echo $id; ?>'  value='<?php echo $width; ?>' size="6"/>
            
       		<label>Plugin height: </label> <input type='text' id='height<?php echo $id; ?>'  name='height<?php echo $id; ?>'  value='<?php echo $height; ?>' size="6"/>
            <label>Plugin border: </label> <input type='text' id='border<?php echo $id; ?>'  name='border<?php echo $id; ?>'  value='<?php echo $border; ?>' size="6"/>
            <label>Plugin round: </label> 
            
            
             <select name="round<?php echo $id; ?>" id="round<?php echo $id; ?>">
                <option value="hide" <?php if($round=='hide') echo ' selected="selected"'; ?>>Show</option>
                <option value="checked" <?php if($round!='hide') echo ' selected="selected"'; ?>>Hide</option>
              </select>
            <br/>  
<h3>THUMBNAILS</h3>

<label> % Height reserved for the thumbnails into the plugin. The remaining space will be used for the video: </label> <input type='text' id='number_thumbnails<?php echo $id; ?>'  name='number_thumbnails<?php echo $id; ?>'  value='<?php echo $number_thumbnails; ?>' size="6"/><br/><br/>

            <label>Thumbnail columns: </label> <input type='text' id='twidth<?php echo $id; ?>'  name='twidth<?php echo $id; ?>'  value='<?php echo $twidth; ?>' size="6"/>
            <input type='hidden' id='theight<?php echo $id; ?>'  name='theight<?php echo $id; ?>'  value='<?php echo $theight; ?>' size="6"/>


                   <label>Thumbnail text design options</label>
			      <select name="sizethumbnail<?php echo $id; ?>" id="sizethumbnail<?php echo $id; ?>">
			        <option value="0" <?php if($sizethumbnail==0 || $skin=="") echo ' selected="selected"'; ?>>All width</option>
			        <option value="1" <?php if($sizethumbnail==1) echo ' selected="selected"'; ?>>1/2 width, right</option>
			        <option value="2" <?php if($sizethumbnail==2) echo ' selected="selected"'; ?>>1/2 width, left</option>
                    <option value="3" <?php if($sizethumbnail==3) echo ' selected="selected"'; ?>>1/2 height</option>

		          </select>           
                  
                  
                    <label>Image thumbnail design options</label>
			      <select name="op1<?php echo $id; ?>" id="op1<?php echo $id; ?>">
			        <option value="0" <?php if($op1==0 || $op1=="") echo ' selected="selected"'; ?>>All width, all height</option>
                     <option value="3" <?php if($op1==3) echo ' selected="selected"'; ?>>1/2 height</option>
			        <option value="1" <?php if($op1==1) echo ' selected="selected"'; ?>>1/2 width, left</option>
                     <option value="2" <?php if($op1==2) echo ' selected="selected"'; ?>>1/2 width, right</option>
			       

		          </select>                        
            <br/>  
            
            
<h3>CONFIGURATION</h3>






<input type='hidden' id='thumbnail_round<?php echo $id; ?>'  name='thumbnail_round<?php echo $id; ?>'  value='<?php echo $thumbnail_round; ?>'/>


			      <label>Autoplay?</label>
			      <select name="sizetitle<?php echo $id; ?>" id="sizetitle<?php echo $id; ?>">
			        <option value="1" <?php if($sizetitle==1) echo ' selected="selected"'; ?>>On</option>
			        <option value="0" <?php if($sizetitle!=1) echo ' selected="selected"'; ?>>Off</option>
		          </select>
                  




<input type='hidden' id='sizedescription<?php echo $id; ?>'  name='sizedescription<?php echo $id; ?>'  value='<?php echo $sizedescription; ?>'/>

           
        



                    <label>Text align</label>
			      <select name="op2<?php echo $id; ?>" id="op2<?php echo $id; ?>">
			        <option value="0" <?php if($op2==0 || $op2=="") echo ' selected="selected"'; ?>>Center</option>
                    
			        <option value="1" <?php if($op2==1) echo ' selected="selected"'; ?>>Left</option>
                     <option value="2" <?php if($op2==2) echo ' selected="selected"'; ?>>Right</option>
                     <option value="3" <?php if($op2==3) echo ' selected="selected"'; ?>>Justify</option>
			       

		          </select> 

<input type='hidden' id='op3<?php echo $id; ?>'  name='op3<?php echo $id; ?>'  value='<?php echo $op3; ?>'/>

<input type='hidden' id='tborder<?php echo $id; ?>'  name='tborder<?php echo $id; ?>'  value='<?php echo $tborder; ?>'/>
<input type='hidden' id='font<?php echo $id; ?>'  name='font<?php echo $id; ?>'  value='<?php echo $font; ?>'/>
<input type='hidden' value="<?php echo $color1; ?>" name="color1<?php echo $id; ?>" id="color1<?php echo $id; ?>" size="7" />
<input type='hidden' id='color2<?php echo $id; ?>'  name='color2<?php echo $id; ?>'  value='<?php echo $color2; ?>' size="7"/>
<input type='hidden' id='color3<?php echo $id; ?>'  name='color3<?php echo $id; ?>'  value='<?php echo $color3; ?>' size="7" />
<input type='hidden' id='time<?php echo $id; ?>'  name='time<?php echo $id; ?>'  value='<?php echo $time; ?>' size="7" />
<input type='hidden' id='op4<?php echo $id; ?>'  name='op4<?php echo $id; ?>'  value='<?php echo $op4; ?>' size="7" />
      <br/>  <br/>      

<input name="id" type="hidden" id="id" value="<?php echo $id; ?>" /></td>
	<input type='submit' name='' value='SAVE ultimate' class="button-primary"/>
		 
      </fieldset>
	</form>		 <br/>
    <hr />
  <form method="post" action="">
	  <input name="borrar" type="hidden" id="borrar" value="<?php echo $id; ?>">
      <button class="deletebuton<?php echo $id; ?>">Delete ultimate</button>
      <div class="ultimatedelete<?php echo $id; ?>">
      <button class="deletebuton<?php echo $id; ?>">CANCEL</button>
     <input type='submit' name='' value='OK' />
     </div>
    </form>
  </div>
