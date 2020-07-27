<?php
function jal_install() {
   global $wpdb;

   $table_name_income = $wpdb->prefix . "mb_budgets_income"; 
   $table_name_outgoing = $wpdb->prefix . "mb_budgets_outgoing";

   create_table($table_name_income);
   create_table($table_name_outgoing);

   die();
}

function create_table($table_name){

   $charset_collate = $wpdb->get_charset_collate();
   $sql = "CREATE TABLE $table_name (
       uid int,
       category varchar(100),
       amount int
   ) $charset_collate;";

   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   dbDelta( $sql );
}
?>