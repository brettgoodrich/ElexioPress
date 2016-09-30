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
	$api_url = 'https://www.elexioamp.com/Services/Database/API.asmx/FindPersonByName';
	$headers = 'ActivationKey='.$elexiopress_settings['elexiopress_keys_activationkey']
	.'&APIPass='.$elexiopress_settings['elexiopress_keys_apipass']
	.'SearchString'.$input;
	$request = new WP_Http;
	$result = $request->request( $api_url , array( 'method' => 'POST', 'headers' => $headers ) );
	print_r2($result);
}
?>
