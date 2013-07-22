<?php
/*
Plugin Name: WP Testimonial Widget
Plugin URI: http://starkinfotech.com
Description: This plugin is for creating testimonials & display using Widget & Shorcodes on froent end side.
Author: Mrunmai Borgaonkar
Version: 1.0
Company: Stark Infotech
Author URI: http://starkinfotech.com
*/ 

/**
 * Function swpt_scripts_required() includes required jquery files
*/
function swpt_scripts_required(){
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script('swp_testi_effectsjs',plugins_url('/js/jquery.cycle.all.js', __FILE__));
} 

add_action('wp_enqueue_scripts', 'swpt_scripts_required');

/**
 * Function swpt_required_css() includes required css files
*/
add_action( 'admin_head', 'swpt_required_css' );

function swpt_required_css() {
    wp_register_style( 'swpt_css', plugins_url('/css/basic.css', __FILE__) );
    wp_enqueue_style( 'swpt_css' );
}

/**
 * Function swpt_install_testimonial() is to create table if it is not exists
*/
function swpt_install_testimonial()
{
    global $wpdb;
    $strTbl = $wpdb->prefix."swp_testimonial";
    $createTbl =  "CREATE TABLE IF NOT EXISTS $strTbl (
                    `id` int(10) NOT NULL AUTO_INCREMENT,
                    `description` text NOT NULL,
                    `company` varchar(255) NOT NULL,
                    `website` text NOT NULL,
                    PRIMARY KEY (`id`)
                )";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($createTbl);
}

register_activation_hook(__FILE__,'swpt_install_testimonial');

include_once("testimonial_widget.php");
include_once("shortcode.php"); 
include_once("functions.php"); 

//step1 Load basic Class
if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Testimonial_List_Table extends WP_List_Table {
    var $strQuery;
    function __construct(){
        global $status, $page;
                
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'testimonial',     //singular name of the listed records
            'plural'    => 'testimonials',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
    }
    
    /**
     * Function column_default() is called when the parent class can't find a method specifically build for a given column.
     * @param array $item A singular item (one full row's worth of data)
     * @param array $column_name The name/slug of the column to be processed
    */
    function column_default($item, $column_name){
        switch($column_name){
            case 'Rank':
            case 'description':
            case 'company':
            case 'website':
                return stripslashes($item[$column_name]);
            default:
                return print_r($item,true); //Show the whole array for troubleshooting purposes
        }
    }


    /**
     * Function column_description() is a custom column method and is responsible for what is rendered in any column with a name/slug of 'description'.
     * @param array $item a singular item.
    */
    function column_description($item){
        //Build row actions
        $actions = array(
            'edit'      => sprintf('<a href="?page=%s&mode=%s&testimonial=%s">Edit</a>',$_REQUEST['page'],'edit',$item['id']),
            'delete'    => sprintf("<a href=\"?page=%s&action=%s&testimonial_id=%s\" onclick=\"if ( confirm( '" . esc_js( sprintf( __( "You are about to delete this List '%s'\n  'Cancel' to stop, 'OK' to delete." ),  $item['description'] ) ) . "' ) ) { return true;}return false;\">Delete</a>",$_REQUEST['page'],'delete',$item['id']),
        );
        
       
        return sprintf('%s %s',
            substr(stripslashes($item['description']),0,250),
            $this->row_actions($actions)
        );
    }
   
    /**
     * Function column_cb() is to display checkboxes.
     * @param array $item a singular item.
    */
    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("testimonial")
            /*$2%s*/ $item['id']                //The value of the checkbox should be the record's id
        );
    }
     
    /**
     * Function get_columns() is to set table's columns and titles.
    */  
    function get_columns(){
        $columns = array(
            'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
            'Rank'  => 'Sr. No.',
            'description'     => 'Description',
            'company'    => 'Company',
            'website'  => 'Website',
            'category' => 'Category'
        );
        return $columns;
    }
    
    /**
     * Function get_sortable_columns() is to sort one/more columns.
    */ 
    function get_sortable_columns() {
        $sortable_columns = array(
            'Rank' => array('Rank', false),
            'description'     => array('description',false),     //true means it's already sorted
            'company'    => array('company',false),            
        );
        return $sortable_columns;
    }

    /**
     * Function get_bulk_actions() is to set bulk actions for table.
    */ 
    function get_bulk_actions() {
        $actions = array(
            'delete'    => 'Delete'
        );
        return $actions;
    }
    
    /**
     * Function process_bulk_action() is to set bulk actions for table.
    */
    function process_bulk_action() {
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            wp_die('Items deleted (or they would be if we had items to delete)!');
        }
        
    }
 
    /**
     * Function prepare_items() is to list testimonial and set order.
    */
    function prepare_items() {
        global $wpdb; //This is used only if making any database queries

        $per_page = 5;
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
      
        $strTbl = $wpdb->prefix."swp_testimonial";
        $this->_column_headers = array($columns, $hidden, $sortable);
        $wpdb->query("SET @a=0");
        $this->strQuery = "SELECT (@a:=@a+1) AS Rank, id, description, company, website FROM ".$strTbl ." ORDER BY id DESC";
        $data = $wpdb->get_results($this->strQuery,ARRAY_A );
                               
        function usort_reorder($a,$b){
            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'Rank'; //If no sort, default to rank
                       $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to desc
            if(is_numeric($a[$orderby]))
            {
                 $result = ($a[$orderby] > $b[$orderby]?-1:1); //Determine sort order
            }
            else
            {
                $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            }
            
            return ($order==='desc') ? $result : -$result; //Send final sort direction to usort
        }
        usort($data, 'usort_reorder');
        $current_page = $this->get_pagenum();
        $total_items = count($data);
        
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
              
        $this->items = $data;
      
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
    
}

