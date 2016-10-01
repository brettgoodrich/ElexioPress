<?php
defined( 'ABSPATH' ) or die( '' ); // Prevents direct file access
/* ElexioPress functions */

function elexiopress() {
	return get_option('elexiopress_keys');
}

function print_r2($val){
        echo '<pre>';
        print_r($val);
        echo  '</pre>';
}

function elexiopress_getPerson($input) {
	$elexiopress_settings = get_option('elexiopress_keys');
	$api_url = 'https://www.elexioamp.com/Services/Database/API.asmx/FindPersonByName';
	$args = 'ActivationKey='.$elexiopress_settings[elexiopress_keys_activationkey]
	.'&APIPass='.$elexiopress_settings[elexiopress_keys_apipass]
	.'&SearchString='.$input;
	$request = new WP_Http;
	$response = $request->request( $api_url , array( 'method' => 'POST', 'body' => $args ) );
	$body = wp_remote_retrieve_body($response);
	print_r2($body);
}
?>
