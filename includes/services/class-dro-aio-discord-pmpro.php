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

namespace Dro\AIODiscordBlock\Services;

use Dro\AIODiscordBlock\Abstracts\Dro_AIO_Discord_Service;
use Dro\AIODiscordBlock\Interfaces\Dro_AIO_Discord_Service_Interface;

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
class Dro_AIO_Discord_Pmpro extends Dro_AIO_Discord_Service implements Dro_AIO_Discord_Service_Interface {

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
		// TODO: Implement logic to get user's active Discord role IDs.
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
	 * Get the base64 encoded icon for the PMPro Discord service.
	 *
	 * @return string Base64 encoded icon string.
	 */
	public function get_service_base64_encode_icon(): string {
		// TODO: Implement logic to return the base64 encoded icon.
		return '';
	}
}
