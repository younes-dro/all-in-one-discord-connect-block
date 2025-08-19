<?php

/**
 * PMPro Discord Service Implementation
 *
 * This class handles the Paid Memberships Pro service for Discord integration.
 * It implements the Dro_CCBB_Service_Interface and extends the abstract service.
 *
 * PHP version 7.4+
 *
 * @package  CustomConnectButtonBlock\Services
 * @category Plugin
 * @author   Younes DRO <younesdro@gmail.com>
 * @license  GPL-2.0-or-later https://www.gnu.org/licenses/gpl-2.0.html
 * @version  GIT: 1.0.0
 * @link     https://github.com/younes-dro/'custom-connect-button-block-for-discord'
 * @since    1.0.0
 */

declare(strict_types=1);

namespace Dro\CustomConnectButtonBlock\includes\Services;

use Dro\CustomConnectButtonBlock\includes\Abstracts\Dro_CCBB_Service as Abstract_Service;
use Dro\CustomConnectButtonBlock\includes\Interfaces\Dro_CCBB_Service_Interface as Service_Interface;

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
 * @package  CustomConnectButtonBlock\Services
 * @author   Younes DRO <younesdro@gmail.com>
 * @license  GPL-2.0-or-later https://www.gnu.org/licenses/gpl-2.0.html
 * @version  Release: 1.0.0
 * @link     https://github.com/younes-dro/'custom-connect-button-block-for-discord'
 * @since    1.0.0
 */
class Dro_CCBB_Pmpro extends Abstract_Service implements Service_Interface {


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
	 * Unique internal service slug used for asset naming and identification.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	private const SERVICE_NAME = 'pmpro-discord-service';

	/**
	 * The official icon URL for the service add-on.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var string
	 */
	private const PLUGIN_ICON = DRO_CCBB_URL . '/assets/' . self::SERVICE_NAME . '.png';

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
	 * Prevent cloning of the instance.
	 *
	 * @return void
	 */
	public function __clone() {

		$cloning_message = sprintf(
			/* translators: %s is the class name that cannot be cloned */
			esc_html__( 'You cannot clone instance of %s', 'custom-connect-button-block-for-discord' ),
			get_class( $this )
		);
		_doing_it_wrong( __FUNCTION__, esc_html( $cloning_message ), esc_html( DRO_CCBB_VERSION ) );
	}
	/**
	 * Prevent unserializing of the instance.
	 *
	 * @return void
	 */
	public function __wakeup() {

		$unserializing_message = sprintf(
			/* translators: %s is the class name that cannot be unserialized */
			esc_html__( 'You cannot unserialize instance of %s', 'custom-connect-button-block-for-discord' ),
			get_class( $this )
		);
		_doing_it_wrong( __FUNCTION__, esc_html( $unserializing_message ), esc_html( DRO_CCBB_VERSION ) );
	}


	/**
	 * Returns a singleton instance of the Discord service.
	 *
	 * Ensures that only one instance of the service is created and reused.
	 * This method is typically used to access the service without directly instantiating it.
	 *
	 * @return Service_Interface The singleton instance of the service.
	 */
	public static function get_instance(): Service_Interface {

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
		return self::SERVICE_NAME;
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
			$html .= '<p>' . esc_html__( 'You must be a member to connect to Discord.', 'custom-connect-button-block-for-discord' ) . '</p>';
		}

		return $html;
	}
	/**
	 * Generates the HTML markup for the Discord connect button.
	 *
	 * @param string $button_bg_color   Background color for the button.
	 * @param string $button_text_color Text color for the button.
	 * @param string $button_text       Text displayed on the button.
	 *
	 * @return string HTML markup for the connect button.
	 */
	private function get_connect_button( string $button_bg_color, string $button_text_color, string $button_text ): string {
		$current_url = ets_pmpro_discord_get_current_screen_url();
		$encoded_url = rawurlencode( $current_url );
		$link        = add_query_arg(
			array(
				'action' => 'discord-login',
				'url'    => $encoded_url,
			),
		);

		return sprintf(
			'<a href="%s" class="dro-aio-discord-connect-button" style="background-color:%s; color:%s;">%s <i class="fab fa-discord"></i></a>',
			esc_url( $link ),
			esc_attr( $button_bg_color ),
			esc_attr( $button_text_color ),
			esc_html( $button_text )
		);
	}



	/**
	 * Generates the HTML markup for the Discord disconnect button.
	 *
	 * @param int    $user_id           ID of the user.
	 * @param string $button_bg_color   Background color for the button.
	 * @param string $button_text_color Text color for the button.
	 * @param string $button_text       Text displayed on the button.
	 *
	 * @return string HTML markup for the disconnect button.
	 */
	private function get_disconnect_button( int $user_id, string $button_bg_color, string $button_text_color, string $button_text ): string {
		wp_enqueue_script( 'ets_pmpro_add_discord_script' );
		wp_enqueue_style( 'ets_pmpro_add_discord_style' );

		$button_html = sprintf(
			'<a href="?action=discord-logout" class="dro-aio-discord-disconnect-button" id="pmpro-disconnect-discord" data-user-id="%s" style="background-color:%s; color:%s;">%s <i class="fab fa-discord"></i></a>',
			esc_attr( $user_id ),
			esc_attr( $button_bg_color ),
			esc_attr( $button_text_color ),
			esc_html( $button_text )
		);

		return $button_html . '<span class="ets-spinner"></span>';
	}
	/**
	 * Get user information: Discord username and avatar.
	 *
	 * @param string $discord_connected_account_text Text label for the connected account.
	 * @param int    $user_id                        ID of the user.
	 *
	 * @return string|null HTML markup for user info.
	 */
	private function get_user_infos( string $discord_connected_account_text, int $user_id ): ?string {
		return sprintf(
			'<div class="user-infos"><span class="roles-text">%s</span><span class="connected-account">%s</span>%s</div>',
			esc_html( $discord_connected_account_text ),
			$this->get_user_connected_account( $user_id ),
			$this->get_user_avatar_img()
		);
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
		$all_roles                      = maybe_unserialize( get_option( 'ets_pmpro_discord_all_roles' ) );
		$ets_pmpor_discord_role_mapping = json_decode( get_option( 'ets_pmpor_discord_role_mapping' ), true );

		$default_role = sanitize_text_field( trim( get_option( '_ets_pmpro_discord_default_role_id' ) ) );
		$roles_color  = maybe_unserialize( get_option( 'ets_pmpro_discord_roles_color' ) );

		$user_roles_html  = '';
		$mapped_role_name = '';

		$curr_level_id = ets_pmpro_discord_get_current_level_id( $user_id );

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
