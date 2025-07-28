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

namespace Dro\AIODiscordBlock;
use Dro\AIODiscordBlock\includes\Dro_AIO_Discord;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$dro_aio_discord_block_version = get_file_data(
	__FILE__,
	array( 'Version' )
);

spl_autoload_register(
	// function( $class_name){
	// 	if( strcmp())
	// 	error_log( $class_name );
	// 	error_log( __NAMESPACE__);
	// }
);

// new Dro_AIO_Discord();


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
 * Replaces placeholders in the block content with actual user data.
 *
 * TODO: will repalce discord_username with the actual Discord username
 *
 * @param string $block_content The block content.
 * @param array  $block         The full block, including name and attributes.
 * @param array  $instance      The block instance.
 * @return string Modified block content with placeholders replaced.
 */
function dro_aio_discord_block_replace_placeholders( $block_content, $block, $instance ) {
	if ( is_user_logged_in() ) {
		$current_user = wp_get_current_user();
		$username     = esc_html( $current_user->user_login );

		$block_content = str_replace( '{discord_username}', $username, $block_content );
	}

	return $block_content;
}
// add_filter( 'render_block_dro-block/all-in-one-discord-connect-block', __NAMESPACE__ . '\\dro_aio_discord_block_replace_placeholders', 10, 3 );


add_action('init', function () {
	register_block_type(__DIR__, [
		'render_callback' => 'render_discord_connect_block',
	]);
});

