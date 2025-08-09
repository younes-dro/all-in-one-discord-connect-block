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
		 * The singleton instance of the class.
		 *
		 * @var self|null
		 */
	protected static ?self $instance = null;
	/**
	 * The plugin name for the PMPro Discord add-on.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string
	 */
	private const PLUGIN_NAME = 'pmpro-discord-add-on/pmpro-discord.php';

	/**
	 * The official icon URL for the service add-on.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var string
	 */
	private const PLUGIN_ICON = 'https://ps.w.org/pmpro-discord-add-on/assets/icon-256x256.png';

	/**
	 * Maps Discord user data properties to their corresponding WordPress user meta keys.
	 *
	 * This array is used by the base class to retrieve and assign Discord-related metadata
	 * for a specific user. Each key represents a logical property, and each value is the
	 * actual meta key stored in the WordPress database.
	 *
	 * Keys:
	 * - 'discord_username'    → Meta key for the Discord username
	 * - 'discord_user_avatar' → Meta key for the Discord avatar URL
	 * - 'discord_user_id'     → Meta key for the Discord user ID
	 *
	 * @var array<string, string>
	 */

	protected array $discord_meta_keys = array(
		'discord_username'    => '_ets_pmpro_discord_username',
		'discord_user_avatar' => '_ets_pmpro_discord_avatar',
		'discord_user_id'     => '_ets_pmpro_discord_user_id',
		'access_token'        => '_ets_pmpro_discord_access_token',
	);
	/**
	 * Private constructor to prevent direct instantiation.
	 *
	 * This enforces the singleton pattern by restricting object creation
	 * to the `get_instance()` method.
	 */
	private function __construct() {
	}
	/**
	 * Private clone method to prevent cloning of the singleton instance.
	 *
	 * Cloning is disabled to ensure that only one instance of the service exists.
	 *
	 * @return void
	 */
	private function __clone() {}
	/**
	 * Private wakeup method to prevent unserializing of the singleton instance.
	 *
	 * Unserialization is disabled to maintain the integrity of the singleton pattern.
	 *
	 * @return void
	 */
	private function __wakeup() {}


	/**
	 * Returns a singleton instance of the Discord service.
	 *
	 * Ensures that only one instance of the service is created and reused.
	 * This method is typically used to access the service without directly instantiating it.
	 *
	 * @return Discord_Service_Interface The singleton instance of the service.
	 */
	public static function get_instance(): Discord_Service_Interface {

		return self::$instance ?? new self();
	}

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
	 * Get the service name.
	 *
	 * @return string The service identifier.
	 */
	public function get_service_name(): string {
		return 'pmpro-discord-service';
	}

	/**
	 * Get the icon for the PMPro Discord service.
	 *
	 * @return string icon url.
	 */
	public function get_service_icon_url(): string {

		return self::PLUGIN_ICON;
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
		$user_id           = (int) sanitize_text_field( (int) get_current_user_id() );
		$access_token      = $this->get_user_access_token();
		$allow_none_member = sanitize_text_field( trim( get_option( 'ets_pmpro_allow_none_member' ) ) );

		extract( $this->set_block_attributes( $attributes ) );

		$html = '';

		if ( Check_saved_settings_status() && $access_token ) {

			$html .= $this->get_disconnect_button(
				$user_id,
				$disconnectButtonBgColor,
				$disconnectButtonTextColor,
				$loggedOutText
			);
			$html .= $this->get_user_infos( $discordConnectedAccountText, $user_id );
			$html .= $this->get_user_roles( $roleAssignedText, $user_id );

		} elseif ( pmpro_hasMembershipLevel() || $allow_none_member == 'yes' ) {

			$html .= $this->get_connect_button(
				$connectButtonBgColor,
				$connectButtonTextColor,
				$loggedInText
			);
			$html .= $this->get_user_roles( $roleWillAssignText, $user_id );
		} else {
			$html .= '<p>' . esc_html__( 'You must be a member to connect to Discord.', 'dro-aio-discord-block' ) . '</p>';
		}

		return $html;
	}
	/**
	 * Generates the HTML markup for the Discord connect button.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @param string $button_bg_color   Background color for the button.
	 * @param string $button_text_color Text color for the button.
	 * @param string $button_text       Text displayed on the button.
	 *
	 * @return string HTML markup for the connect button.
	 */
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

	/**
	 * Generates the HTML markup for the Discord disconnect button.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @param int    $user_id           ID of the user to disconnect.
	 * @param string $button_bg_color   Background color for the button.
	 * @param string $button_text_color Text color for the button.
	 * @param string $button_text       Text displayed on the button.
	 *
	 * @return string HTML markup for the disconnect button.
	 */
	private function get_disconnect_button( int $user_id, string $button_bg_color, string $button_text_color, string $button_text ): string {
		wp_enqueue_script( 'ets_pmpro_add_discord_script' );
		wp_enqueue_style( 'ets_pmpro_add_discord_style' );
		$button_html  = '';
		$button_html .= '<a href="?action=discord-logout"
         class="dro-aio-discord-disconnect-button"
         id="pmpro-disconnect-discord"
         data-user-id="' . esc_attr( $user_id ) . '"
         style="background-color:' . esc_attr( $button_bg_color ) . '; color:' . esc_attr( $button_text_color ) . ';">'
			. esc_html__( $button_text )
			. '<i class="fab fa-discord"></i></a>';

		return $button_html . '<span class="ets-spinner"></span>';
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
