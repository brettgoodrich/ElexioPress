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
?>
