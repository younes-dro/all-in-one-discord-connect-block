<?php
/**
 * MemberPress Discord Service Implementation
 *
 * This class handles the MemberPress service for Discord integration.
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

namespace Dro\AIODiscordBlock\includes\Services;

use Dro\AIODiscordBlock\includes\Abstracts\Dro_AIO_Discord_Service;
use Dro\AIODiscordBlock\includes\Interfaces\Dro_AIO_Discord_Service_Interface;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Dro_AIO_Discord_MemberPress
 *
 * Handles MemberPress service for Discord integration.
 *
 * @category Plugin
 * @package  Dro\AIODiscordBlock\Services
 * @author   Younes DRO <younesdro@gmail.com>
 * @license  GPL-2.0-or-later https://www.gnu.org/licenses/gpl-2.0.html
 * @version  Release: 1.0.0
 * @link     https://github.com/younes-dro/all-in-one-discord-connect-block
 * @since    1.0.0
 */
class Dro_AIO_Discord_MemberPress extends Dro_AIO_Discord_Service implements Dro_AIO_Discord_Service_Interface {

	/**
	 * The plugin slug for the MemberPress Discord add-on.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string
	 */
	private const PLUGIN_NAME = 'connect-memberpress-discord-add-on/memberpress-discord.php';

	/**
	 * The official icon URL for the service add-on.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var string
	 */
	private const PLUGIN_ICON = 'https://ps.w.org/expresstechsoftwares-memberpress-discord-add-on/assets/icon-256x256.gif';

	/**
	 * Get the plugin name.
	 *
	 * @return string
	 */
	protected function get_plugin_name(): string {
		return self::PLUGIN_NAME;
	}

	/**
	 * Check if the MemberPress Discord plugin is active.
	 *
	 * @return bool
	 */
	public function is_plugin_active(): bool {
		return $this->check_active_plugin();
	}

	/**
	 * Loads Discord user data for the MemberPress service.
	 *
	 * @param int $user_id The ID of the user whose Discord data should be loaded.
	 * @return void
	 */
	public function load_discord_user_data( int $user_id ): void {
				$username   = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_memberpress_discord_username', true ) ) );
				$discord_id = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_memberpress_discord_user_id', true ) ) );
				$avatar     = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_memberpress_discord_avatar', true ) ) );

		$this->set_discord_user_name( $username ?: null );
		$this->set_discord_user_avatar( $avatar ?: null );
		$this->set_discord_user_id( (int) $discord_id ?: null );
	}

	/**
	 * Gets the discord connected account for a user.
	 *
	 * @param integer $user_id
	 * @return string
	 */
	public function get_user_connected_account( int $user_id ): string {
		$discord_connected_account = $this->discord_user_name;

			return esc_html( $discord_connected_account ) ?: '';
	}

	/**
	 * Get MemberPress access context (e.g., active membership IDs).
	 *
	 * @param int $user_id
	 * @return array<int>|null
	 */
	public function get_user_access_context( int $user_id ): ?array {
		// TODO: Implement logic to return array of active MemberPress membership IDs.
		return null;
	}

	/**
	 * Get internal service name.
	 *
	 * @return string
	 */
	public function get_service_name(): string {
		return 'memberpress-discord-service';
	}

	/**
	 * Geticon string.
	 *
	 * @return string
	 */
	public function get_service_icon_url(): string {

		return self::PLUGIN_ICON;
	}

	public function build_html_block( array $attributes, string $content, \WP_Block $block ): string {
		// TODO: Implement the HTML block rendering logic.
		return '';
	}
}
