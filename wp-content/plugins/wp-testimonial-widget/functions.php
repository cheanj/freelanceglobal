<?php
/**
 * Function swpt_widget_shortcode_output() is called in file shortcode.php and testi_widget.php to display data.
 * @param $testimonials is used to show number of testimonials to show on frontend.
 * @param $order is to set order of testimonials
 * @param $testimonials is to set effect.
*/ 
function swpt_widget_shortcode_output($testimonials,$order){ 
    global $post; 
    global $wpdb;
    ob_start();

    $strTbl = $wpdb->prefix."swp_testimonial";
    $strTestimonial = "SELECT id,description,company,website FROM $strTbl ORDER BY id ". $order." LIMIT ".$testimonials;
    $arrTestimonial =  $wpdb->get_results($strTestimonial);  
    
    foreach($arrTestimonial as $testi)
    {
        $strComp = $testi->company;
        $strWebsite = $testi->website;
        ?>
        <div class="front_end_data">
            <?php
            if(!empty($testi->description))
            { 
            ?>
                <p class="testimonial_content">
                    <?php echo stripslashes($testi->description); ?>
                </p>
            <?php 
            }
            
            if(!empty($strWebsite))
            {
                $boolWebsite = strstr($strWebsite, 'http://');
                if($boolWebsite == true)
                {
                    $sWebsite = $strWebsite;
                }
                else
                {
                    $sWebsite = 'http://'.$strWebsite;
                }
                ?>
                <p class="testimonial_content">
                    <a href="<?php echo $sWebsite; ?>"> <?php echo $strWebsite; ?></a>
                </p>
            <?php
            }

            if(!empty($strComp))
            { 
            ?>
                <p class="testimonial_content">
                    <?php echo $strComp; ?>
                </p>
            <?php
            }               
            ?>
        </div>
        <?php
    } 
    $output_string = ob_get_contents();
    ob_end_clean();
    return $output_string;
}

//Enable the widget of the plugin.
add_action('widgets_init', create_function('', 'return register_widget("SWP_Testimonial_Widget");'));

/**
 * Function swpt_add_update_testi() is used to add or update testimonial.
 * @param $strTbl is to set table name.
 * @param $arrData is to set data.
 * @param $arrWhere is to set WHERE condition.
*/
function swpt_add_update_testi($strTbl,$arrData,$arrWhere= array())
{
    global $wpdb;

    if(count($arrWhere)==0)
    {
        $wpdb->insert($strTbl,$arrData);
        return $wpdb->insert_id;
    }
    else
    {
        $wpdb->update($strTbl,$arrData,$arrWhere);

        return true;
    }
    return false;
}

/**
 * Function swpt_add_update_testi() is used to add or update testimonial.
 * @param $strTbl is to set table name.
 * @param $boolLimit is to set limit.
 * @param $arrWhere is to set WHERE condition.
*/
function swpt_edit_data($strTbl,$arrWhere="",$boolLimit=true)
{
    global $wpdb;
    $strWhere = "";

    if(count($arrWhere) > 0 )
    {
        $strSep =  (count($arrWhere) > 1?" AND ":"");
        $strWhere = " WHERE ".implode($strSep, $arrWhere);
    }
    if($boolLimit)
    {
        $strLimit = "LIMIT 1";
    }
    $strSql = "Select id,description,company, website from $strTbl $strWhere $strLimit";
    
    if($boolLimit)
    {
        $arrResult =  $wpdb->get_row($strSql);  
    }
    else
    {
        $arrResult =  $wpdb->get_results($strSql);      
    }
    return $arrResult;
}

/**
 * Function swpt_add_update_testi() is used to add or update testimonial.
 * @param $intId is the id.
 */
function swpt_delete_data($intId)
{
    global $wpdb;
    $strTbl = $wpdb->prefix."swp_testimonial";

    $chkArray = is_array($intId);
    if($chkArray)
    {
        foreach($intId as $del_id)
        {
            $deleteTesti = $wpdb->query("DELETE FROM ".$strTbl." WHERE id = ".$del_id);
        }
    }
    else
    {
        $deleteTesti = $wpdb->query("DELETE FROM $strTbl WHERE id =".$intId);
    }

    if($deleteTesti)
    {
        $arrMsg = array('msg' => 'Testimonial(s) Deleted.','msgClass' =>'updated');
    }
    return $arrMsg;
}