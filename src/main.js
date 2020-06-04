/**
 * External dependencies.
 */
import { Component } from '@wordpress/element';

class NumberField extends Component {
	/**
	 * Handles the change of the input.
	 *
	 * @param  {Object} e
	 * @return {void}
	 */
	handleChange = ( e ) => {
		const { id, onChange } = this.props;

		onChange( id, e.target.value );
	}

	/**
	 * Render a range input field.
	 *
	 * @return {Object}
	 */
	render() {
		const {
			id,
			name,
			value,
			field
		} = this.props;
		const { handleChange } = this;

		return (
			<input
				type="range"
				id={id}
				name={name}
				value={value}
				max={field.max}
				min={field.min}
				step={field.step}
				className="cf-range__input"
				onChange={this.handleChange}
			/>
		);
	}
}

export default RangeField;
