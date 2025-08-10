<?php
/**
 * Server-side rendering for the All-in-One Discord Connect Block.
 *
 * @package AllInOneDiscordConnectBlock
 */
declare(strict_types=1);
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Dro\AIODiscordBlock\includes\Dro_AIO_Discord_Render as Discord_Render;
use Dro\AIODiscordBlock\includes\Dro_AIO_Discord_Resolver as Discord_Resolver;
use Dro\AIODiscordBlock\includes\helpers\Dro_AIO_Discord_Helper as Discord_Helper;


$user_id = get_current_user_id();
$service = Discord_Resolver::get_active_service();

if ( $service && $user_id ) {
	$service->load_discord_user_data( $user_id );
}

$render_block = '';
try {
	$render_block = Discord_Render::get_instance( $service )
					->render( $attributes, $content, $block );
} catch ( Throwable $e ) {
	Discord_Helper::safe_log( $e );
}

echo wp_kses( $render_block, Discord_Helper::get_allowed_html() );
