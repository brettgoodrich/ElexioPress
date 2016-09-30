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

function ep_getPerson($person) {
	?>
	var oPostData = {
	    ActivationKey: <?php echo $elexiopress_settings[elexiopress_keys_activationkey]; ?>,
	    APIPass: <?php echo $elexiopress_settings[elexiopress_keys_apipass]; ?>,
	    SearchString: <?php echo $person; ?>
	};

	$jQuery.ajax({
	    url: "https://www.elexioamp.com/Services/Database/API.asmx/FindPersonByName",
	    type: "POST",
	    contentType: "application/json; charset=utf-8",
	    data: JSON.stringify(oPostData),
	    dataType: "json"
	}).done(function (msg) {
	    oModel = $(msg.d);

	    oModel.each(function (index, person) {
	        var sPerson = "Contact ID: " + person.ContactID + "\n";
	        sPerson += "Display Name: " + person.DisplayName + "\n";
	        sPerson += "Household ID: " + person.HouseholdID + "\n";
	        sPerson += "Household Name: " + person.HouseholdName + "\n";
	        alert(sPerson);
	        /*
	        This will popup an alert for each person found by your query that
	        looks something like this...
	        --------------------------------------
	        Contact ID: 12345
	        Display Name: John Doe
	        Household ID: 67890
	        Household Name: Doe, John & Jane
	        */
	    });
	});
	<?php
}
?>
