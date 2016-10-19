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

function reduceToNumber($input) {
	return preg_replace("/[^0-9]/","", $input);
	/* Found on StackOverflow: http://stackoverflow.com/questions/6604455/php-code-to-remove-everything-but-numbers */
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
// Other ways to call the same function
function elexiopress_FindPerson($input) {	return elexiopress_FindPersonByName($input); }


function elexiopress_FindPersonByEmail($email) {
	$args['url'] = 'FindPersonByEmail';
	$args['body'] = elexiopress_getapikeys();
	$args['body'] .= '&SearchString='.$email;
	$body = elexiopress_request($args);
	// If no people matched the name, tell the user.
	if (empty($body)) {
		return "No matches for email: $email found.";
	} else {
		return $body;
	}
}


function elexiopress_FindPersonByPhoneNumber($number) {
	$number = reduceToNumber($number);
	$args['url'] = 'FindPersonByPhoneNumber';
	$args['body'] = elexiopress_getapikeys();
	$args['body'] .= '&SearchString='.$number;
	$body = elexiopress_request($args);
	// If no people matched the name, tell the user.
	if (empty($body)) {
		return "No matches for $number found.";
	} else {
		return $body;
	}
}
// Other ways to call the same function
function elexiopress_FindPersonByPhone($number) {	return elexiopress_FindPersonByPhoneNumber($number); }


function elexiopress_FindHouseholdByName($email) {
	// Elexio's API actually searches for email matches, not name matches. Don't ask me!
	$args['url'] = 'FindHouseholdByName';
	$args['body'] = elexiopress_getapikeys();
	$args['body'] .= '&SearchString='.$email;
	$body = elexiopress_request($args);
	// If no households matched the email, tell the user.
	if (empty($body)) {
		return "No households with \"$email\" found. Note that this function actually requires an email, not a name.";
	} else {
		return $body;
	}
}
// Other ways to call the same function
function elexiopress_FindHouseholdByEmail($email) {	return elexiopress_FindHouseholdByName($email); }
function elexiopress_FindHouseByEmail($email) {			return elexiopress_FindHouseholdByName($email); }
function elexiopress_FindFamilyByEmail($email) {		return elexiopress_FindHouseholdByName($email); }


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
// Other ways to call the same function
function elexiopress_FindPersonByID($input) {	return elexiopress_GetPerson($input); }


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


function elexiopress_GetEventOccurrenceByID($eventid) {
	$args['url'] = 'GetEventOccurrenceByID';
	$args['body'] = elexiopress_getapikeys();
	$args['body'] .= '&EventOccurrenceID='.$eventid;
	$body = elexiopress_request($args);
	return $body;
}
// Other ways to call the same function
function elexiopress_GetEventOcurrenceByID($eventid) { 		return elexiopress_GetEventOccurrenceByID($eventid); }
function elexiopress_GetEventOccurenceByID($eventid) { 		return elexiopress_GetEventOccurrenceByID($eventid); }
function elexiopress_GetEventOcurenceByID($eventid) { 		return elexiopress_GetEventOccurrenceByID($eventid); }
function elexiopress_GetEventByID($eventid) { 						return elexiopress_GetEventOccurrenceByID($eventid); }
function elexiopress_FindEventOccurrenceByID($eventid) {	return elexiopress_GetEventOccurrenceByID($eventid); }
function elexiopress_FindEventOcurrenceByID($eventid) { 	return elexiopress_GetEventOccurrenceByID($eventid); }
function elexiopress_FindEventOccurenceByID($eventid) { 	return elexiopress_GetEventOccurrenceByID($eventid); }
function elexiopress_FindEventOcurenceByID($eventid) { 		return elexiopress_GetEventOccurrenceByID($eventid); }
function elexiopress_FindEventByID($eventid) {						return elexiopress_GetEventOccurrenceByID($eventid); }


function elexiopress_GetSmallGroups() {
	$args['url'] = 'GetSmallGroups';
	$args['body'] = elexiopress_getapikeys();
	$body = elexiopress_request($args);
	return $body;
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
		return '<pre>Invalid LookupCode. ARGS: url{'.$args['url'].'} body{'.$args['body'].'}</pre>';
	}
}
// Other ways to call the same function
function elexiopress_LookupCode($input) {	return elexiopress_LookupCodes($input); }

?>
