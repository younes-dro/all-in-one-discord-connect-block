<?php
/**
 * Plugin Name:       All In One Discord Connect Block
 * Plugin URI:        https://github.com/younes-dro/all-in-one-discord-connect-block
 * Description:       A Gutenberg block that displays a custom Connect to Discord" button with flexible style options. Seamlessly integrates with membership plugins like PMPro, MemberPress, and Ultimate Member, as well as LMS plugins such as Tutor LMS, LearnDash, and LifterLMS.
 * Version:           1.0.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            Younes DRO
 * Author URI:        https://github.com/younes-dro
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       dro-aio-discord-block
 *
 * @package AllInOneDiscordConnectBlock
 */
declare( strict_types=1 );

namespace Dro\AIODiscordBlock;
use Dro\AIODiscordBlock\includes\Dro_AIO_Discord;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'DRO_AIO_DISCORD_BLOCK_VERSION', get_file_data( __FILE__, array( 'Version' ), 'plugin' )[0] ?? '1.0.0' );

function dro_aio_discord_autoload(){
	spl_autoload_register(
	function ( $class ) {
		if ( strpos( $class, 'Dro\\AIODiscordBlock\\' ) !== 0 ) {
			return;
		}
		$portions_path = explode('\\', $class);
		$class_name = str_replace('_','-',strtolower(array_pop( $portions_path)));
		error_log( print_r( $portions_path, true));
		error_log( print_r( $class_name, true));

		exit;
	});
}



/**
 * Registers the block using a `blocks-manifest.php` file, which improves the performance of block type registration.
 * Behind the scenes, it also registers all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
 * @see https://make.wordpress.org/core/2024/10/17/new-block-type-registration-apis-to-improve-performance-in-wordpress-6-7/
 */
function dro_aio_discord_block_block_init() {

	if ( function_exists( 'wp_register_block_types_from_metadata_collection' ) ) {
		wp_register_block_types_from_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
		return;
	}
	if ( function_exists( 'wp_register_block_metadata_collection' ) ) {
		wp_register_block_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
	}

	$manifest_data = require __DIR__ . '/build/blocks-manifest.php';
	foreach ( array_keys( $manifest_data ) as $block_type ) {
		register_block_type( __DIR__ . "/build/{$block_type}" );
	}
}
add_action( 'init', __NAMESPACE__ . '\\dro_aio_discord_block_block_init' );

/**
 * Initialize the All In One Discord Connect Block plugin.
 * This function is called to set up the plugin's functionality.
 *
 * @since 1.0.0
 *
 * @return void
 */
function dro_aio_discord(){
	dro_aio_discord_autoload();
	Dro_AIO_Discord::get_instance();
}
dro_aio_discord();

