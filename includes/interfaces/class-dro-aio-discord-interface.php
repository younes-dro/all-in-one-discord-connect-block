<?php
/**
 * All In One Discord Connect Block - Service Interface
 *
 * Defines the contract for Discord integration services that
 * fetch user-related data from supported plugins.
 *
 * PHP version 7.4+
 *
 * @category Plugin
 * @package  Dro\AIODiscordBlock\Interfaces
 * @author   Your Name <younesdro@gmail.com>
 * @license  GPL-2.0-or-later https://www.gnu.org/licenses/gpl-2.0.html
 * @version  GIT: 1.0.0
 * @link     https://github.com/younes-dro/all-in-one-discord-connect-block
 * @since    1.0.0
 */


namespace Dro\AIODiscordBlock\Interfaces;

// Exit if accessed directly.
if (! defined('ABSPATH') ) {
    exit;
}

/**
 * Interface Dro_AIO_Discord_Interface
 *
 * This interface outlines the methods that must be implemented by any service
 * class that integrates with the All-in-One Discord Connect Block plugin.
 * It includes methods for checking plugin activation, fetching user access
 * context, retrieving active Discord roles, and providing service metadata.
 *
 * @category Plugin
 * @package  Dro\AIODiscordBlock\Interfaces
 * @author   Your Name <younesdro@gmail.com>
 * @license  GPL-2.0-or-later https://www.gnu.org/licenses/gpl-2.0.html
 * @version  Release: 1.0.0
 * @link     https://github.com/younes-dro/all-in-one-discord-connect-block
 * @since    1.0.0
 */
interface Dro_AIO_Discord_Interface
{
    /**
     * Detection of whether the plugin is active.
     *
     * @return bool True if the plugin is active, false otherwise.
     */
    public function is_plugin_active(): bool;

    /**
     * Fetches user-related context data for a specific user.
     *
     * This may include IDs of active membership levels, enrolled courses,
     * or other relevant data depending on the service used.
     *
     * @param int $user_id The ID of the user.
     *
     * @return array<int>|null An array of integer IDs, or null if no data
     *                         is found.
     */
    public function get_user_access_context(int $user_id): array|null;

    /**
     * Retrieves the IDs of active Discord roles assigned to the given user.
     *
     * @param int $user_id The ID of the user.
     *
     * @return array<int>|null An array of Discord role IDs, or null if none
     *                         are assigned.
     */
    public function get_user_active_discord_roles_ids(int $user_id): array|null;

    /**
     * Get the service name.
     *
     * Returns the identifier of the associated plugin integration (e.g.,
     * 'pmpro-discord-service', 'memberpress-discord-service', etc.).
     * This name is used internally for settings, logging, and distinguishing
     * between multiple service integrations.
     *
     * @return string The name of the service.
     */
    public function get_service_name(): string;

    /**
     * Get the service icon URL.
     *
     * @return string The URL of the service icon.
     */
    public function get_service_base64_encode_icon(): string;
}
