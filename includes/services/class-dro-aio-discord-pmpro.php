<?php

/**
 * PMPro Discord Service Implementation
 *
 * This class handles the Paid Memberships Pro service for Discord integration.
 * It implements the Dro_AIO_Discord_Service_Interface and extends the abstract service.
 *
 * PHP version 7.4+
 *
 * @package  Dro\AIODiscordBlock\Services
 * @category Plugin
 * @author   Younes DRO <younesdro@gmail.com>
 * @license  GPL-2.0-or-later https://www.gnu.org/licenses/gpl-2.0.html
 * @version  GIT: 1.0.0
 * @link     https://github.com/younes-dro/all-in-one-discord-connect-block
 * @since    1.0.0
 */

declare(strict_types=1);

namespace Dro\AIODiscordBlock\includes\Services;

use Dro\AIODiscordBlock\includes\Abstracts\Dro_AIO_Discord_Service as Discord_Service;
use Dro\AIODiscordBlock\includes\Interfaces\Dro_AIO_Discord_Service_Interface as Discord_Service_Interface;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Dro_AIO_Discord_Pmpro
 *
 * Handles PMPro service for Discord integration, providing methods to check
 * plugin status, retrieve user membership data, and manage Discord roles.
 *
 * @category Plugin
 * @package  Dro\AIODiscordBlock\Services
 * @author   Younes DRO <younesdro@gmail.com>
 * @license  GPL-2.0-or-later https://www.gnu.org/licenses/gpl-2.0.html
 * @version  Release: 1.0.0
 * @link     https://github.com/younes-dro/all-in-one-discord-connect-block
 * @since    1.0.0
 */
class Dro_AIO_Discord_Pmpro extends Discord_Service implements Discord_Service_Interface {


	/**
	 * The plugin name for the PMPro Discord add-on.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string
	 */
	private const PLUGIN_NAME = 'pmpro-discord-add-on/pmpro-discord.php';



	/**
	 * Get the plugin name for the PMPro Discord add-on.
	 *
	 * @return string The plugin slug.
	 */
	protected function get_plugin_name(): string {
		return self::PLUGIN_NAME;
	}

	/**
	 * Check if Connect Paid Memberships Pro to Discord add-on is active.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if plugin is active, false otherwise.
	 */
	public function is_plugin_active(): bool {
		return $this->check_active_plugin();
	}

	/**
	 * Load Discord user data for the PMPro service.
	 *
	 * @param integer $user_id
	 * @return void
	 */
	public function load_discord_user_data( int $user_id ): void {
		$username   = get_user_meta( $user_id, '_ets_pmpro_discord_username', true );
		$avatar     = get_user_meta( $user_id, '_ets_pmpro_discord_avatar', true );
		$discord_id = get_user_meta( $user_id, '_ets_pmpro_discord_user_id', true );

		$this->discord_user_name   = $username ?: null;
		$this->discord_user_avatar = $avatar ?: null;
		$this->discord_user_id     = $discord_id ? (int) $discord_id : null;
	}
	/**
	 * Gets the discord connected account for a user.
	 *
	 * @param integer $user_id
	 * @return string
	 */
	public function get_user_connected_account( int $user_id ): string {
		$discord_connected_account = $this->discord_user_name;
		if ( strpos( $discord_connected_account, '#' ) !== false ) {
			return esc_html( strstr( $discord_connected_account, '#', true ) );
		} else {
			return esc_html( $discord_connected_account );
		}
		return '';
	}



	/**
	 * Get user access context for Paid Memberships Pro active membership levels.
	 *
	 * @param int $user_id The user ID.
	 *
	 * @return array<int>|null Array of membership level IDs or null.
	 */
	public function get_user_access_context( int $user_id ): ?array {
		// TODO: Implement logic to get user access context.
		return null;
	}

