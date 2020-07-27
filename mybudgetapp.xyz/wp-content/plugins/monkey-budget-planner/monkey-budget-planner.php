<?php
	
/*
Plugin Name: Monkey Budget Planner
Plugin URI: https://nmcreative.co.uk/
Description: Monkey Budget Planner puts you in control of your household spending and analyses your results to help you take control of your money.
Version: 1.0
Author: Northern Monkey Creative Ltd.
Author URI: https://nmcreative.co.uk/
License: Custom
Text Domain: monkey-budget-planner
*/

if (!defined('ABSPATH')) {
	exit();
}

//db req
//require_once('db-init.php');
require_once('db-insert.php');

/*Global Variables*/
 $options = array();
 $message = '';
 
 
if (!defined('MYPLUGIN_THEME_DIR'))
    define('MYPLUGIN_THEME_DIR', ABSPATH . 'wp-content/themes/' . get_template());

if (!defined('MYPLUGIN_PLUGIN_NAME'))
    define('MYPLUGIN_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('MYPLUGIN_PLUGIN_DIR'))
    define('MYPLUGIN_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . MYPLUGIN_PLUGIN_NAME);

if (!defined('MYPLUGIN_PLUGIN_URL'))
    define('MYPLUGIN_PLUGIN_URL', WP_PLUGIN_URL . '/' . MYPLUGIN_PLUGIN_NAME);
    
  


//activation hook
register_activation_hook( __FILE__, 'monkey_budget_activation' );
function monkey_budget_activation() {
  add_option('monkey_styles', '1');
}
    
// Add Admin Menu and Page
add_action('admin_menu', 'monkey_setup_menu');
function monkey_setup_menu() {
    $page_title = 'Monkey Budget Planner';
    $menu_title = 'Monkey Options';
    $capability = 'manage_options';
    $menu_slug = 'monkey_options';
    $function = 'monkey_options_init';
    $icon_url = 'dashicons-list-view';
    $position = 24;
    add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
}


// Add third party resources to head
function monkey_resources() {
    wp_enqueue_style('bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.css');
    wp_enqueue_style('style', get_stylesheet_uri());
    wp_enqueue_script( 'bootstrap-js', plugin_dir_url( __FILE__ ) . 'js/bootstrap.js', array('jquery'), '3.2.0', true );  
}
// Add The Plugin CSS
function monkey_budget_styles() {
	wp_enqueue_style('monkey-styles', MYPLUGIN_PLUGIN_URL.'/css/monkey-budget.css', '1.0', true);
}
// Add The Plugin JS
function monkey_budget_scripts() {
  wp_register_script( 'monkey_budget_script', plugins_url( '/js/monkey-budget.js', __FILE__ ), array('jquery'), '1.1', true );
	wp_enqueue_script('monkey_budget_script', plugins_url( '/js/monkey-budget.js', __FILE__ ), array('jquery'), '1.1', true);
}

// Add the admin scripts
function monkey_admin_enqueue_scripts() {

	wp_enqueue_script(
		'alpha-color-picker',
		MYPLUGIN_PLUGIN_URL . '/js/color-picker.js', 
		array( 'jquery', 'wp-color-picker' ),
		null,
		true
	);

	wp_enqueue_style(
		'alpha-color-picker',
		MYPLUGIN_PLUGIN_URL . '/css/color-picker.css', 
		array( 'wp-color-picker' )
	);

	// This is the JS file that will contain the trigger script.
	// Set alpha-color-picker as a dependency here.
	wp_enqueue_script(
		'xxx-admin-js',
		MYPLUGIN_PLUGIN_URL . '/js/admin.js',
		array( 'alpha-color-picker' ),
		null,
		true
	);
}



//Add Actions

//load monkey resources if admin settings is checked
if(get_option('monkey_styles')=='1'){
  add_action('wp_enqueue_scripts', 'monkey_resources', 999);
}

add_action('wp_head', 'monkey_budget_styles', 999);
add_action ('wp_enqueue_scripts', 'monkey_budget_scripts', 999);
add_action( 'admin_enqueue_scripts', 'monkey_admin_enqueue_scripts' ); 



//action budget hook
add_action('wp_ajax_update_budget_action', 'update_budget');
add_action('wp_ajax_no_priv_update_budget_action', 'update_budget');

add_action('wp_head', 'ajaxurl_function');

//for frontend ajaxurl access
function ajaxurl_function() {
   echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}




// Monkey Init
function monkey_options_init(){
	
	settings_errors(); 

	if(current_user_can('manage_options')):
 
        if(isset($_POST['monkey_form_submitted'])){
	 
			$hidden = esc_html($_POST['monkey_form_submitted']);
			 
			if($hidden == 'Y'){		
        $monkey_styles = $_POST['monkey_styles'];	
				$brand = $_POST['monkey_brand_color'];
				$headerText = $_POST['monkey_header_text'];
				$monkey_currency_icon = $_POST['monkey_currency_icon'];
        update_option('monkey_styles', $monkey_styles);
        update_option('monkey_brand_color', $brand);
				update_option('monkey_header_text', $headerText);
        update_option('monkey_currency_icon', $monkey_currency_icon);
        
			}   
			 
		}
			$options = get_option('monkey_general_info');
	
	endif
    ?>
    <!-- Create a header in the default WordPress 'wrap' container -->
    <div class="wrap">
     
        <div id="icon-themes" class="icon32"></div>
        <h2><?php _e( 'Monkey Options', 'monkey-budget-planner' ); ?></h2>
        <p class="description"><?php _e( 'Manage your Monkey Budget Planner settings below.', 'monkey-budget-planner' ); ?></p>
        <hr>
        <h4><?php _e( 'How To Use', 'monkey-budget-planner' ); ?></h4>
        <p><?php _e( 'Simply Copy and Paste the Monkey Shortcode below to any Page or Post to show your Monkey Budget Planner Form:', 'monkey-budget-planner' ); ?></p>
        <input id="" class="textarea" name="" type="textarea" value="[monkey]"/>
        <hr>
  
        <form action="" method="post" name="monkey_general_options_form">    
            <table class="form-table">
                <tbody>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td><label for="monkey_brand_color"><?php _e( 'Brand Colour', 'monkey-budget-planner' ); ?></label></td>
                        <td><input id="monkey_brand_color" class="alpha-color-picker" name="monkey_brand_color" type="text" value="<?php echo get_option('monkey_brand_color') ?>" data-default-color="#444"/></td>
                        <td></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td><label for="monkey_header_text"><?php _e( 'Header Text', 'monkey-budget-planner' ); ?></label></td>
                        <td><input id="monkey_header_text" class="regular-text" name="monkey_header_text" type="text" value="<?php echo get_option('monkey_header_text') ?>"/></td>
                        <td></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td><label for="monkey_currency_icon"><?php _e( 'Currency Icon', 'monkey-budget-planner' ); ?></label></td>
                        <td><input id="monkey_currency_icon" class="regular-text"  name="monkey_currency_icon" type="text" value="<?php echo get_option('monkey_currency_icon') ?>"/> </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><label for="monkey_styles"><?php _e( 'Monkey Styles', 'monkey-budget-planner' ); ?></label></td>
                        <td><input id="monkey_styles" class="regular-text"  name="monkey_styles" type="checkbox" value="1" <?= checked( get_option('monkey_styles'), 1, false );?>/> <?php _e( 'Uncheck to disbale the Bootstrap styles and scripts loaded by the plugin if you already have bootstrap loaded.', 'monkey-budget-planner' ); ?></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <hr>
            <br>
            <p>Plugin Developed by <a href="https://nmcreative.co.uk/" title="Visit Northern Monkey Creative Media Ltd" target="_blank">Northern Monkey Creative Media Ltd</a></p>
            <br>
            <input name="monkey_form_submitted" type="hidden" value="Y" />
            <input class="button-primary" name="monkey-form_submit" type="submit" value="<?php _e( 'Save Information' ); ?>" />
        </form>

         
    </div>
    <?php  
	    
	      
}







   

// Create the Monkey Shortcode
add_shortcode('monkey', 'monkey_budget_form');
function monkey_budget_form($atts) {
	
	$color = get_option('monkey_brand_color');
  $theTitle = get_option('monkey_header_text');
  $currencyIcon = get_option('monkey_currency_icon');
  
  ?>

<!-- Add below script and Style to utilise php -->
<script>
//Format a currency string
function format_currency(num) {
		var p = num.toFixed(0).split(".");
		return "<?php echo $currencyIcon; ?>" + p[0].split("").reverse().reduce(function(acc, num, i, orig) {
			return  num + (i && !(i % 3) && !(num=='-') ? "," : "") + acc;
		}, "");
	}	

</script>
<style>
	#budget-calculator > ul > li.active > a{
	    cursor: default;
	    background-color: <?php echo $color ?>;
	    border: 1px solid <?php echo $color ?>;
	    border-bottom-color: transparent;
	    color: white;
	    font-weight: bold;
	}
	
	.budget-calculator tfoot td .total{
		background-color: <?php echo $color ?>;
	}
</style>


<?php 
	// If the messages sentstatus is sent show success message
	if(isset($_GET['status'])){
		 $status = $_GET['status'];
		 if($status == 1){
			echo "<h3 style='margin-bottom: 40px;'><span class='label label-success'><i class='glyphicon glyphicon-ok'></i> ". _e( 'Thank you, Your Report has been emailed', 'monkey-budget-planner' )."</span></h3>";
		 }else if($status == 0){
			echo "<h3 style='margin-bottom: 40px;'><span class='label label-danger'><i class='glyphicon glyphicon-remove'></i> ". _e('There was an error sending your message', 'monkey-budget-planner' )." </span></h3>";
		 }
	 }	
  ?>



<div class="monkey-budget-planner-wrapper">
  <div class="monkey-header-wrapper" style="background:<?php echo $color ?>">

    <div class="monkey-header-r">
      <h1 style="color:white;margin:0;">
        <?php echo $theTitle ?>
      </h1>
    </div>
  </div> 
  <div class="stick-here"></div>
		<div class="toolbar stickThis">
		<div class="toolbar-buttons">
			<button style="margin-right: 5px;" type="button" class="viewIncome btn btn-info btn-sm"><i class="glyphicon glyphicon-download"></i></button>
			<button style="margin-right: 5px;" id="" type="button" class="viewOutgoings btn btn-info btn-sm"><i class="glyphicon glyphicon-upload"></i></button>
			<button class="btn btn-sm btn-warning reset-localstorage" style="font-size: 14px;"><i class="glyphicon glyphicon-refresh"></i> <span class="reset-button-text" style="margin-left:10px;"><?php _e( 'Reset Budget Planner', 'monkey-budget-planner' ); ?></span></button>
		</div>
	</div>
  <div class="modal fade" id="budget-calculator-add-row" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
    data-backdrop="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background:<?php echo $color ?>;">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only"><?php _e( 'Close', 'monkey-budget-planner' ); ?></span>
          </button>
          <h4 class="modal-title"><?php _e( 'Add Row', 'monkey-budget-planner' ); ?></h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="add-row-name"><?php _e( 'Expense Name', 'monkey-budget-planner' ); ?></label>
            <input type="text" class="form-control" id="add-row-name" placeholder="">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e( 'Close', 'monkey-budget-planner' ); ?></button>
          <button type="button" class="btn btn-primary btn-add-row" data-type=""><?php _e( 'Add Row', 'monkey-budget-planner' ); ?></button>
        </div>
      </div>
    </div>
  </div>
  <div id="budget-calculator" class="budget-calculator">
    <ul class="nav nav-tabs" role="tablist">
      <li class="active">
        <a href="#income" role="tab" data-toggle="tab">
          <i class="glyphicon glyphicon-download"></i> <?php _e( 'Income', 'monkey-budget-planner' ); ?></a>
      </li>
      <li>
        <a href="#outgoings" role="tab" data-toggle="tab">
          <i class="glyphicon glyphicon-upload"></i> <?php _e( 'Outgoings', 'monkey-budget-planner' ); ?></a>
      </li>
    </ul>
    <div id="monkeyTable" class="tab-content">
      <div class="tab-pane fade in active" id="income">
        <table class="table table-hover">
          <thead>
            <tr>
              <th style="width:50%"><?php _e( 'Your income', 'monkey-budget-planner' ); ?></th>
              <th style="width:10%"><?php _e( 'Frequency', 'monkey-budget-planner' ); ?></th>
              <th style="width:20%"><?php _e( 'Amount', 'monkey-budget-planner' ); ?></th>
              <th style="width:20%"><?php _e( 'Annual Amount', 'monkey-budget-planner' ); ?></th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody></tbody>
          <tfoot>
	         <tr>
              <td colspan="5">
	              <div class="stitched">
				  	<span class="btn btn-xs btn-success add-row" data-type="income"><i class="glyphicon glyphicon-plus-sign"></i> <?php _e( 'Add Income Row', 'monkey-budget-planner' ); ?></span>
                  </div>
              </td>
            </tr>
            <tr>
           	  <td colspan="5">
                <span class="total"><?php _e( 'Total', 'monkey-budget-planner' ); ?>: <?php echo esc_html__($currencyIcon, 'monkey-budget-planner') ?>0</span>
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="tab-pane fade" id="outgoings">
        <table class="table table-hover">
          <thead>
            <tr>
              <th style="width:50%"><?php _e( 'Outgoing Expenses', 'monkey-budget-planner' ); ?></th>
              <th class="noprint" style="width:10%"><?php _e( 'Frequency', 'monkey-budget-planner' ); ?></th>
              <th class="noprint" style="width:20%"><?php _e( 'Amount', 'monkey-budget-planner' ); ?></th>
              <th style="width:20%"><?php _e( 'Annual Amount', 'monkey-budget-planner' ); ?></th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody></tbody>
          <tfoot>
            <tr>
              <td colspan="5">
	              <div class="stitched">
				  	<span class="btn btn-xs btn-success add-row" data-type="outgoings"><i class="glyphicon glyphicon-plus-sign"></i> <?php _e( 'Add Outgoings Row', 'monkey-budget-planner' ); ?></span>
                  </div>
              </td>
            </tr>
            <tr>
           	  <td colspan="5">
                <span class="total"><?php _e( 'Total', 'monkey-budget-planner' ); ?>: <?php echo esc_html__($currencyIcon, 'monkey-budget-planner') ?>0</span>
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="" id="totals">
        <div class="totals total-income">
            <h3><?php _e( 'Total Annual Income', 'monkey-budget-planner' ); ?>: <span><?php echo esc_html__($currencyIcon, 'monkey-budget-planner') ?>0</span></h3>
            <div class="progress progress-striped active">
            	<div class="progress-bar" style="width:0%"></div>
            </div>
        </div>
        <div class="totals total-outgoings">
            <h3><?php _e( 'Total Annual Outgoings', 'monkey-budget-planner' ); ?>: <span><?php echo esc_html__($currencyIcon, 'monkey-budget-planner') ?>0</span></h3>
            <div class="progress progress-striped active">
            	<div class="progress-bar" style="width:0%"></div>
            </div>
        </div>
    
        <div class="balance">
	        <div class="filter-buttons"><span id="result" style="font-size: 12px;margin-right: 5px;"><?php _e( 'Filter Result', 'monkey-budget-planner' ); ?></span>
		        <button id="weekly" type="button" class="btn btn-success btn-sm"><?php _e( 'Weekly', 'monkey-budget-planner' ); ?></button>
		        <button id="fortnightly" type="button" class="btn btn-success btn-sm"><?php _e( 'Fortnightly', 'monkey-budget-planner' ); ?></button>
		        <button id="monthly" type="button" class="btn btn-success btn-sm"><?php _e( 'Monthly', 'monkey-budget-planner' ); ?></button>
		        <button id="annually" type="button" class="btn btn-success btn-sm"><?php _e( 'Annually', 'monkey-budget-planner' ); ?></button>
		        
	        </div>
	        
	        <div class="totals total-savings">
	            <h3><?php _e( 'This Leaves a Balance of', 'monkey-budget-planner' ); ?>: <span><?php echo esc_html__($currencyIcon, 'monkey-budget-planner') ?>0</span></h3>
	            <div class="progress progress-striped active">
	            	<div class="progress-bar progress-bar-success" style="width:0%"></div>
	            </div>
	        </div>
        </div>
      </div>
      <div class="pull-right">
        <!--
        <span class="printbutton btn btn-primary">
          <i class="glyphicon glyphicon-print"></i><?php _e( 'Print Results', 'monkey-budget-planner' ); ?></span>
        <span class="toggleMail btn btn-primary">
          <i class="glyphicon glyphicon-envelope"></i> <?php _e( 'Email Results', 'monkey-budget-planner' ); ?></span>
		-->
		<span class="submitbutton btn btn-primary">
          <i class="glyphicon glyphicon-envelope"></i> <?php _e( 'Submit', 'monkey-budget-planner' ); ?></span>
      </div>
    </div>
  </div>
  
	<div id="emailMokeyForm" style="background:white">
		<div class="box">
        <button class="btn btn-danger btn-sm cancel-mail toggleMail"><?php _e( 'Close', 'monkey-budget-planner' ); ?></button>
			<h2><?php _e( 'Email Results', 'monkey-budget-planner' ); ?></h2>
			<p><?php _e( 'Send your results in an Email, enter the email address below', 'monkey-budget-planner' ); ?>:</p>
			<form method="post" action="<?php echo MYPLUGIN_PLUGIN_URL?>/sendmail.php" id="monkeyForm">
			<div class="form-group ">
				<input name="firstname" type="text" id="firstname">
				<input name="name" type="text" id="name" placeholder="<?php esc_attr_e( 'Name', 'monkey-budget-planner' ); ?>" required><br>
				<input name="email" type="email" id="email" placeholder="<?php esc_attr_e( 'Email', 'monkey-budget-planner' ); ?>" required><br>
				<input name="data" id="data" type="hidden" value="">
				<button type="submit" class="btn btn-info"><?php _e( 'Send Results', 'monkey-budget-planner' ); ?></button>
			</div>
			<span class="label label-danger"><?php _e( 'Please Note. Non of your personal details or email address is stored.', 'monkey-budget-planner' ); ?></span>
		</form>
		</div>
	</div>
</div

<?php

  
}



?>