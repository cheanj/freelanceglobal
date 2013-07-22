<?php
/*
Plugin Name: ULTIMATE VIDEO GALLERY
Plugin URI: http://www.extendyourweb.com/wordpress/ultimate-video-gallery/
Description: Create easily a gallery of videos for your site with youtube and flv videos. Extremely quickly to use, add the url of your videos.
Version: 1.3
Author: Webpsilon S.C.P.
Author URI: http://www.extendyourweb.com/wordpress/

Copyright 2012  Webpsilon S.C.P.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
*/

function getYTidultimate($ytURL) {
#http://youtu.be/VXPoJAyeF8k
 
#
$ytvIDlen = 11; // This is the length of YouTube's video IDs
#
 
#
// The ID string starts after "v=", which is usually right after
#
// "youtube.com/watch?" in the URL
#
$idStarts = strpos($ytURL, "?v=");
#
 
#
// In case the "v=" is NOT right after the "?" (not likely, but I like to keep my
#
// bases covered), it will be after an "&":
#
if($idStarts === FALSE)
#
$idStarts = strpos($ytURL, "&v=");

if($idStarts === FALSE)
$idStarts = strpos($ytURL, "be/");

#
// If still FALSE, URL doesn't have a vid ID
#
if($idStarts === FALSE)
#
die("YouTube video ID not found. Please double-check your URL.");
#
 
#
// Offset the start location to match the beginning of the ID string
#
$idStarts +=3;
#
 
#
// Get the ID string and return it
#
$ytvID = substr($ytURL, $idStarts, $ytvIDlen);
#
 
#
return $ytvID;
#
 
#
}



function ultimate_enqueue_scripts() { 

  

 }



function ultimate($content){
	$content = preg_replace_callback("/\[ultimate ([^]]*)\/\]/i", "ultimate_render2", $content);
	return $content;
	
}

function ultimate_render2($tag_string){
	return ultimate_render($tag_string, "");
}

