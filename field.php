<?php
use Carbon_Fields\Carbon_Fields;
use Carbon_Field_Range\Range_Field;

define( 'Carbon_Field_Range\\DIR', __DIR__ );

Carbon_Fields::extend( Range_Field::class, function( $container ) {
	return new Range_Field( $container['arguments']['type'], $container['arguments']['name'], $container['arguments']['label'] );
} );