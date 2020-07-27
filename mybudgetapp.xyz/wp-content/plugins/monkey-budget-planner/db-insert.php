<?php
function update_budget(){
	global $wpdb;
	$current_user_id = get_current_user_id();

	$income_table_name = $wpdb->prefix . "mb_income";
	$outgoings_table_name = $wpdb->prefix . "mb_outgoings";
	
	//clear current budgets
	$wpdb->delete($income_table_name, array('uid' => $current_user_id));
	$wpdb->delete($outgoings_table_name, array('uid' => $current_user_id));
	
	//load new budgets
	$new_income_budget_array = json_decode(stripslashes($_POST['income_data']));
	$new_outgoings_budget_array = json_decode(stripslashes($_POST['outgoings_data']));
	
	foreach($new_income_budget_array as $key => $value){
		$wpdb->insert(
			$income_table_name,
			array(
				'uid' => $current_user_id,
				'category' => $key,
				'amount' => $value,
			)
		);
	}
	
	foreach($new_outgoings_budget_array as $key => $value){
		$wpdb->insert(
			$outgoings_table_name,
			array(
				'uid' => $current_user_id,
				'category' => $key,
				'amount' => $value,
			)
		);
	}	
	
	//better error handle needed
	//die();
	//header("Location: https://www.mybudgetapp.xyz/");
	//$url = "https://www.mybudgetapp.xyz/";
	//wp_redirect( $url );
	//exit();
}
?>