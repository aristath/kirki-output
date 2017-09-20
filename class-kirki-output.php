<?php
/**
 * The main Kirki_Output class.
 *
 * @package     Kirki
 * @subpackage  Modules
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0.0
 */

/**
 * The main Kirki_Output class.
 */
class Kirki_Output {

	/**
	 * An array of instances.
	 *
	 * We've got 1 instance per config.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private static $instances = array();

	/**
	 * The CSS.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	private $css = '';

	/**
	 * The CSS array.
	 *
	 * CSS here should be formatted like $css['media_query']['element']['property'] = value.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $css_array = array();

	/**
	 * The Kirki_Output_Parser object.
	 *
	 * @since 1.0.0
	 * @var object
	 */
	public $parser;

	/**
	* The Kirki_Output_Field object.
	 *
	 * @since 1.0.0
	 * @var object
	 */
	public $field;

	/**
	 * The class constructor.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {
		$this->parser = new Kirki_Output_Parser();
	}

	/**
	 * Gets the instance for this config-id.
	 * If the instance doesn't already exist, it creates one.
	 *
	 * @since 1.0.0
	 * @param string $config_id The config-id.
	 * @return object
	 */
	public static function get_instance( $config_id ) {
		if ( ! isset( self::$instances[ $config_id ] ) ) {
			self::$instances[ $config_id ] = new self();
		}
		return self::$instances[ $config_id ];
	}

	/**
	 * Add CSS.
	 *
	 * @since 1.0.0
	 * @param string $css The CSS to add.
	 * @return void
	 */
	public function append_css( $css ) {
		$this->css .= $css;
	}

	/**
	 * Get the CSS.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_css() {
		return $this->css;
	}

	/**
	 * Add CSS rules to the $css_array property.
	 *
	 * @since 1.0.0
	 * @param array $css The css array to add.
	 * @return void
	 */
	public function add_css_to_array( $css ) {
		$this->css_array = array_replace_recursive( $this->css_array, $css );
	}

	/**
	 * Get the css array.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_css_array() {
		return $this->css_array;
	}

	/**
	 * Generates the CSS.
	 *
	 * @since 1.0.0
	 */
	public function generate_css() {
		$this->css = $this->parser->styles_parse( $this->parser->add_prefixes( $this->css_array ) );
	}
}
