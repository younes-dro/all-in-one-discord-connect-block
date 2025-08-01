import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import {
	TabPanel,
	Panel,
	PanelBody,
	PanelRow,
	TextControl,
	ColorPicker,
} from '@wordpress/components';
import { brush, overlayText, } from '@wordpress/icons';
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
		connectButtonTextColor,
		connectButtonBgColor,
		disconnectButtonTextColor,
		disconnectButtonBgColor,
		loggedInText,
		loggedOutText,
		roleWillAssignText,
		roleAssignedText,
		discordConnectedAccountText,

	} = attributes;

	return (
		<>
			<InspectorControls>
				<div className="dro-native-tab-wrapper">
					<TabPanel
						className="dro-native-tabs"
						activeClass="is-active"
						tabs={[
							{
								name: 'settings',
								title: __('Settings', textDomain),
								icon: overlayText,
							},
							{
								name: 'style',
								title: __('Style', textDomain),
								icon: brush,
							}
						]}
					>
						{(tab) => (
							<>
								{tab.name === 'settings' && (
									<>
										<PanelBody
											title={__('Button Text Settings', textDomain)}
											initialOpen={true}
										>
											<TextControl
												label={__('Connect Button Text', textDomain)}
												value={loggedInText}
												onChange={(value) => setAttributes({ loggedInText: value })}
												placeholder={__('Connect to Discord', textDomain)}
											/>
											<TextControl
												label={__('Disconnect Button Text', textDomain)}
												value={loggedOutText}
												onChange={(value) => setAttributes({ loggedOutText: value })}
												placeholder={__('Disconnect from Discord', textDomain)}
											/>
										</PanelBody>

										<PanelBody
											title={__('Role Assignment Text', textDomain)}
											initialOpen={false}
										>
											<TextControl
												label={__('Role Will Assign Text', textDomain)}
												value={roleWillAssignText}
												onChange={(value) => setAttributes({ roleWillAssignText: value })}
												placeholder={__('You will be assigned the following Discord roles:', textDomain)}
											/>
											<TextControl
												label={__('Role Assigned Text', textDomain)}
												value={roleAssignedText}
												onChange={(value) => setAttributes({ roleAssignedText: value })}
												placeholder={__('You have been assigned the following Discord roles:', textDomain)}
											/>
										</PanelBody>
									</>
								)}

								{tab.name === 'style' && (
									<>
										<PanelBody
											title={__('Connect Button Colors', textDomain)}
											initialOpen={true}
										>
											<ColorPicker
												color={connectButtonBgColor}
												onChangeComplete={(color) => setAttributes({ connectButtonBgColor: color.hex })}
												label={__('Background Color', textDomain)}
											/>
											<ColorPicker
												color={connectButtonTextColor}
												onChangeComplete={(color) => setAttributes({ connectButtonTextColor: color.hex })}
												label={__('Text Color', textDomain)}
											/>
										</PanelBody>

										<PanelBody
											title={__('Disconnect Button Colors', textDomain)}
											initialOpen={false}
										>
											<ColorPicker
												color={disconnectButtonBgColor}
												onChangeComplete={(color) => setAttributes({ disconnectButtonBgColor: color.hex })}
												label={__('Background Color', textDomain)}
											/>
											<ColorPicker
												color={disconnectButtonTextColor}
												onChangeComplete={(color) => setAttributes({ disconnectButtonTextColor: color.hex })}
												label={__('Text Color', textDomain)}
											/>
										</PanelBody>
									</>
								)}
							</>
						)}
					</TabPanel>
				</div>

			</InspectorControls>
			<div {...useBlockProps()}>
				<div>Here will be Add-on icon</div>
				<button style={{ backgroundColor: connectButtonBgColor, color: connectButtonTextColor }} className="aio-discord-connect-button">
					<RichText
						tagName="p"
						value={loggedOutText}
						onChange={(value) => setAttributes({ loggedOutText: value })}
						placeholder={__('Connect to Discord', textDomain)}
					/>
				</button>
				<button style={{ backgroundColor: disconnectButtonBgColor, color: disconnectButtonTextColor }} className="aio-discord-disconnect-button">

					<RichText
						tagName="p"
						value={loggedInText}
						onChange={(value) => setAttributes({ loggedInText: value })}
						placeholder={__('Disconnect from Discord', textDomain)}
					/>
				</button>
				<RichText
					tagName="p"
					value={discordConnectedAccountText}
					onChange={(value) => setAttributes({ discordConnectedAccountText: value })}
				/>
				<RichText
					tagName="p"
					value={roleWillAssignText} />
				<RichText
					tagName="p"
					value={roleAssignedText} />

			</div>
		</>
	);
}
