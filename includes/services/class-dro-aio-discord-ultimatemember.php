<?php
/**
 * Ultimate Member Discord Service Implementation
 *
 * This class handles the Ultimate Member service for Discord integration.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Dro_AIO_Discord_UltimateMember
 *
 * Handles Ultimate Member service for Discord integration.
 *
 * @category Plugin
 * @package  Dro\AIODiscordBlock\Services
 * @author   Younes DRO <younesdro@gmail.com>
 * @license  GPL-2.0-or-later https://www.gnu.org/licenses/gpl-2.0.html
 * @version  Release: 1.0.0
 * @link     https://github.com/younes-dro/all-in-one-discord-connect-block
 * @since    1.0.0
 */
class Dro_AIO_Discord_UltimateMember extends Dro_AIO_Discord_Service implements Dro_AIO_Discord_Service_Interface {

	/**
	 * The plugin slug for the Ultimate Member Discord add-on.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string
	 */
	private const PLUGIN_NAME = 'ultimate-member-discord-add-on/ultimate-member-discord-add-on.php';

	/**
	 * Get the plugin slug.
	 *
	 * @return string
	 */
	protected function get_plugin_name(): string {
		return self::PLUGIN_NAME;
	}

	/**
	 * Check if Ultimate Member Discord plugin is active.
	 *
	 * @return bool
	 */
	public function is_plugin_active(): bool {
		return $this->check_active_plugin();
	}

	/**
	 * Get Discord username linked to this Ultimate Member account.
	 *
	 * @param int $user_id
	 * @return string|null
	 */
	public function get_user_connected_account( int $user_id ): string|null {
		return get_user_meta( $user_id, '_ets_um_discord_username', true ) ?: null;
	}

	/**
	 * Get Ultimate Member role(s) or group context for the user.
	 *
	 * @param int $user_id
	 * @return array<int>|null
	 */
	public function get_user_access_context( int $user_id ): ?array {
		// TODO: Return array of Ultimate Member roles or group IDs.
		return null;
	}

	/**
	 * Get Discord role IDs based on Ultimate Member role.
	 *
	 * @param int $user_id
	 * @return array<int>|null
	 */
	public function get_user_active_discord_roles_ids( int $user_id ): array|null {
		// TODO: Map UM roles to Discord role IDs.
		return null;
	}

	/**
	 * Get internal service identifier.
	 *
	 * @return string
	 */
	public function get_service_name(): string {
		return 'ultimate-member-discord-service';
	}

	/**
	 * Base64-encoded service icon.
	 *
	 * @return string
	 */
	public function get_service_base64_encode_icon(): string {
		// TODO: Provide base64 image of Ultimate Member icon.
		return '';
	}
}
