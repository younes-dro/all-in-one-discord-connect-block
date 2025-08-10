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
	/**
	 * Log messages safely for debugging.
	 *
	 * Writes to the PHP error log only when WP_DEBUG is true.
	 * Sanitizes strings to avoid unsafe output in logs.
	 *
	 * @since 1.0.0
	 *
	 * @param string|\Throwable $message The message or exception to log.
	 * @param string            $level   Optional severity level ('notice', 'warning', 'error').
	 *
	 * @return void
	 */
	public static function safe_log( $message, string $level = 'error' ): void {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			if ( $message instanceof \Throwable ) {
				$message = $message->getMessage();
			}
			$prefix = '[All-in-One Discord Connect][' . strtoupper( $level ) . '] ';

			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			error_log( $prefix . esc_html( (string) $message ) );
		}
	}
}
