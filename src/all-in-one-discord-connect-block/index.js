
import { registerBlockType } from '@wordpress/blocks';
import './style.scss';
import discordIcon from './assets/discord-icon';
import Edit from './edit';
import metadata from './block.json';

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType(metadata.name, {
	icon: discordIcon,
	edit: Edit,
	save: () => null,
});
