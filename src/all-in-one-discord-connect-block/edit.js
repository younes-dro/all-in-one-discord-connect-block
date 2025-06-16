import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import {
	PanelBody,
	TextControl,
	ColorPicker,
} from '@wordpress/components';
import './editor.scss';

const textDomain = 'dro-aio-discord-block';
/**
 * Edit function for the All In One Discord Connect Block.
 *
 * @param {Object} props - The block properties.
 * @param {Object} props.attributes - The block attributes.
 * @param {Function} props.setAttributes - Function to update block attributes.
 * @returns {JSX.Element} The block edit interface.
 *
 * @since 1.0.0
 * @version 1.0.0
 */

export default function Edit({ attributes, setAttributes }) {
	const {
		btnColor,
		loggedInText,
		loggedOutText,
		disconnectText
	} = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Discord Button Settings', textDomain)} initialOpen={true}>
					<ColorPicker
						label={__('Button Color', textDomain)}
						color={btnColor}
						onChangeComplete={(value) => setAttributes({ btnColor: value.hex })}
						disableAlpha
					/>
					<TextControl
						label={__('Logged-in Button Text', textDomain)}
						value={loggedInText}
						onChange={(value) => setAttributes({ loggedInText: value })}
					/>
					<TextControl
						label={__('Logged-out Button Text', textDomain)}
						value={loggedOutText}
						onChange={(value) => setAttributes({ loggedOutText: value })}
					/>
					<TextControl
						label={__('Disconnect Button Text', textDomain)}
						value={disconnectText}
						onChange={(value) => setAttributes({ disconnectText: value })}
					/>
				</PanelBody>
			</InspectorControls>

			<div {...useBlockProps()}>
				<p>{__('Preview:', textDomain)}</p>
				<button style={{ backgroundColor: btnColor }}>
					{loggedInText}
				</button>
			</div>
		</>
	);
}
