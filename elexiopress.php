<?php
defined( 'ABSPATH' ) or die( '' ); // Prevents direct file access
/*
Plugin Name: ElexioPress
Description: System to connect Elexio data to WordPress
Version:     0.1
Author:      Brett Goodrich
Author URI:  brettgoodrich.com
*/

function elexiopress() {
	return get_option('elexiopress_keys');
}

class ElexioPress
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        add_submenu_page(
						'edit.php', // Goes under Posts
            'ElexioPress', // Title that goes in h2 on settings page
            'ElexioPress', // Title that goes into the WordPress nav menu
            'manage_options', // User permissions required to see, access, and edit this settings page
            'elexiopress_menu', // The slug to refer to this menu by
            array( $this, 'create_admin_page' ) // Callback function that creates the settings page. $this makes it look in this class for the function.
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'elexiopress_data' );
        ?>
        <div class="wrap">
            <h2>ElexioPress</h2>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'elexiopress_keys_group' );
                do_settings_sections( 'elexiopress_menu' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'elexiopress_keys_group', // Option group
            'elexiopress_keys', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'elexiopress_keys_section', // ID
            'ElexioPress Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'elexiopress_menu' // Page
        );

        add_settings_field(
            'elexiopress_keys_activationkey', // ID
            'Elexio ActivationKey', // Title
            array( $this, 'elexiopress_keys_activationkey_callback' ), // Callback
            'elexiopress_menu', // Page
            'elexiopress_keys_section' // Section
        );

        add_settings_field(
            'elexiopress_keys_apipass',
            'Elexio APIPass',
            array( $this, 'elexiopress_keys_apipass_callback' ),
            'elexiopress_menu',
            'elexiopress_keys_section'
        );

        add_settings_field(
            'alert_enbl',
            'Enabled',
            array( $this, 'alert_enbl_callback' ),
            'elexiopress_menu',
            'elexiopress_keys_section'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['elexiopress_keys_activationkey'] ) )
            $new_input['elexiopress_keys_activationkey'] = sanitize_text_field( $input['elexiopress_keys_activationkey'] );

        if( isset( $input['elexiopress_keys_apipass'] ) )
            $new_input['elexiopress_keys_apipass'] = sanitize_text_field( $input['elexiopress_keys_apipass'] );

        if( isset( $input['alert_enbl'] ) )
            $new_input['alert_enbl'] = absint( $input['alert_enbl'] );

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Your Elexio API information.';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function elexiopress_keys_activationkey_callback()
    {
        printf(
            '<input type="text" id="elexiopress_keys_activationkey" name="elexiopress_keys[elexiopress_keys_activationkey]" value="%s" />',
            isset( $this->options['elexiopress_keys_activationkey'] ) ? esc_attr( $this->options['elexiopress_keys_activationkey']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function elexiopress_keys_apipass_callback()
    {
        printf(
            '<input type="text" id="elexiopress_keys_apipass" name="elexiopress_keys[elexiopress_keys_apipass]" value="%s" style="width:90%%;" />',
            isset( $this->options['elexiopress_keys_apipass'] ) ? esc_attr( $this->options['elexiopress_keys_apipass']) : ''
        );
    }

    public function alert_enbl_callback()
    {
		echo '<input type="checkbox" id="alert_enbl" name="elexiopress_keys[alert_enbl]" value="1"';
//		print_r($this->options['alert_enbl']);
		if($this->options['alert_enbl']) echo ' checked="checked"';
		echo '/> Enabled if checked';
    }

}

if( is_admin() )
    $my_settings_page = new ElexioPress();
