import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import {
	PanelBody,
	TextControl,
	ColorPicker,
} from '@wordpress/components';
import './editor.scss';

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
				<PanelBody title={__('Discord Button Settings', 'dro-aio-dcc-block')} initialOpen={true}>
					<ColorPicker
						label={__('Button Color', 'dro-aio-dcc-block')}
						color={btnColor}
						onChangeComplete={(value) => setAttributes({ btnColor: value.hex })}
						disableAlpha
					/>
					<TextControl
						label={__('Logged-in Button Text', 'dro-aio-dcc-block')}
						value={loggedInText}
						onChange={(value) => setAttributes({ loggedInText: value })}
					/>
					<TextControl
						label={__('Logged-out Button Text', 'dro-aio-dcc-block')}
						value={loggedOutText}
						onChange={(value) => setAttributes({ loggedOutText: value })}
					/>
					<TextControl
						label={__('Disconnect Button Text', 'dro-aio-dcc-block')}
						value={disconnectText}
						onChange={(value) => setAttributes({ disconnectText: value })}
					/>
				</PanelBody>
			</InspectorControls>

			<div {...useBlockProps()}>
				<p>{__('Preview:', 'dro-aio-dcc-block')}</p>
				<button style={{ backgroundColor: btnColor }}>
					{loggedInText}
				</button>
			</div>
		</>
	);
}