	/**
	 * Get the IDs of active Discord roles for a user.
	 *
	 * @param int $user_id The user ID.
	 *
	 * @return array<int>|null Array of Discord role IDs or null.
	 */
	public function get_user_active_discord_roles_ids( int $user_id ): array|null {
		if ( function_exists( 'ets_pmpro_discord_get_current_level_ids' ) ) {
			$curr_level_ids = \ets_pmpro_discord_get_current_level_ids( $user_id );

		}
		return is_array( $curr_level_ids ) ? $curr_level_ids : null;
	}

	/**
	 * Get the service name.
	 *
	 * @return string The service identifier.
	 */
	public function get_service_name(): string {
		return 'pmpro-discord-service';
	}

	/**
	 * Get the base64 encoded icon for the PMPro Discord service.
	 *
	 * @return string Base64 encoded icon string.
	 */
	public function get_service_base64_encode_icon(): string {
		// TODO: Implement logic to return the base64 encoded icon.
		return '';
	}

	/**
	 * Render the Discord connect block.
	 *
	 * @param array     $attributes
	 * @param string    $content
	 * @param \WP_Block $block
	 * @return string
	 */
	public function build_html_block( array $attributes, string $content, \WP_Block $block ): string {
		$user_id                        = (int) sanitize_text_field( (int) get_current_user_id() );
		$access_token                   = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_pmpro_discord_access_token', true ) ) );
		$allow_none_member              = sanitize_text_field( trim( get_option( 'ets_pmpro_allow_none_member' ) ) );
		$logged_in_text                 = isset( $attributes['loggedInText'] ) ? esc_html( $attributes['loggedInText'] ) : esc_html__( 'Connect to Discord', 'dro-aio-discord-block' );
		$logged_out_text                = isset( $attributes['loggedOutText'] ) ? esc_html( $attributes['loggedOutText'] ) : esc_html__( 'Disconnect from Discord', 'dro-aio-discord-block' );
		$connect_button_bg_color        = isset( $attributes['connectButtonBgColor'] ) ? esc_attr( $attributes['connectButtonBgColor'] ) : '#77a02e';
		$connect_button_text_color      = isset( $attributes['connectButtonTextColor'] ) ? esc_attr( $attributes['connectButtonTextColor'] ) : '#ffffff';
		$disconnect_button_bg_color     = isset( $attributes['disconnectButtonBgColor'] ) ? esc_attr( $attributes['disconnectButtonBgColor'] ) : '#ff0000';
		$disconnect_button_text_color   = isset( $attributes['disconnectButtonTextColor'] ) ? esc_attr( $attributes['disconnectButtonTextColor'] ) : '#ffffff';
		$discord_connected_account_text = isset( $attributes['discordConnectedAccountText'] ) ? esc_html( $attributes['discordConnectedAccountText'] ) : esc_html__( 'Connected account:', 'dro-aio-discord-block' );
		$role_will_assign_text          = isset( $attributes['roleWillAssignText'] ) ? esc_html( $attributes['roleWillAssignText'] ) : esc_html__( 'You will be assigned the following Discord roles:', 'dro-aio-discord-block' );
		$role_assigned_text             = isset( $attributes['roleAssignedText'] ) ? esc_html( $attributes['roleAssignedText'] ) : esc_html__( 'You have been assigned the following Discord roles:', 'dro-aio-discord-block' );

		$html = '';

		if ( Check_saved_settings_status() && $access_token ) {

			$html .= $this->get_disconnect_button(
				$disconnect_button_bg_color,
				$disconnect_button_text_color,
				$logged_out_text
			);
			$html .= $this->get_user_roles( $role_assigned_text, $user_id );
			$html .= $this->get_user_infos( $discord_connected_account_text, $user_id );

		} elseif ( pmpro_hasMembershipLevel() || $allow_none_member == 'yes' ) {

			$html .= $this->get_connect_button(
				$connect_button_bg_color,
				$connect_button_text_color,
				$logged_in_text
			);
			$html .= $this->get_user_roles( $role_will_assign_text, $user_id );
		} else {
			$html .= '<p>' . esc_html__( 'You must be a member to connect to Discord.', 'dro-aio-discord-block' ) . '</p>';
		}

		return $html;
	}

