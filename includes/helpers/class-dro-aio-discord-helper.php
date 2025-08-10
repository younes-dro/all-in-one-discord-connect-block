<?php
/**
 * General-purpose helper utilities for the plugin.
 *
 * @package AllInOneDiscordConnectBlock
 */

declare(strict_types=1);

namespace Dro\AIODiscordBlock\includes\helpers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Dro_AIO_Discord_Helper {

	/**
	 * Get allowed HTML tags for wp_kses().
	 *
	 * @return array
	 */
	public static function get_allowed_html(): array {
		return array(
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
				'src'   => true,
				'class' => true,
				'style' => true,
				'alt'   => true,
			),
		);
	}
}