function ultimate_render($tag_string, $instance){
$contador=rand(9, 9999999);

$widthloading="48"; // Set if change loading image

global $wpdb; 	
$table_name = $wpdb->prefix . "ultimate";


if(isset($tag_string[1])) {
	
	
	
	$auxi1=str_replace(" ", "", $tag_string[1]);
	
	}

else {
	
	
	
	$auxi1 = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
	
	}


	
	
	
	$myrows = $wpdb->get_results( "SELECT * FROM $table_name WHERE id = ".$auxi1.";" );

	if(count($myrows)<1) $myrows = $wpdb->get_results( "SELECT * FROM $table_name;" );
	
	$conta=0;
$id= $myrows[$conta]->id;
	$title = $myrows[$conta]->title;
		$width = $myrows[$conta]->width;
$height = $myrows[$conta]->height;
$values =$myrows[$conta]->ivalues;

$twidth = $myrows[$conta]->width_thumbnail;

$theight = $myrows[$conta]->height_thumbnail;

$number_thumbnails = $myrows[$conta]->number_thumbnails;



$total = $myrows[$conta]->number_thumbnails;

$border = $myrows[$conta]->border;
$round = $myrows[$conta]->round;
$tborder = $myrows[$conta]->thumbnail_border;
$thumbnail_round = $myrows[$conta]->thumbnail_round;

$sizetitle = $myrows[$conta]->sizetitle;
$sizedescription = $myrows[$conta]->sizedescription;
$sizethumbnail = $myrows[$conta]->sizethumbnail;
$font = $myrows[$conta]->font;
$color1 = $myrows[$conta]->color1;
$color2 = $myrows[$conta]->color2;

$color3 = $myrows[$conta]->color3;

$time = $myrows[$conta]->time;

$animation = $myrows[$conta]->animation;

$mode = $myrows[$conta]->mode;

$op1 = $myrows[$conta]->op1;
$op2 = $myrows[$conta]->op2;
$op3 = $myrows[$conta]->op3;
$op4 = $myrows[$conta]->op4;
$op5 = $myrows[$conta]->op5;


/*

else {
$width = empty($instance['width']) ? '&nbsp;' : apply_filters('widget_width', $instance['width']);
$height = empty($instance['height']) ? '&nbsp;' : apply_filters('widget_height', $instance['height']);
$values = empty($instance['values']) ? '&nbsp;' : apply_filters('widget_values', $instance['values']);
$twidth = empty($instance['width_thumbnail']) ? '&nbsp;' : apply_filters('widget_width_thumbnail', $instance['width_thumbnail']);
$theight = empty($instance['height_thumbnail']) ? '&nbsp;' : apply_filters('widget_height_thumbnail', $instance['height_thumbnail']);


$total = empty($instance['number_thumbnails']) ? '&nbsp;' : apply_filters('widget_number_thumbnails', $instance['number_thumbnails']);

$border = empty($instance['border']) ? '&nbsp;' : apply_filters('widget_border', $instance['border']);
$round = empty($instance['round']) ? '&nbsp;' : apply_filters('widget_round', $instance['round']);
$tborder = empty($instance['thumbnail_border']) ? '&nbsp;' : apply_filters('widget_thumbnail_border', $instance['thumbnail_border']);
$thumbnail_round = empty($instance['thumbnail_round']) ? '&nbsp;' : apply_filters('widget_thumbnail_round', $instance['thumbnail_round']);

$sizetitle = empty($instance['sizetitle']) ? '&nbsp;' : apply_filters('widget_sizetitle', $instance['sizetitle']);
$sizedescription = empty($instance['sizedescription']) ? '&nbsp;' : apply_filters('widget_sizedescription', $instance['sizedescription']);
$sizethumbnail = empty($instance['sizethumbnail']) ? '&nbsp;' : apply_filters('widget_sizethumbnail', $instance['sizethumbnail']);
$font = empty($instance['font']) ? '&nbsp;' : apply_filters('widget_font', $instance['font']);
$color1 = empty($instance['color1']) ? '&nbsp;' : apply_filters('widget_color1', $instance['color1']);
$color2 = empty($instance['color2']) ? '&nbsp;' : apply_filters('widget_color2', $instance['color2']);
$color3 = empty($instance['color3']) ? '&nbsp;' : apply_filters('widget_color3', $instance['color3']);

$time = empty($instance['time']) ? '&nbsp;' : apply_filters('widget_time', $instance['time']);
$animation = empty($instance['animation']) ? '&nbsp;' : apply_filters('widget_animation', $instance['animation']);
$mode = empty($instance['mode']) ? '&nbsp;' : apply_filters('widget_mode', $instance['mode']);


}

*/
$site_url = get_option( 'siteurl' );
$firstiultimateimage="";
$textovid="";
$mobpag=0;

$heightimage=round(((100-$number_thumbnails)*$height)/100);
$heightthumb=round((($number_thumbnails)*$height)/100);
$heightimage-=50;
$mobrow=0;
$mobcolumn=0;
$textovidmob="";
$firstimage="";
$firstlink="";
$firsttitle="";

  $values=str_replace('"', '', $values);

$items_ultimate="";
$cont=0;
			if($values!="") {
				$items=explode("kh6gfd57hgg", $values);
				$cont=1;
				foreach ($items as &$value) {
					if(count($items)>$cont) {
					$item=explode("t6r4nd", $value);
					
					$auxivideo="";
					$auxivideourl="";

					if($item[4]!="") $auxivideo=$item[4];
					$auxivideourl=$auxivideo;
					if($auxivideo!="") {
						$auxtipo=1;
						if(strstr($auxivideo, "http")) {
							if(strpos($auxivideo, "youtu")>0 || strpos($auxivideo, "vimeo")>0) {
								$auxivideo=getYTidultimate($auxivideo);
								$auxtipo=2;
								if(strpos($auxivideo, "vimeo")>0) $auxtipo=4;
								
							}
							else $auxtipo=1;
						}
						else $auxtipo=2;
						
				
					}
					$imageultimate="";
					if($item[2]!="") $imageultimate=$item[2];
					
					if($imageultimate=="" && eregi("youtu", $item[4])) {
						
						
						$imageultimate='http://ytimg.googleusercontent.com/vi/'.getYTidultimate($item[4]).'/hqdefault.jpg';
					
					
					}
					if($auxivideo!="" && $item[3]==1) {
						
						
					
						$textovid.='&amp;video'.($cont-1).'='.$auxivideo.'&amp;image'.($cont-1).'='.$imageultimate.'&amp;title'.($cont-1).'='.$item[0].'&amp;tipo'.($cont-1).'='.$auxtipo.'&amp;description'.($cont-1).'='.$item[1].'&amp;date'.($cont-1).'='.$item[8];
						
						if($firstimage=="") $firstimage=$imageultimate;
						if($firstlink=="") $firstlink=$auxivideourl;
						if($firsttitle=="") $firsttitle=$item[0];
						if($mobcolumn==0 && $mobrow==0) {
							
							 if($mobpag==0) $textovidmob.='<div id="ulpag'.$id.'-'.$mobpag.'" name="ulpag'.$id.'-'.$mobpag.'" ><table width="100%" height="'.$heighthumb.'px">';
							 else $textovidmob.='<div id="ulpag'.$id.'-'.$mobpag.'" name="ulpag'.$id.'-'.$mobpag.'" style="display:none"><table width="100%" height="'.$heighthumb.'px">';
						}
						
						if($mobcolumn==0)  $textovidmob.='<tr>';
						
						$textovidmob.='<td width="'.round(100/$twidth).'%" height="'.round($heightthumb/$theight).'px" onclick="changevideo'.$id.'(\''.$imageultimate.'\', \''.$auxivideourl.'\', \''.$item[0].'\');" style="background: url('.$imageultimate.') no-repeat center; text-align:center; padding:4px;vertical-align:middle;color: #'.$color3.'; font-size:'.($tborder).'px;">'.$item[0].'<br/><img src="'.plugins_url('images/play.png', __FILE__).'" /></td>';
											
						 $cont++;
						 $mobcolumn++;
						 
						 if($mobcolumn>=$twidth) {
							 $mobcolumn=0;
							 $mobrow++;
							 $textovidmob.='</tr>';
						 }
						 if($mobrow>=$theight) {
							 $mobrow=0;
							 $mobpag++;
							 $textovidmob.='</table></div>';
						 }
						}
					}
					 
				}
			}


 $cont--;
 
 if($mobcolumn>0) {
	 
	 while($mobcolumn<$twidth) {
		 
		 $textovidmob.='<td></td>';
		 $mobcolumn++;
	 }
	  $textovidmob.='</tr>';
 }
 
 if($mobrow<$theight) {
							
							 $textovidmob.='</table></div>';
							 $mobpag++;
		}
  

$cantidad=$cont;

$width_thumbs_total=($twidth+1)*($cantidad+1);

$width_windowultimate=round($width-(2*$border));

$widthzone=round($total*($twidth+1));
$paggingtop=10;

$timgwidth="";
//$timgwidth="width: ".($twidth*2)."px;";



if($round!="hide") $border=0;

$texto.='title='.$titles.'&amp;controls='.$sizedescription.'&amp;color1='.str_replace("#", "", $color1).'&amp;color2='.str_replace("#", "", $color2).'&amp;autoplay='.$sizetitle.'&amp;skin='.$thumbnail_round.'&amp;youtube=&amp;columns='.$twidth.'&amp;rows='.$theight.'&amp;tumb='.$number_thumbnails.'&amp;round='.$border.$textovid.'&amp;cantidad='.$cantidad.'&amp;imagealign='.$sizethumbnail.'&amp;color3='.str_replace("#", "", $color3).'&amp;sizetitle='.$tborder.'&amp;sizedescription='.$font.'&amp;color4='.str_replace("#", "", $time).'&amp;op1='.$op1.'&amp;op2='.$op2.'&amp;op3='.$op3.'&amp;op4='.$op4.'&amp;';


$urlpflash=plugins_url('ultimate.swf', __FILE__);

$varaux="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000";

 require_once 'Mobile_Detect.php';
 $detect = new Mobile_Detect;
 $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');


if($deviceType=='phone' || $deviceType=='tablet') {
	
	$output='
	
	<script>
	
	var pag=0;
	var anpag=0;
	var maxpag='.$mobpag.';
	
	function changevideo'.$id.'(urli, link, title) {
		
		jQuery("#mainvideomob'.$id.'").css("backgroundImage", "url("+urli+")");
		jQuery("#mainlinkmob'.$id.'").attr("href",link);
		jQuery("#maintitlemob'.$id.'").html(title);
	}
	
	
	function changepag'.$id.'(pasb) {
		
		if(pasb==1) pag++;
		else pag--;
		if(pag>=maxpag) pag=0;
		if(pag<0) pag=maxpag-1;
		jQuery("#ulpag'.$id.'-"+anpag).css("display", "none");
		jQuery("#ulpag'.$id.'-"+pag).show();
	
		anpag=pag;
	}
	
	
	</script>

	<div style="width:'.$width.'; height:'.$height.'px;margin:0px;overflow:hidden;background-color:#'.$color1.';" id="ultimate'.$id.'-'.$contador.'">
	
	
	<table width="100%" height="'.$heightimage.'px" style=" margin:0px;">
	<tr><td id="mainvideomob'.$id.'" name="mainvideomob'.$id.'" style="background: url('.$firstimage.') no-repeat center; text-align:center; vertical-align:middle;">
	
	<a href="'.$firstlink.'" id="mainlinkmob'.$id.'" name="mainlinkmob'.$id.'" target="_blank">
	
	<img src="'.plugins_url('images/play2.png', __FILE__).'" height="'.round($heightimage/2).'px" />
	</a>';
	
	
	if($mobpag>1) $output.='<img src="'.plugins_url('images/next2.png', __FILE__).'" height="'.round($heightimage/2).'px" style="position:absolute; right:0;z-index:999;" onclick="changepag'.$id.'(1);" />
	<img src="'.plugins_url('images/prev2.png', __FILE__).'" height="'.round($heightimage/2).'px" style="position:absolute; left:0;z-index:999;" onclick="changepag'.$id.'(0);" />';
	
	
	
	$output.='</td></tr></table>
<div id="maintitlemob'.$id.'" name="maintitlemob'.$id.'" style="height:50px; width:100%; color:#'.$color3.'; font-size:'.($tborder*2).'px; text-align: center;">'.$firsttitle.'</div>
	<div id="mainthumbmob'.$id.'" name="mainthumbmob'.$id.'" style="height:'.$heightthumb.'px;overflow:hidden;">
  '.$textovidmob.'
  </div>
</div>
';
	
	
}


else $output='


<object id="flashcontent" data="'.$urlpflash.'" width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" >
 <param name="movie" value="'.$urlpflash.'" />
 <param name="quality" value="high" />
 <param name="wmode" value="transparent" />
 <param name="allowFullScreen" value="true" />
 <param name="flashvars" value="'.$texto.'" />
 
  <!--[if !IE]>-->
  <object type="application/x-shockwave-flash" data="'.$urlpflash.'" width="'.$width.'" height="'.$height.'">
  
    <p>
      Require Flash player
    </p>
      
  <!--[if !IE]>-->
  </object>
  <!--<![endif]-->
 
</object>
';
	
	if(isset($tag_string[1])) return $output;
	else echo $output;
}


