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
error_log( print_r( Discord_Resolver::get_active_service(), true));
try {

	$render_block = Discord_Render::get_instance( Discord_Resolver::get_active_service() )->render( $attributes, $content, $block );

} catch ( Throwable $e ) {
	error_log( $e->getMessage() );
}
echo wp_kses_post( $render_block );
