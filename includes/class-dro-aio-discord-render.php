<?php

/**
 *  All In One Discord Connect Block - Render
 *  This class is responsible for rendering the Discord connect block.
 *  It will use the active service stored in the global variable $dro_aio_discord_active_service.
 *
 *  @package AllInOneDiscordConnectBlock
 * @author Younes DRO <younesdro@gmail.com>
 * @license GPL-2.0-or-later
 *  @version 1.0.0
 */

declare(strict_types=1);

namespace Dro\AIODiscordBlock\includes;

use Dro\AIODiscordBlock\Interfaces\Dro_AIO_Discord_Service_Interface;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Dro_AIO_Discord_Render
 * This class is responsible for rendering the Discord connect block.
 * It will use the active service stored in the global variable $dro_aio_discord_active_service.
 *
 * @package AllInOneDiscordConnectBlock
 * @author Younes DRO <younesdro@gmail.com>
 * @license GPL-2.0-or-later
 * @version 1.0.0
 * @since 1.0.0
 */
class Dro_AIO_Discord_Render {


	/**
	 * The singleton instance of the class.
	 *
	 * @var self|null
	 */
	protected static ?self $instance = null;

	/**
	 * The active service.
	 *
	 * @var Dro_AIO_Discord_Service_Interface|null
	 */
	protected ?Dro_AIO_Discord_Service_Interface $active_service = null;

	/**
	 * Dro_AIO_Discord_Render constructor.
	 * Private constructor to enforce singleton pattern.
	 *
	 * @param Dro_AIO_Discord_Service_Interface|null $active_service The active service.
	 */
	private function __construct( ?Dro_AIO_Discord_Service_Interface $active_service = null ) {
		$this->active_service = $active_service ?? $GLOBALS['dro_aio_discord_active_service'];
	}

	/**
	 * Set the active service.
	 *
	 * @param Dro_AIO_Discord_Service_Interface $active_service
	 * @return void
	 */
	public function set_active_service( Dro_AIO_Discord_Service_Interface $active_service ): void {
		$this->active_service = $active_service;
	}

	/**
	 * Get the instance of the class.
	 *
	 * @return self|null
	 */
	public static function get_instance(): ?self {
		return self::$instance ??= new self();
	}
	/**
	 * Prevent cloning of the instance.
	 *
	 * @return void
	 */
	public function __clone() {

		$cloning_message = sprintf(
			/* translators: %s is the class name that cannot be cloned */
			esc_html__( 'You cannot clone instance of %s', 'dro-aio-discord-block' ),
			get_class( $this )
		);
		_doing_it_wrong( __FUNCTION__, esc_html( $cloning_message ), esc_html( DRO_AIO_DISCORD_BLOCK_VERSION ) );
	}
	/**
	 * Prevent unserializing of the instance.
	 *
	 * @return void
	 */
	public function __wakeup() {

		$unserializing_message = sprintf(
			/* translators: %s is the class name that cannot be unserialized */
			esc_html__( 'You cannot unserialize instance of %s', 'dro-aio-discord-block' ),
			get_class( $this )
		);
		_doing_it_wrong( __FUNCTION__, esc_html( $unserializing_message ), esc_html( DRO_AIO_DISCORD_BLOCK_VERSION ) );
	}

	/**
	 * Render the Discord connect block.
	 *
	 * @param array    $attributes The block attributes.
	 * @package string $content The content saved from the editor.
	 * @param WP_Block $block The WP_Block object.
	 *
	 * @return string The rendered block content.
	 */
	public function render( array $attributes, string $content, \WP_Block $block ): string {
		if ( ! $this->active_service instanceof Dro_AIO_Discord_Service_Interface ) {
			return '<p>' . esc_html__( 'No active Discord service found.', 'dro-aio-discord-block' ) . '</p>';
		}

		$logged_in_text                 = esc_html( $attributes['loggedInText'] ) ?? esc_html__( 'Connect to Discord', 'dro-aio-discord-block' );
		$logged_out_text                = esc_html( $attributes['loggedOutText'] ) ?? esc_html__( 'Disconnect from Discord', 'dro-aio-discord-block' );
		$button_color                   = esc_attr( $attributes['connectButtonBgColor'] ?? '#77a02e' );
		$text_color                     = esc_attr( $attributes['connectButtonTextColor'] ?? '#ffffff' );
		$discord_connected_account_text = esc_html( $attributes['discordConnectedAccountText'] ) ?? esc_html__( 'Connected account', 'dro-aio-discord-block' );

		$discord_username = $this->active_service->get_user_connected_account( get_current_user_id() );

		$html  = '';
		$html .= '<div ' . get_block_wrapper_attributes( array( 'class' => 'discord-connect-block' ) ) . '>';
		$html .= '<button style="background-color:' . $button_color . '; color:' . $text_color . ';">';
		$html .= $logged_in_text;
		$html .= '</button>';
		$html .= '<p>' . $discord_connected_account_text . '</p>';

		$html .= '</div>';

		return $html;
	}
}
