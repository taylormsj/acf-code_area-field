<?php

class acf_field_code_area extends acf_field {

	public $settings = array();

	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	function __construct() {

		$this->name     = 'code_area';
		$this->label    = __( 'Code Area' );
		$this->category = __( "Content", 'acf' );

		$this->settings = array(
			'path'    => apply_filters( 'acf/helpers/get_path', __FILE__ ),
			'dir'     => apply_filters( 'acf/helpers/get_dir', __FILE__ ),
			'version' => '1.0.0'
		);

		$this->defaults = array();

		parent::__construct();
	}

	/*
	*  render_field_settings()
	*
	*  Create extra settings for your field. These are visible when editing a field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	function render_field_settings( $field ) {

		acf_render_field_setting( $field, array(
			'label'        => __( 'Language', 'acf' ),
			'instructions' => '',
			'type'         => 'radio',
			'name'         => 'language',
			'choices'      => array(
				'Plain'      => __( 'Plain', 'acf' ),
				'css'        => __( 'CSS', 'acf' ),
				'javascript' => __( 'Javascript', 'acf' ),
				'htmlmixed'  => __( 'HTML', 'acf' ),
				'php'        => __( 'PHP', 'acf' ),
			)
		) );

		acf_render_field_setting( $field, array(
			'label'        => __( 'Theme', 'acf' ),
			'instructions' => __( 'Set a theme for the editor (<a href="http://codemirror.net/demo/theme.html" target="_blank">Preview Here</a>) ', 'acf' ),
			'type'         => 'select',
			'name'         => 'theme',
			'choices'      => array(
				'default'     => __( "Default", 'acf' ),
				'ambiance'    => __( "Ambiance", 'acf' ),
				'blackboard'  => __( "Blackboard", 'acf' ),
				'cobalt'      => __( "Cobalt", 'acf' ),
				'eclipse'     => __( "Eclipse", 'acf' ),
				'elegant'     => __( "Elegant", 'acf' ),
				'erlang-dark' => __( "Erlang Dark", 'acf' ),
				'lesser-dark' => __( "Lesser Dark", 'acf' ),
				'material'    => __( 'Material', 'acf' ),
				'midnight'    => __( "Midnight", 'acf' ),
				'monokai'     => __( "Monokai", 'acf' ),
				'neat'        => __( "Neat", 'acf' ),
				'night'       => __( "Night", 'acf' ),
				'rubyblue'    => __( "Rubyblue", 'acf' ),
				'solarized'   => __( "Solarized", 'acf' ),
				'twilight'    => __( "Twilight", 'acf' ),
				'vibrant-ink' => __( "Vibrant Ink", 'acf' ),
				'xq-dark'     => __( "XQ Dark", 'acf' ),
				'xq-light'    => __( "XQ Light", 'acf' ),
			)
		) );

		acf_render_field_setting( $field, array(
			'label'        => __( 'Show language info', 'acf' ),
			'instructions' => '',
			'type'         => 'radio',
			'name'         => 'show_info',
			'choices'      => array(
				'yes' => __( 'Yes', 'acf' ),
				'no'  => __( 'No', 'acf' ),
			)
		) );

	}

	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	function render_field( $field ) {

		$field['value'] = esc_textarea( $field['value'] );

		$language = '';
		switch ( $field['language'] ) {
			case 'plain':
				$language = 'Plain';
				break;
			case 'css':
				$language = 'CSS';
				break;
			case 'javascript':
				$language = 'Javascript';
				break;
			case 'htmlmixed':
				$language = 'HTML';
				break;
			case 'php':
				$language = 'PHP';
				break;
			default:
				$language = 'Plain';
		}

		echo '<textarea id="' . $field['id'] . '" rows="4" class="' . $field['class'] . '" name="' . $field['name'] .
		     '" data-language="' . $field['language'] . '" data-theme="' . $field['theme'] . '">' . $field['value'] . '</textarea>';

		if ( $field['show_info'] === 'yes' ) {
			echo '<p style="margin-bottom:0;"><small>You are writing ' . $language . ' code.</small></p>';
		}

		if ( $field['theme'] !== 'default' ): ?>
			<link rel="stylesheet"
			      href="<?php echo plugin_dir_url( __FILE__ ) ?>/css/theme/<?php echo $field["theme"] ?>.css">
		<?php endif;
	}

	/**
	 * input_admin_enqueue_scripts
	 *
	 * Enqueue admin scripts 
	 */
	function input_admin_enqueue_scripts() {

		$dir = plugin_dir_url( __FILE__ );

		if ( SCRIPT_DEBUG ) {
			$this->enqueue_full_scripts( $dir );
		} else {
			$this->enqueue_prod_scripts( $dir );
		}
	}

