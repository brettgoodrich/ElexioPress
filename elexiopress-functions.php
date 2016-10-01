<?php
defined( 'ABSPATH' ) or die( '' ); // Prevents direct file access
/* ElexioPress functions */

/*************************
UTILITIES
*************************/

function print_r2($val){
        echo '<pre>';
        print_r($val);
        echo  '</pre>';
}

function elexiopress() {
	return get_option('elexiopress_keys');
}

function elexiopress_getapikeys() {
	$elexiopress_settings = get_option('elexiopress_keys');
	return 'ActivationKey='.$elexiopress_settings[elexiopress_keys_activationkey]
	.'&APIPass='.$elexiopress_settings[elexiopress_keys_apipass];
}

function elexiopress_request($args) {
	if ($args['url'] && $args['body']) {
		$api_url = 'https://www.elexioamp.com/Services/Database/API.asmx/'.$args['url'];
		$request = new WP_Http;
		$response = $request->request( $api_url , array( 'method' => 'POST', 'body' => $args['body'] ) );
		return wp_remote_retrieve_body($response);
	} else {
		return '<pre>Request Func Error. ARGS: url{'.$args['url'].'} body{'.$args['body'].'}</pre>';
	}
}

/*************************
API BASE FUNCTIONS
*************************/

function elexiopress_FindPersonByName($input) {
	$args['url'] = 'FindPersonByName';
	$args['body'] = elexiopress_getapikeys();
	$args['body'] .= '&SearchString='.$input;
	$body = elexiopress_request($args);
	return $body;
}

function elexiopress_GetPerson($input) {
	$args['url'] = 'GetPerson';
	$args['body'] = elexiopress_getapikeys();
	$args['body'] .= '&ContactID='.$input;
	$body = elexiopress_request($args);
	return $body;
}
?>
