<?php
/*
Plugin Name: Advanced Custom Fields: Code Area
Plugin URI: https://github.com/taylormsj/acf-code_area-field
Description: Adds a 'Code Area' textarea editor to the Advanced Custom Fields WordPress plugin.
Version: 1.0.1
Author: Taylor Mitchell-St.Joseph
Author URI: https://taylormitchellstjoseph.co.uk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

class acf_field_code_area_plugin {

	function __construct() {
		// version 5
		add_action('acf/include_field_types', array($this, 'include_field_types'));

		// version 4
		add_action('acf/register_fields', array($this, 'register_fields'));

	}

	// version 4
    function register_fields() {
		include_once('acf_code_area-v4.php');
	}

	// version 5
	function include_field_types( $version ) {
		include_once('acf_code_area-v5.php');
	}

}

new acf_field_code_area_plugin();

?>