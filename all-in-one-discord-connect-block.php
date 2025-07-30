<?php
/**
 * Plugin Name:       All In One Discord Connect Block
 * Plugin URI:        https://github.com/younes-dro/all-in-one-discord-connect-block
 * Description:       A Gutenberg block that displays a custom Connect to Discord" button with flexible style options. Seamlessly integrates with membership plugins like PMPro, MemberPress, and Ultimate Member, as well as LMS plugins such as Tutor LMS, LearnDash, and LifterLMS.
 * Version:           1.0.0
 * Requires at least: 6.8
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
define( 'DRO_AIO_DISCORD_BLOCK_FILE', __FILE__ );
define( 'DRO_AIO_DISCORD_BLOCK_DIR', plugin_dir_path( __FILE__ ) );
define( 'DRO_AIO_DISCORD_BLOCK_URL', plugin_dir_url( __FILE__ ) );

/**
 * Activation hook for the All In One Discord Connect Block plugin.
 * TO DO: Add maybe some activation logic here in the future.
 *
 * @since 1.0.0
 *
 * @return void
 */
function dro_aio_discord_block_activation() {
	// empty function for now, but can be used in the future for activation logic.
}

register_activation_hook( DRO_AIO_DISCORD_BLOCK_FILE, __NAMESPACE__ . '\\dro_aio_discord_block_activation' );

/**
 * Registers a custom autoloader for the All-in-One Discord Connect Block plugin.
 *
 * This autoloader dynamically includes PHP class files based on their namespace
 * and naming convention. It supports automatic loading of class and abstract class
 * files located in the plugin's `includes` directory structure.
 *
 * Naming convention:
 * - Classes should be stored as `class-<name>.php`
 * - Abstract classes should be stored as `abstract-<name>.php`
 *
 * The autoloader detects abstract classes by inspecting the namespace path
 * and checking whether it contains the "abstracts" segment.
 *
 * Example class:
 *   Namespace: Dro\AIODiscordBlock\includes\Abstracts\Dro_AIO_Discord_Service
 *   Path:      includes/abstracts/abstract-dro-aio-discord-service.php
 *
 * @return void
 */
function dro_aio_discord_autoload() {
	spl_autoload_register(
		function ( $class ) {
			if ( strncmp( __NAMESPACE__ . '\\', $class, strlen( __NAMESPACE__ ) + 1 ) !== 0 ) {
				return;
			}

			$class_portions    = explode( '\\', $class );
			$class_portions    = array_map( 'strtolower', $class_portions );
			$class_file_name   = str_replace( '_', '-', strtolower( array_pop( $class_portions ) ) );
			$class_path        = __DIR__ . '/' . implode( DIRECTORY_SEPARATOR, array_slice( $class_portions, 2 ) );
			$class_file_prefix = ( stripos( $class, 'abstracts' ) !== false ? 'abstract-' : 'class-' );
			$class_full_path   = $class_path . DIRECTORY_SEPARATOR . $class_file_prefix . $class_file_name . '.php';

			if ( file_exists( $class_full_path ) ) {
				require_once $class_full_path;
			}
		}
	);
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
function dro_aio_discord() {
	dro_aio_discord_autoload();
	Dro_AIO_Discord::get_instance();
}
dro_aio_discord();
