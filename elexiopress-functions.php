<?php
defined( 'ABSPATH' ) or die( '' ); // Prevents direct file access
/* ElexioPress functions */

/*************************
UTILITIES
*************************/

function print_r2($val){
        echo '<pre style="color:white !important;">';
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
		$result = new SimpleXMLElement(wp_remote_retrieve_body($response));
		return $result;
	} else {
		return '<pre>Request Func Error. ARGS: url{'.$args['url'].'} body{'.$args['body'].'}</pre>';
	}
}

/*************************
API BASE FUNCTIONS
*************************/

function elexiopress_FindPersonByName($name) {
	$args['url'] = 'FindPersonByName';
	$args['body'] = elexiopress_getapikeys();
	$args['body'] .= '&SearchString='.$name;
	$body = elexiopress_request($args);
	// If no people matched the name, tell the user.
	if (empty($body)) {
		return "No matches for \"$name\" found.";
	} else {
		return $body;
	}
}

function elexiopress_GetPerson($personID) {
	if (is_numeric($personID)) { // If a numeric ID was not given, throw error
		$args['url'] = 'GetPerson';
		$args['body'] = elexiopress_getapikeys();
		$args['body'] .= '&ContactID='.$personID;
		$body = elexiopress_request($args);
		return $body;
	} else {
		 return 'ERROR: Input must be Elexio ID number. If searching by name, use elexiopress_FindPersonByName() '.'<pre>Request Func Error. ARGS: url{'.$args['url'].'} body{'.$args['body'].'}</pre>';;
	}
}

function elexiopress_FindEventsByDate($startDate = false, $endDate = false, $reqTag = '', $forbiddenTag1 = '', $forbiddenTag2 = '') {
	$didFail = '';
	$args['url'] = 'FindEventsByDate';
	$args['body'] = elexiopress_getapikeys();
	if ($startDate) { $args['body'] .= '&StartDate='.$startDate; 	} else { $didFail .= "\nERROR: startDate missing\n"; }
	if ($endDate) 	{ $args['body'] .= '&EndDate='.$endDate; 			} else { $didFail .= "\nERROR: endDate missing\n"; }
	$args['body'] .= '&MustBeTagged='.$reqTag;
	$args['body'] .= '&MustNotBeTagged='.$forbiddenTag1;
	$args['body'] .= '&MustNotBeTagged='.$forbiddenTag2;
	if (!$didFail) {
		$body = elexiopress_request($args);
		return $body;
	} else {
		return $didFail;
	}
}

function elexiopress_LookupCodes($code) {
	if (	$code == 6 	|| 	// AgeGroup
				$code == 30 ||	// Campus
				$code == 9 	||	// FamilyPosition
				$code == 8 	||	// FamilyType
				$code == 21	||	// Fund
				$code == 31	||	// GivingMethod
				$code == 11 ||	// MaritalStatus
				$code == 5			// Status
	) {
		$args['url'] = 'LookupCodes';
		$args['body'] = elexiopress_getapikeys();
		$args['body'] .= '&CodeType='.$code;
		$body = elexiopress_request($args);
		return $body;
	} else {
		return '<pre>Request Func Error. ARGS: url{'.$args['url'].'} body{'.$args['body'].'}</pre>';
	}
}

?>
