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
	error_log( $e->getMessage() );
}
$allowed_html = array(
	'div'  => array(
		'class' => true,
		'style' => true,
	),
	'a'    => array(
		'href'         => true,
		'class'        => true,
		'style'        => true,
		'id'           => true,
		'data-user-id' => true,
	),
	'i'    => array(
		'class' => true,
		'style' => true,
	),
	'span' => array(
		'class' => true,
		'style' => true,
	),
	'img'  => array(
		'src' => true,
	),

);

echo wp_kses( $render_block, $allowed_html );
