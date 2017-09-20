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
	 * Gets an array of generated styles and creates the minimized, inline CSS.
	 *
	 * CSS here should be formatted like $css['media_query']['element']['property'] = value.
	 *
	 * @since 1.0.0
	 * @param array $css The CSS definitions array.
	 * @return string    The generated CSS.
	 */
	public function styles_parse( $css = array() ) {

		// Process the array of CSS properties and produce the final CSS.
		$final_css = '';

		// Early exit if the CSS we want to parse is not an array.
		if ( ! is_array( $css ) || empty( $css ) ) {
			return '';
		}

		// Loop styles.
		foreach ( $css as $media_query => $styles ) {
			$final_css .= ( 'global' !== $media_query ) ? "{$media_query}{" : '';
			foreach ( $styles as $style => $style_array ) {
				$css_for_style = '';

				foreach ( $style_array as $property => $value ) {
					if ( is_string( $value ) && '' !== $value ) {
						$css_for_style .= "{$property}:{$value};";
					} elseif ( is_array( $value ) ) {
						foreach ( $value as $subvalue ) {
							$css_for_style .= ( is_string( $subvalue ) && '' !== $subvalue ) ? "{$property}:{$subvalue};" : '';
						}
					}
					$value = ( is_string( $value ) ) ? $value : '';
				}
				$final_css .= ( '' !== $css_for_style ) ? "{$style}{{$css_for_style}}" : '';
			}
			$final_css .= ( 'global' !== $media_query ) ? '}' : '';
		}
		return $final_css;
	}

	/**
	 * Add prefixes if necessary.
	 *
	 * CSS here should be formatted like $css['media_query']['element']['property'] = value.
	 *
	 * @since 1.0.0
	 * @param array $css The CSS definitions array.
	 * @return array
	 */
	public function add_prefixes( $css ) {

		if ( is_array( $css ) ) {
			foreach ( $css as $media_query => $elements ) {
				foreach ( $elements as $element => $style_array ) {
					foreach ( $style_array as $property => $value ) {

						// Add -webkit-* and -moz-*.
						$webkit_moz_properties = array(
							'border-radius',
							'box-shadow',
							'box-sizing',
							'text-shadow',
							'transform',
							'background-size',
							'transition',
							'transition-property',
						);
						if ( is_string( $property ) && in_array( $property, $webkit_moz_properties, true ) ) {
							if ( ! isset( $css[ $media_query ][ $element ][ '-webkit-' . $property ] ) ) {
								$css[ $media_query ][ $element ][ '-webkit-' . $property ] = $value;
							}
							if ( ! isset( $css[ $media_query ][ $element ][ '-moz-' . $property ] ) ) {
								$css[ $media_query ][ $element ][ '-moz-' . $property ] = $value;
							}
						}

						// Add -ms-* and -o-*.
						$ms_o_properties = array(
							'transform',
							'background-size',
							'transition',
							'transition-property',
						);
						if ( is_string( $property ) && in_array( $property, $ms_o_properties, true ) ) {
							if ( ! isset( $css[ $media_query ][ $element ][ '-ms-' . $property ] ) ) {
								$css[ $media_query ][ $element ][ '-ms-' . $property ] = $value;
							}
							if ( ! isset( $css[ $media_query ][ $element ][ '-o-' . $property ] ) ) {
								$css[ $media_query ][ $element ][ '-o-' . $property ] = $value;
							}
						}
					}
				}
			} // End foreach().
		} // End if().

		return $css;
	}
}