/**
* Function _fnAddMenuItems() is called to add menu in admin side
*/     
add_action('admin_menu', '_fnAddMenuItems');
function _fnAddMenuItems(){
    add_menu_page('Testimonials', 'Testimonials', 'activate_plugins', 'testimonial', '_fnDemoRenderListPage', plugins_url('images/icon.png', __FILE__));
    add_submenu_page( 'testimonial', 'Help', 'Help', 'manage_options', 'help', 'swpt_add_settings_menu' );
} 

/**
* Function _fnDemoRenderListPage is called to display list of table.
*/
function _fnDemoRenderListPage(){
                
    //Create an instance of our package class...
    $testListTable = new Testimonial_List_Table();

    //for message display
    $messages = array();
    if ( isset($_GET['update']) ) :
        switch($_GET['update']) {
            case 'del':
            case 'del_many':
                $delete_count = isset($_GET['delete_count']) ? (int) $_GET['delete_count'] : 0;
                $messages[] = '<div id="message" class="updated"><p>' . sprintf( _n( 'testimonial deleted.', '%s testimonials deleted.', $delete_count ), number_format_i18n( $delete_count ) ) . '</p></div>';
                break;
            case 'add':
                $strmsg = isset($_GET['id']) ? "updated" : "Added";
                $messages[] = '<div id="message" class="updated"><p>' . __( 'New record $strmsg.' ) . '</p></div>';
                break;
        }
    endif; 

    $this_file = "?page=".$_REQUEST['page'];

    switch($testListTable->current_action())
    {
        case "add":
        case "edit":
        case "delete":
            global $wpdb;
                       
            if(isset($_GET['action2']) && ($_GET['action2']=="-1"))
            {
                $del_id = $_GET['testimonial'];
                $del_data = swpt_delete_data($del_id);
            }
            
            if(isset($_GET['testimonial_id']) && $_GET['testimonial_id'])
            {
                $del_id = $_GET['testimonial_id'];
                $del_data = swpt_delete_data($del_id);
            }
            if(isset($del_data)){ ?>
                <div class='<?php echo $del_data['msgClass']; ?>'>
                    <p><?php echo $del_data['msg']; ?></p>
                </div>
            <?php } 
                     
            $this_file = $this_file."&update=delete";
        default:
        ?>
            <script type='text/javascript' src="<?php echo plugins_url('js/jquery.validate.js',__FILE__); ?>"></script>
            <script type="text/javascript">
            jQuery(document).ready(function() {
                jQuery("#add_testi").validate();
            });
            </script>

            <?php
            global $wpdb;
                
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
            
            //Fetch, prepare, sort, and filter our data...
            $testListTable->prepare_items();
            if ( ! empty($messages) ) {
                foreach ( $messages as $msg )
                echo $msg;
            }
            ?>
            
            <div class="wrap">
                <div class="icon32 icon32-posts-post" id="icon-edit">
                    <br>
                </div>
                <h2>Testimonials</h2>
                <?php if(isset($arrMsg) && !empty($arrMsg)){ ?>
                    <div class="<?php echo $arrMsg['msgClass']; ?>">
                    <p><?php echo $arrMsg['msg']; ?></p>
                </div>
                <?php } 
                ?>
                <div id="col-container">
                    <div id="col-right">
                        <div class="col-wrap">
                            <div class="form-wrap">
                                <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
                                <form id="testimonials-filter" method="get">
                                    <!-- For plugins, we also need to ensure that the form posts back to our current page -->
                                    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                                    <!-- Now we can render the completed list table -->
                                    <?php $testListTable->display() ?>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="col-left">
                        <div class="col-wrap">
                            <div class="form-wrap">
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
                                <h3>
                                    <?php echo $strLabel; ?> Testimonial
                                    <?php if(isset($intEditId)) { ?>
                                    <a href="?page=testimonial" class="add-new-h2">Add New</a>
                                    <?php } ?>
                                </h3>
                                <form id="add_testi" name="add_testi"  method="post" action="" class="frm_testi">
                                    <div class="form-field">
                                        <label for="Company">Company Name<span class="chkRequired">*</span></label>
                                        <p>Name of company which given you the feedback.</p>
                                        <input type="text" size="40" class="required" value="<?php if(isset($arrTestiData->company)) {  echo stripslashes($arrTestiData->company);} ?>" id="company" name="company">
                                    </div>
                                    <div class="form-field">
                                        <label for="Website">Website URL</label>
                                        <p>URL of the company.</p>
                                        <input type="text" size="40" value="<?php if(isset($arrTestiData->website)) {echo $arrTestiData->website;} ?>" id="website" name="website" class="url">
                                    </div>
                                    <div class="form-field">
                                        <label for="Website">Category</label>
                                        <p>Category</p>
                                        <input type="text" size="40" value="<?php if(isset($arrTestiData->website)) {echo $arrTestiData->website;} ?>" id="website" name="website" class="url">
                                    </div>
                                    <div class="form-field">
                                        <label for="Description">Testimonial<span class="chkRequired">*</span></label>
                                        <p>Few words said by the company.</p>
                                        <textarea name ='description' class="required" cols="51" rows="7" maxlength="500" ><?php if(isset($arrTestiData->description)) {echo stripslashes($arrTestiData->description);} ?></textarea>
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
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div><!-- /col-left -->
                </div><!-- /col-container -->
            </div>
            <?php
            break;
    }
} 

/**
 * Function swpt_sub_menu() and swpt_add_settings_menu() are written to create sub menu Help.
*/ 
function swpt_add_settings_menu(){
    global $wpdb;
    include 'help.php';
}
?>