function add_header_ultimate() {
$site_url = get_option( 'siteurl' );
 wp_enqueue_script('jquery');

}

class wp_ultimate extends WP_Widget {
	function wp_ultimate() {
		$widget_ops = array('classname' => 'wp_ultimate', 'description' => 'Amazing widget for create video galleries. Very easy to use. Select the ultimate gallery ID.' );
		$this->WP_Widget('wp_ultimate', 'ULTIMATE VIDEO', $widget_ops);
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		
		$site_url = get_option( 'siteurl' );


		
		//$instance['hide_is_admin']

		
		
			echo $before_widget;
			
			echo ultimate_render("", $instance);
			
			
			echo $after_widget;
		
	}
	function update($new_instance, $old_instance) {
		
		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

		
		
		
		
		
		
		$instance['values']=$values;
		
		return $instance;
	}
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'width' => '240', 'height' => '200', 'border' => '10', 'round' => '1', 'width_thumbnail' => '40', 'height_thumbnail' => '50', 'thumbnail_border' => '6', 'thumbnail_round' => '1', 'number_thumbnails' => '4', 'values'=>'', 'sizetitle'=>'18pt Arial', 'sizedescription'=>'12pt Arial', 'sizethumbnail'=>'10pt Arial', 'font'=>'Verdana', 'color1'=>'#333333', 'color2'=>'#888888', 'color3'=>'#dddddd', 'time'=>'5000', 'animation'=>'0', 'mode'=>'0','op1' => '','op2' => '','op3' => '','op4' => '','op5' => '' ) );
		$title = strip_tags($instance['title']);
		$id=rand(0, 99999);
		$width = strip_tags($instance['width']);
		$height = strip_tags($instance['height']);
		$border = strip_tags($instance['border']);
		$round = strip_tags($instance['round']);
		$title = strip_tags($instance['title']);
		$width_thumbnail = strip_tags($instance['width_thumbnail']);
		$height_thumbnail = strip_tags($instance['height_thumbnail']);
		$thumbnail_border = strip_tags($instance['thumbnail_border']);
		$thumbnail_round = strip_tags($instance['thumbnail_round']);
		$number_thumbnails = strip_tags($instance['number_thumbnails']);
		$values = strip_tags($instance['values']);
		
		$sizetitle = strip_tags($instance['sizetitle']);
		$sizedescription = strip_tags($instance['sizedescription']);
		$sizethumbnail = strip_tags($instance['sizethumbnail']);
		$font = strip_tags($instance['font']);
		$color1 = strip_tags($instance['color1']);
		$color2 = strip_tags($instance['color2']);
		$color3 = strip_tags($instance['color3']);
		
		$time = strip_tags($instance['time']);
		$animation = strip_tags($instance['animation']);
		$mode = strip_tags($instance['mode']);
		
		$op1 = strip_tags($instance['op1']);
		$op2 = strip_tags($instance['op2']);
		$op3 = strip_tags($instance['op3']);
		$op4 = strip_tags($instance['op4']);
		$op5 = strip_tags($instance['op5']);

		
		
		$borderround[$round] = 'checked';
		$tborderround[$thumbnail_round] = 'checked';
		
		

  global $wpdb; 
	$table_name = $wpdb->prefix . "ultimate";
	
	$myrows = $wpdb->get_results( "SELECT * FROM $table_name;" );

