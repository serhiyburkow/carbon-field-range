/**
 * External dependencies.
 */
import { Component } from '@wordpress/element';

class RangeField extends Component {
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
			<div id={id} className="cf-range__wrapper">
				<input
					type="number"
					name={`${name}[from]`}
					value={value.from}
					max={field.max}
					min={field.min}
					step={field.step}
					className="cf-range__input"
					onChange={this.handleChange}
				/>
				<input
					type="number"
					name={`${name}[to]`}
					value={value.to}
					max={field.max}
					min={field.min}
					step={field.step}
					className="cf-range__input"
					onChange={this.handleChange}
				/>
			</div>
		);
	}
}

export default RangeField;
