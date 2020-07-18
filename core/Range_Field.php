<?php

namespace Carbon_Field_Range;

use Carbon_Fields\Field\Field;
use Carbon_Fields\Value_Set\Value_Set;

class Range_Field extends Field {

	/**
	 * Minimum value
	 *
	 * @var null|float
	 */
	protected $min = null;

	/**
	 * Maximum value
	 *
	 * @var null|float
	 */
	protected $max = null;

	/**
	 * Step/interval between allowed values
	 *
	 * @var null|float
	 */
	protected $step = null;

	protected $default_value = [
		'from' => '1',
		'to' => '1000000',
	];

	public function __construct($type, $name, $label)
	{
		$this->set_value_set(new Value_Set(
			Value_Set::TYPE_MULTIPLE_PROPERTIES,
			[
				'from' => '',
				'to' => '',
			]
		));
		parent::__construct($type, $name, $label);
	}


	/**
	 * Prepare the field type for use
	 * Called once per field type when activated
	 */
	public static function field_type_activated() {
		$dir = \Carbon_Field_Range\DIR . '/languages/';
		$locale = get_locale();
		$path = $dir . $locale . '.mo';
		load_textdomain( 'carbon-field-range', $path );
	}

	/**
	 * Enqueue scripts and styles in admin
	 * Called once per field type
	 */
	public static function admin_enqueue_scripts() {
		$root_uri = \Carbon_Fields\Carbon_Fields::directory_to_url( \Carbon_Field_Range\DIR );

		// Enqueue field styles.
		wp_enqueue_style(
			'carbon-field-range',
			$root_uri . '/build/bundle' . ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min' ) . '.css'
		);

		// Enqueue field scripts.
		wp_enqueue_script(
			'carbon-field-range',
			$root_uri . '/build/bundle' . ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min' ) . '.js',
			array( 'carbon-fields-core' )
		);
	}

	/**
	 * Load the field value from an input array based on its name
	 *
	 * @param array $input Array of field names and values.
	 */
	public function set_value_from_input( $input ) {
		parent::set_value_from_input( $input );

		if ( ! isset($input[ $this->get_name() ])) {
			$this->set_value(null);

			return $this;
		}

		$value_set = [
			'from' => '',
			'to' => '',
		];

		foreach ($value_set as $key => $v) {
			if (isset($input[ $this->get_name() ][ $key ])) {
				$value_set[ $key ] = $input[ $this->get_name() ][ $key ];
			}
		}

		$value = floatval( $value );

		if ( $this->min !== null ) {
			$value_set['from'] = max( $value_set['from'], $this->min );
		}

		if ( $this->max !== null ) {
			$value_set['to'] = min( $value_set['from'], $this->max );
		}

		// Check if step change is correct

//		if ( $this->step !== null ) {
//			$step_base = ( $this->min !== null ) ? $this->min : 0;
//			$is_valid_step_value = ( $value['from'] - $step_base ) % $this->step === 0;
//			if ( ! $is_valid_step_value ) {
//				$value['from'] = $step_base; // value is not valid - reset it to a base value
//			}
//
//			$step_base = ( $this->max !== null ) ? $this->min : 0;
//			$is_valid_step_value = ( $value['to'] - $step_base ) % $this->step === 0;
//			if ( ! $is_valid_step_value ) {
//				$value['to'] = $step_base; // value is not valid - reset it to a base value
//			}
//		}

		$value_set[ 'from' ] = (string)$value_set[ 'from' ];
		$value_set[ 'to' ] = (string)$value_set[ 'to' ];

		$this->set_value($value_set);

		return $this;
	}

	/**
	 * Returns an array that holds the field data, suitable for JSON representation.
	 *
	 * @param bool $load  Should the value be loaded from the database or use the value from the current instance.
	 * @return array
	 */
	public function to_json( $load ) {
		$field_data = parent::to_json( $load );
		$value_set  = $this->get_value();

		$field_data = array_merge( $field_data, array(
			'value' => [
				'from' => $value_set[ 'from' ],
				'to'     => $value_set[ 'to' ],
			],
			'min' => $this->min,
			'max' => $this->max,
			'step' => $this->step,
		) );

		return $field_data;
	}

	/**
	 * Set field minimum value. Default: null
	 *
	 * @param  null|float $min
	 * @return self       $this
	 */
	function set_min( $min ) {
		$this->min = floatval( $min );
		return $this;
	}

	/**
	 * Set field maximum value. Default: null
	 *
	 * @param  null|float $max
	 * @return self       $this
	 */
	function set_max( $max ) {
		$this->max = floatval( $max );
		return $this;
	}

	/**
	 * Set field step value. Default: null
	 *
	 * @param  null|float $step
	 * @return self       $this
	 */
	function set_step( $step ) {
		$this->step = floatval( $step );
		return $this;
	}
}