if(empty($myrows)) {
	
	echo '
	<p>First create a new gallery of videos, from the administration of ultimate plugin.</p>
	';
}

else {
	$contaa1=0;
	$selector='<select name="'.$this->get_field_name('title').'" id="'.$this->get_field_id('title').'">';
	while($contaa1<count($myrows)) {
		
		
		$tt="";
		if($title==$myrows[$contaa1]->id)  $tt=' selected="selected"';
		$selector.='<option value="'.$myrows[$contaa1]->id.'"'.$tt.'>'.$myrows[$contaa1]->id.' '.$myrows[$contaa1]->title.'</option>';
		$contaa1++;
		
	}
	
	$selector.='</select>';




echo 'Gallery: '.$selector; 

			}
	}
}


function ultimate_panel(){
	global $wpdb; 
	$table_name = $wpdb->prefix . "ultimate";	
	
	if(isset($_POST['crear'])) {
		$re = $wpdb->query("select * from $table_name");
		
		
//autos  no existe
$paca=0;
if(empty($re))
{
	

	$paca=1;
	
  $sql = " CREATE TABLE $table_name(
	id mediumint( 9 ) NOT NULL AUTO_INCREMENT ,
	title longtext NOT NULL ,
	width longtext NOT NULL ,
	height longtext NOT NULL ,
	border longtext NOT NULL ,
	round longtext NOT NULL ,
	width_thumbnail longtext NOT NULL ,
	height_thumbnail longtext NOT NULL ,
	thumbnail_border longtext NOT NULL ,
	thumbnail_round longtext NOT NULL ,
	number_thumbnails longtext NOT NULL ,
	ivalues longtext NOT NULL ,
	sizetitle longtext NOT NULL ,
	sizedescription longtext NOT NULL ,
	sizethumbnail longtext NOT NULL ,
	font longtext NOT NULL ,
	color1 longtext NOT NULL ,
	color2 longtext NOT NULL ,
	color3 longtext NOT NULL ,
	time longtext NOT NULL ,
	animation longtext NOT NULL ,
	mode longtext NOT NULL ,
	op1 longtext NOT NULL ,
	op2 longtext NOT NULL ,
	op3 longtext NOT NULL ,
	op4 longtext NOT NULL ,
	op5 longtext NOT NULL ,
	
		PRIMARY KEY ( `id` )	
	) ;";
	$wpdb->query($sql);
	
}

		
	if($paca==1) $sql = "INSERT INTO $table_name (`title`, `width`, `height`, `border`, `round`, `width_thumbnail`, `height_thumbnail`, `thumbnail_border`, `thumbnail_round`, `number_thumbnails`, `ivalues`, `sizetitle`, `sizedescription`, `sizethumbnail`, `font`, `color1`, `color2`, `color3`, `time`, `animation`, `mode`, `op1`, `op2`, `op3`, `op4`, `op5`) VALUES
('Demo version', '100%', '680', '10', 'hide', '4', '1', '12', '1', '50', 'ULTIMATE PROt6r4ndPlays video files flv or youtube videos.t6r4ndt6r4nd1t6r4ndhttp://www.youtube.com/watch?v=kBtMJjLVB90t6r4ndt6r4ndt6r4ndkh6gfd57hggMultiple designst6r4ndMultiple configurations thumbnailst6r4ndt6r4nd1t6r4ndhttp://www.youtube.com/watch?v=sCXXgjwXcxQt6r4ndt6r4ndt6r4ndkh6gfd57hggIncludes video management easy and powerfult6r4ndt6r4ndt6r4nd1t6r4ndhttp://www.youtube.com/watch?v=nzW0M0xadhYt6r4ndt6r4ndt6r4ndkh6gfd57hggCopy and paste the url of the videos from youtubet6r4ndt6r4ndt6r4nd1t6r4ndhttp://www.youtube.com/watch?v=_ovdm2yX4MA&ob=av2et6r4ndt6r4ndt6r4ndkh6gfd57hggAutomatic image thumbnails t6r4ndt6r4ndt6r4nd1t6r4ndhttp://www.youtube.com/watch?v=hLQl3WQQoQ0t6r4ndt6r4ndt6r4ndkh6gfd57hggManage your flv videos through the media library wordpresst6r4ndt6r4ndt6r4nd1t6r4ndhttp://www.youtube.com/watch?v=rYEDA3JcQqwt6r4ndt6r4ndt6r4ndkh6gfd57hggManage your images through the media library wordpresst6r4ndt6r4ndt6r4nd1t6r4ndhttp://www.youtube.com/watch?v=jUe8uoKdHaot6r4ndt6r4ndt6r4ndkh6gfd57hggColors, fonts, sizes, rows and columns of thumbnails, ... multiple configurationst6r4ndt6r4ndt6r4nd1t6r4ndhttp://www.youtube.com/watch?v=p4kVWCSzfK4t6r4ndt6r4ndt6r4ndkh6gfd57hggMultiple galleries to insert in your posts or pagest6r4ndt6r4ndt6r4nd1t6r4ndhttp://www.youtube.com/watch?v=CdXesX6mYUEt6r4ndt6r4ndt6r4ndkh6gfd57hggYou can use them as a widgett6r4ndt6r4ndt6r4nd1t6r4ndhttp://www.youtube.com/watch?v=SmM0653YvXUt6r4ndt6r4ndt6r4ndkh6gfd57hgg', '0', '', '0', '10', '000000', 'FFFFFF', 'FCFFED', 'D4D4D4', '', '', '0', '3', 'Arial', '000000', '');";
	
	else $sql = "INSERT INTO $table_name (`title`, `width`, `height`, `border`, `round`, `width_thumbnail`, `height_thumbnail`, `thumbnail_border`, `thumbnail_round`, `number_thumbnails`, `ivalues`, `sizetitle`, `sizedescription`, `sizethumbnail`, `font`, `color1`, `color2`, `color3`, `time`, `animation`, `mode`, `op1`, `op2`, `op3`, `op4`, `op5`) VALUES
('Ultimate video', '100%', '680', '10', 'hide', '4', '1', '12', '1', '50', 'ULTIMATEt6r4ndPlays video files flv or youtube videos.t6r4ndt6r4nd1t6r4ndhttp://www.youtube.com/watch?v=kBtMJjLVB90t6r4ndt6r4ndt6r4ndkh6gfd57hgg', '0', '', '0', '10', '000000', 'FFFFFF', 'FCFFED', 'D4D4D4', '', '', '0', '3', 'Arial', '000000', '');";
	
	
	$wpdb->query($sql);
	}
	
