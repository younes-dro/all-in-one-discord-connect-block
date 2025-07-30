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

use Dro\AIODiscordBlock\includes\Interfaces\Dro_AIO_Discord_Service_Interface as Discord_Service_Interface;


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
	 * @var Discord_Service_Interface|null
	 */
	protected ?Discord_Service_Interface $active_service = null;

	/**
	 * Dro_AIO_Discord_Render constructor.
	 * Private constructor to enforce singleton pattern.
	 *
	 * @param Discord_Service_Interface|null $active_service The active service.
	 */
	private function __construct( ?Discord_Service_Interface $active_service = null ) {
		$this->active_service = $active_service ?? null;
	}

	/**
	 * Set the active service.
	 *
	 * @param Discord_Service_Interface $active_service
	 * @return void
	 */
	public function set_active_service( Discord_Service_Interface $active_service ): void {
		$this->active_service = $active_service;
	}

	/**
	 * Get the instance of the class.
	 *
	 * @param Discord_Service_Interface|null $active_service The active service.
	 *
	 * @return self|null
	 */
	public static function get_instance( ?Discord_Service_Interface $active_service = null ): ?self {
		return self::$instance ??= new self( $active_service );
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
		// if ( ! $this->active_service instanceof Discord_Service_Interface ) {
		// return '<p>' . esc_html__( 'No active Discord service found.', 'dro-aio-discord-block' ) . '</p>';
		// }

		$logged_in_text                 = esc_html( $attributes['loggedInText'] ) ?? esc_html__( 'Connect to Discord', 'dro-aio-discord-block' );
		$logged_out_text                = esc_html( $attributes['loggedOutText'] ) ?? esc_html__( 'Disconnect from Discord', 'dro-aio-discord-block' );
		$button_bg_color                = esc_attr( $attributes['connectButtonBgColor'] ?? '#77a02e' );
		$button_text_color              = esc_attr( $attributes['connectButtonTextColor'] ?? '#ffffff' );
		$discord_connected_account_text = esc_html( $attributes['discordConnectedAccountText'] ) ?? esc_html__( 'Connected account', 'dro-aio-discord-block' );

		// $discord_username = $this->active_service->get_user_connected_account( get_current_user_id() );

		$html  = '';
		$html .= $this->get_wrapper( get_block_wrapper_attributes( array( 'class' => 'discord-connect-block' ) ) );
		$html .= $this->get_button(
			$button_bg_color,
			$button_text_color,
			'Text'
		);

		$html .= $this->get_user_infos();
		$html .= $this->get_user_roles();

		$html .= '</div>';

		return $html;
	}

	/**
	 * Get the wrapper HTML.
	 * This will return the wrapper HTML with the given attributes.
	 *
	 * @param string $wrapper_attr The attributes for the wrapper.
	 *
	 * @return string
	 */
	private function get_wrapper( $wrapper_attr ): string {
		return '<div ' . $wrapper_attr . '>';
	}

	/**
	 * Get the button HTML.
	 * This will return the button HTML with the given background color and text color.
	 * Shold return a button with the text "Connect to Discord" or "Disconnect from Discord" based on the user's connection status.
	 *
	 * @param string $button_bg_color
	 * @param string $button_text_color
	 * @param string $button_text
	 * @return string
	 */
	private function get_button( $button_bg_color, $button_text_color, $button_text ): string {
		return '<button class="discord-connect-button" style="background-color:' . esc_attr( $button_bg_color ) . '; color:' . esc_attr( $button_text_color ) . ';">' . esc_html( $button_text ) . '</button>';
	}

	/**
	 * Get user information.
	 * Disccord username, avatar.
	 *
	 * @return string
	 */
	private function get_user_infos(): ?string {
		return '<p>Discord Username + Avatar</p>';
	}

	/**
	 * Get user roles.
	 * This will return the user roles as a label.
	 * If the user has no roles, it will return an empty string.
	 *
	 * @return string
	 */
	private function get_user_roles(): ?string {
		$test_active_service = $this->active_service->get_service_name();
		return '<p>Roles in :'. $test_active_service.'</p>';
	}
}