	/**
	 * Enqueue not minified scripts
	 *
	 * @param $dir
	 */
	private function enqueue_full_scripts( $dir ) {
		wp_register_script( 'acf-input-code_area-code_mirror_js', $dir . 'js/codemirror.js', array( 'acf-input' ), acf_field_code_area_plugin::$version );
		wp_register_script( 'acf-input-code_area-code_mirror_mode_js', $dir . 'js/mode/javascript.js', array( 'acf-input' ), acf_field_code_area_plugin::$version );
		wp_register_script( 'acf-input-code_area-code_mirror_mode_css', $dir . 'js/mode/css.js', array( 'acf-input' ), acf_field_code_area_plugin::$version );
		wp_register_style( 'acf-input-code_area-code_mirror_css', $dir . 'css/codemirror.css', array( 'acf-input' ), acf_field_code_area_plugin::$version );
		wp_register_script( 'acf-input-code_area-code_mirror_mode_html', $dir . 'js/mode/htmlmixed.js', array( 'acf-input' ), acf_field_code_area_plugin::$version );
		wp_register_script( 'acf-input-code_area-code_mirror_mode_xml', $dir . 'js/mode/xml.js', array( 'acf-input' ), acf_field_code_area_plugin::$version );
		wp_register_script( 'acf-input-code_area-code_mirror_mode_php', $dir . 'js/mode/php.js', array( 'acf-input' ), acf_field_code_area_plugin::$version );
		wp_register_script( 'acf-input-code_area-code_mirror_mode_clike', $dir . 'js/mode/clike.js', array( 'acf-input' ), acf_field_code_area_plugin::$version );
		wp_register_script( 'acf-input-code_area-code_xml-fold', $dir . 'js/addon/xml-fold.js', array( 'acf-input' ), acf_field_code_area_plugin::$version );
		wp_register_script( 'acf-input-code_area-code_mirror_addon_matchtags', $dir . 'js/addon/matchtags.js', array( 'acf-input' ), acf_field_code_area_plugin::$version );
		wp_register_script( 'acf-input-code_area-field', $dir . 'js/acf-code_area.js', array( 'acf-input' ), acf_field_code_area_plugin::$version );

		// scripts
		wp_enqueue_script( array(
			'acf-input-code_area-code_mirror_js',
			'acf-input-code_area-code_mirror_mode_js',
			'acf-input-code_area-code_mirror_mode_css',
			'acf-input-code_area-code_mirror_mode_html',
			'acf-input-code_area-code_mirror_mode_xml',
			'acf-input-code_area-code_mirror_mode_php',
			'acf-input-code_area-code_mirror_mode_clike',
			'acf-input-code_area-code_xml-fold',
			'acf-input-code_area-code_mirror_addon_matchtags',
			'acf-input-code_area-field'
		) );

		// styles
		wp_enqueue_style( array(
			'acf-input-code_area-code_mirror_css',
		) );
	}

	/**
	 * Enqueue minified scripts
	 *
	 * @param $dir
	 */
	private function enqueue_prod_scripts( $dir ) {
		wp_register_script( 'acf-input-code_area-field', $dir . 'js/acf-code_area.min.js', array(), acf_field_code_area_plugin::$version );
		wp_register_style( 'acf-input-code_area-code_mirror_css', $dir . 'css/codemirror.min.css', array(), acf_field_code_area_plugin::$version );

		wp_enqueue_script( 'acf-input-code_area-field' );
		wp_enqueue_style( 'acf-input-code_area-code_mirror_css' );
	}

}