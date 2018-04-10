<?php
require_once('../../../../wp-config.php');
global $wpdb;

$table_name = $wpdb->base_prefix . 'seasonal_custom_css';

$type = $_GET['type'];

$base_url      = 'http://rblarsen.dk/';
$format        = '';
$product_id    = 'SCCSS';
$instance      = 'seasonal-custom-css';
$secret_key    = 'XvZc7v23ojIxVsS';
$order_id	   = '';

function execute_request( $args ) {
	$target_url = create_url( $args );
	$data = wp_remote_get( $target_url );
	var_dump( $data['body'] );
}

function create_url( $args ) {
	global $base_url;
	$base_url = add_query_arg( 'wc-api', 'software-api', $base_url );
	return $base_url . '&' . http_build_query( $args );
}

//Sends
if($type == 'edit'){
  $wpdb->update( 
      $table_name, 
      array( 
        'name' => $_POST['name'], 
        'custom_css' => strip_tags($_POST['text']), 
        'from_date' => date("Y-m-d", strtotime("1970-".$_POST['date-from-month']."-".$_POST['date-from-day'])), 
        'to_date' => date("Y-m-d", strtotime("1970-".$_POST['date-to-month']."-".$_POST['date-to-day'])), 
      ),
      array(
        'id' => $_POST['id'],
      )
  );
  
  $url = '/wp-admin/options-general.php?page=seasonal-custom-css';
}
else if($type == 'delete')
{
  $wpdb->delete( $table_name, array( 'ID' => $_GET['id'] ) );
  $url = '/wp-admin/options-general.php?page=seasonal-custom-css';
}
else if($type == 'activate_license')
{
  $args = array(
    'request'     => 'activation',
    'email'       => $_POST['api-email'],
    'licence_key' => $_POST['api-license'],
    'product_id'  => $product_id,
  );

  echo '<b>Valid activation request:</b><br />';
  execute_request( $args );
}
else
{
  $wpdb->insert( 
      $table_name, 
      array( 
        'name' => $_POST['name-new'], 
        'custom_css' => strip_tags($_POST['text-new']), 
        'from_date' => date("Y-m-d", strtotime("1970-".$_POST['date-from-month-new']."-".$_POST['date-from-day-new'])), 
        'to_date' => date("Y-m-d", strtotime("1970-".$_POST['date-to-month-new']."-".$_POST['date-to-day-new'])), 
      ) 
  );
  
  $url = '/wp-admin/options-general.php?page=seasonal-custom-css';
}
  
header("Location: $url");
?>
