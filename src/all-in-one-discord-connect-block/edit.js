import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText, BlockControls } from '@wordpress/block-editor';
import {
	TabPanel,
	Panel,
	PanelBody,
	PanelRow,
	TextControl,
	ColorPicker,
	Icon,
	ToolbarGroup,
	ToolbarButton,

} from '@wordpress/components';
import { brush, overlayText } from '@wordpress/icons';
import discordIcon from './assets/discord-icon';
import { PlayIcon, StopIcon } from './assets/play-stop-icons';
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

	const blockProps = { ...useBlockProps(), className: 'aio-discord-connect-block' };
	return (
		<div {...blockProps}>
			<BlockControls>
				<ToolbarGroup>
					<ToolbarButton
						icon={PlayIcon}
						label={__('Live Preview', 'dro-aio-discord-block')}
						onClick={() => alert('Live preview mode toggled')}
					/>
					<ToolbarButton
						icon={StopIcon}
						label={__('Stop Preview', 'dro-aio-discord-block')}
						onClick={() => alert('Preview mode toggled')}
					/>
				</ToolbarGroup>
			</BlockControls>
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
			<div {...blockProps}>
				<div className='aio-discord-connect-buttons'>
					<button style={{ backgroundColor: connectButtonBgColor, color: connectButtonTextColor }} className="aio-discord-connect-button">
						<RichText
							tagName="p"
							value={loggedInText}
							onChange={(value) => setAttributes({ loggedInText: value })}
							placeholder={__('Connect to Discord...', textDomain)}
						/>
						<Icon icon={discordIcon} />
					</button>
					<button style={{ backgroundColor: disconnectButtonBgColor, color: disconnectButtonTextColor }} className="aio-discord-connect-button">
						<RichText
							tagName="p"
							value={loggedOutText}
							onChange={(value) => setAttributes({ loggedOutText: value })}
							placeholder={__('Disconnect from Discord?', textDomain)}
						/>
						<Icon icon={discordIcon} />
					</button>
				</div>
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
		</div>
	);
}
