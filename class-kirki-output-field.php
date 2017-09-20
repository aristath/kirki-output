<?php
/**
 * Handle getting CSS from a field.
 *
 * @package     Kirki
 * @subpackage  Modules
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0.0
 */

/**
 * Handle getting CSS from a field.
 */
class Kirki_Output_Field {

	/**
	 * The instance of the Kirki_Output object for this config-id.
	 *
	 * @since 1.0.0
	 * @var object
	 */
	protected $output_obj;

	/**
	 * The field arguments.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $field;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 * @param string $config_id The config-ID.
	 * @param array  $field     The field arguments.
	 */
	public function __construct( $config_id, $field ) {
		$this->$output_obj = Kirki_Output::get_instance( $config_id );
		$this->field       = $field;

		$css_array = $this->create_css_array();
		$this->output_obj->add_css_to_array( $css_array );
	}

	/**
	 * Creates the CSS array from the field.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	protected function create_css_array() {
		return array();
	}
}