	private function get_connect_button( string $button_bg_color, string $button_text_color, string $button_text ): string {

		$button_html  = '';
		$current_url  = ets_pmpro_discord_get_current_screen_url();
		$button_html .= '<a href="?action=discord-login&url=' . $current_url . '"
		class="dro-aio-discord-connect-button"
		style="background-color:' . esc_attr( $button_bg_color ) . '; color:' . esc_attr( $button_text_color ) . ';">'
		. esc_html( $button_text )
		. '<i class="fab fa-discord"></i></a>';

		return $button_html;
	}
	private function get_disconnect_button( string $button_bg_color, string $button_text_color, string $button_text ): string {

		$button_html  = '';
		$button_html .= '<a href="?action=discord-logout"
		 class="dro-aio-discord-disconnect-button"
		 style="background-color:' . esc_attr( $button_bg_color ) . '; color:' . esc_attr( $button_text_color ) . ';">'
			. esc_html__( $button_text )
			. '<i class="fab fa-discord"></i></a>';

		return $button_html;
	}


	/**
	 * Get user information.
	 * Discord username, avatar.
	 *
	 * @param string $discord_connected_account_text
	 * @param int    $user_id
	 * @return string
	 */
	private function get_user_infos( $discord_connected_account_text, $user_id ): ?string {

		return '<div class="user-infos">' .
		'<span class="roles-text">' . esc_html( $discord_connected_account_text ) . '</span>'
		. '<span class="connected-account">' . $this->get_user_connected_account( $user_id ) . '</span>'
		. $this->get_user_avatar_img()
		. '</div>';
	}

	/**
	 * Get user roles.
	 * This will return the user roles as a label.
	 *
	 * @param string $roles_text
	 * @param  int    $user_id
	 *
	 * @return string
	 */
	private function get_user_roles( $roles_text, $user_id ): ?string {
		$all_roles                      = unserialize( get_option( 'ets_pmpro_discord_all_roles' ) );
		$ets_pmpor_discord_role_mapping = json_decode( get_option( 'ets_pmpor_discord_role_mapping' ), true );

		$default_role = sanitize_text_field( trim( get_option( '_ets_pmpro_discord_default_role_id' ) ) );
		$roles_color  = unserialize( get_option( 'ets_pmpro_discord_roles_color' ) );

		$user_roles_html  = '';
		$mapped_role_name = '';
		if ( isset( $_GET['level'] ) && $_GET['level'] > 0 ) {
			$curr_level_id = $_GET['level'];
		} else {
				$curr_level_id = ets_pmpro_discord_get_current_level_id( $user_id );
		}

		$mapped_role_name = '';
		if ( $curr_level_id && is_array( $all_roles ) ) {
			if ( is_array( $ets_pmpor_discord_role_mapping ) && array_key_exists( 'pmpro_level_id_' . $curr_level_id, $ets_pmpor_discord_role_mapping ) ) {
				$mapped_role_id = $ets_pmpor_discord_role_mapping[ 'pmpro_level_id_' . $curr_level_id ];
				if ( array_key_exists( $mapped_role_id, $all_roles ) ) {
					$mapped_role_name = '<span> <i style="background-color:#' . dechex( $roles_color[ $mapped_role_id ] ) . '">' . $all_roles[ $mapped_role_id ] . '</i></span>';
				}
			}
		}

		$default_role_name = '';
		if ( $default_role != 'none' && is_array( $all_roles ) && array_key_exists( $default_role, $all_roles ) ) {
			$default_role_name = '<span> <i style="background-color:#' . dechex( $roles_color[ $default_role ] ) . '">' . $all_roles[ $default_role ] . '</i></span>';
		}
		if ( $mapped_role_name || $default_role_name ) {
			$user_roles_html .= '<span class="roles-text">' . $roles_text . '</span>';
		}
		if ( $mapped_role_name ) {
			$user_roles_html .= ets_pmpro_discord_allowed_html( $mapped_role_name );
		}

		if ( $default_role_name ) {
			$user_roles_html .= ets_pmpro_discord_allowed_html( $default_role_name );
		}

		return '<div class="user-infos">' . $user_roles_html . '</div>';
	}
}