if(isset($_POST['borrar'])) {
		$sql = "DELETE FROM $table_name WHERE id = ".$_POST['borrar'].";";
	$wpdb->query($sql);
	}
	if(isset($_POST['id'])){	
	
	
	
	$total = strip_tags($_POST['total']);


$cont=1;
		
		 $sorter=array();
		while($cont<=$total) {
			
			if(!$_POST['item'.$cont] || $_POST['operation']!="2") {
				$valaux=count($sorter);
				$sorter[$valaux]['order']=$_POST['order'.$cont];
				$sorter[$valaux]['cont']=$cont;
			}
		
			$cont++;
		}


function sortByOrder($a, $b) {
    return $a['order'] - $b['order'];
}

usort($sorter, 'sortByOrder');


		$cont=1;
		
		
		$values="";
		foreach ($sorter as &$value) {
    $cont = $value['cont'];

			if(!$_POST['item'.$cont] || $_POST['operation']!="2") $values.=$_POST['title'.$cont]."t6r4nd".$_POST['description'.$cont]."t6r4nd".$_POST['image'.$cont]."t6r4nd".$_POST['link'.$cont]."t6r4nd".$_POST['video'.$cont]."t6r4nd".$_POST['timage'.$cont]."t6r4nd".$_POST['seo'.$cont]."t6r4nd".$_POST['seol'.$cont]."kh6gfd57hgg";
				
		
			
		}
		
		if($_POST['operation']=="1") {
			$values.="Title video t6r4nd".""."t6r4nd".""."t6r4nd"."1"."t6r4nd"."http://www.youtube.com/watch?v=kBtMJjLVB90"."t6r4nd".""."t6r4nd".""."t6r4nd".""."t6r4nd".date("j/n/Y")."kh6gfd57hgg";
			
			$cont++;
		}
		

	
	


$sql= "UPDATE $table_name SET `ivalues` = '".$values."', `title` = '".$_POST["stitle".$_POST['id']]."', `width` = '".$_POST["width".$_POST['id']]."', `height` = '".$_POST["height".$_POST['id']]."', `round` = '".$_POST["round".$_POST['id']]."', `width_thumbnail` = '".$_POST["twidth".$_POST['id']]."', `height_thumbnail` = '".$_POST["theight".$_POST['id']]."', `thumbnail_border` = '".$_POST["tborder".$_POST['id']]."', `thumbnail_round` = '".$_POST["thumbnail_round".$_POST['id']]."', `number_thumbnails` = '".$_POST["number_thumbnails".$_POST['id']]."', `sizetitle` = '".$_POST["sizetitle".$_POST['id']]."', `sizedescription` = '".$_POST["sizedescription".$_POST['id']]."', `sizethumbnail` = '".$_POST["sizethumbnail".$_POST['id']]."', `font` = '".$_POST["font".$_POST['id']]."', `color1` = '".$_POST["color1".$_POST['id']]."', `color2` = '".$_POST["color2".$_POST['id']]."', `color3` = '".$_POST["color3".$_POST['id']]."', `time` = '".$_POST["time".$_POST['id']]."', `border` = '".$_POST["border".$_POST['id']]."', `animation` = '".$_POST["animation".$_POST['id']]."', `mode` = '".$_POST["mode".$_POST['id']]."', `op1` = '".$_POST["op1".$_POST['id']]."', `op2` = '".$_POST["op2".$_POST['id']]."', `op3` = '".$_POST["op3".$_POST['id']]."', `op4` = '".$_POST["op4".$_POST['id']]."', `op5` = '".$_POST["op5".$_POST['id']]."' WHERE `id` =  ".$_POST["id"]." LIMIT 1";
		
			
			
			$wpdb->query($sql);
	}
	$myrows = $wpdb->get_results( "SELECT * FROM $table_name" );
