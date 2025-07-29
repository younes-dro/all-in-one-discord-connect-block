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
use Dro\AIODiscordBlock\includes\Services\Dro_AIO_Discord_Pmpro;
new Dro_AIO_Discord_Pmpro();

$render_block = Discord_Render::get_instance()->render( $attributes, $content, $block );
echo wp_kses_post( $render_block );