$conta=0;



include('template/cabezera_panel.html');
while($conta<count($myrows)) {
	$id= $myrows[$conta]->id;
	$title = $myrows[$conta]->title;
		$width = $myrows[$conta]->width;
$height = $myrows[$conta]->height;
$values =$myrows[$conta]->ivalues;

$twidth = $myrows[$conta]->width_thumbnail;

$theight = $myrows[$conta]->height_thumbnail;

$number_thumbnails = $myrows[$conta]->number_thumbnails;



$total = $myrows[$conta]->total;

$border = $myrows[$conta]->border;
$round = $myrows[$conta]->round;
$tborder = $myrows[$conta]->thumbnail_border;
$thumbnail_round = $myrows[$conta]->thumbnail_round;

$sizetitle = $myrows[$conta]->sizetitle;
$sizedescription = $myrows[$conta]->sizedescription;
$sizethumbnail = $myrows[$conta]->sizethumbnail;
$font = $myrows[$conta]->font;
$color1 = $myrows[$conta]->color1;
$color2 = $myrows[$conta]->color2;

$color3 = $myrows[$conta]->color3;

$animation = $myrows[$conta]->animation;
$time = $myrows[$conta]->time;
$mode = $myrows[$conta]->mode;
$op1 = $myrows[$conta]->op1;
$op2 = $myrows[$conta]->op2;
$op3 = $myrows[$conta]->op3;
$op4 = $myrows[$conta]->op4;
$op5 = $myrows[$conta]->op5;


	include('template/panel.php');			
	$conta++;
	}
include('template/footer.html');
}




function ultimate_add_menu(){	
	if (function_exists('add_options_page')) {
		//add_menu_page
		add_options_page('ultimate', 'ULTIMATE VIDEO', 8, 'ultimate', 'ultimate_panel');
	}
}


if (function_exists('add_action')) {
	add_action('admin_menu', 'ultimate_add_menu'); 
}

add_action( 'widgets_init', create_function('', 'return register_widget("wp_ultimate");') );
add_action('init', 'add_header_ultimate');
add_filter('the_content', 'ultimate');
add_action('admin_head', 'ultimate_enqueue_scripts');
?>