<?php

/**
 * Abstract class for handling shared service functionality
 *
 * This abstract class provides common functionality for Discord service
 * implementations, including plugin activation checking.
 *
 * PHP version 7.4+
 *
 * @package  Dro\AIODiscordBlock\Abstracts
 * @category Plugin
 * @author   Younes DRO <younesdro@gmail.com>
 * @license  GPL-2.0-or-later https://www.gnu.org/licenses/gpl-2.0.html
 * @version  GIT: 1.0.0
 * @link     https://github.com/younes-dro/all-in-one-discord-connect-block
 * @since    1.0.0
 */

declare(strict_types=1);

namespace Dro\AIODiscordBlock\includes\Abstracts;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Abstract class Dro_AIO_Discord_Service
 *
 * Provides shared functionality for Discord service implementations.
 *
 * @since    1.0.0
 */
abstract class Dro_AIO_Discord_Service {


	/**
	 * Get the plugin name/slug for the service.
	 *
	 * @return string The plugin slug.
	 */
	abstract protected function get_plugin_name(): string;

	/**
	 * Get the Discord user ID.
	 *
	 * @var integer|null
	 */
	protected ?int $discord_user_id = null;
	/**
	 * Get the Discord user avatar.
	 *
	 * @var string|null
	 */
	protected ?string $discord_user_avatar = null;

	/**
	 * Get the Discord user name.
	 *
	 * @var string|null
	 */
	protected ?string $discord_user_name = null;

	/**
	 * Get the Discord user ID.
	 *
	 * @return int|null
	 */
	public function get_discord_user_id(): ?int {
		return $this->discord_user_id;
	}

	/**
	 * Set the Discord user ID.
	 *
	 * @param int|null $id
	 * @return void
	 */
	public function set_discord_user_id( ?int $id ): void {
		$this->discord_user_id = $id;
	}

	/**
	 * Get the Discord user avatar.
	 *
	 * @return string|null
	 */
	public function get_discord_user_avatar(): ?string {
		return $this->discord_user_avatar;
	}

	/**
	 * Set the Discord user avatar.
	 *
	 * @param string|null $avatar
	 * @return void
	 */
	public function set_discord_user_avatar( ?string $avatar ): void {
		$this->discord_user_avatar = $avatar;
	}

	/**
	 * Get the Discord user name.
	 *
	 * @return string|null
	 */
	public function get_discord_user_name(): ?string {
		return $this->discord_user_name;
	}

	/**
	 * Set the Discord user name.
	 *
	 * @param string|null $name
	 * @return void
	 */
	public function set_discord_user_name( ?string $name ): void {
		$this->discord_user_name = $name;
	}

	/**
	 * Check if the add-on plugin is active.
	 *
	 * @return bool True if plugin is active, false otherwise.
	 */
	protected function check_active_plugin(): bool {
		$plugin_slug    = $this->get_plugin_name();
		$active_plugins = (array) get_option( 'active_plugins', array() );
		return in_array( $plugin_slug, $active_plugins, true );
	}

	/**
	 * Gets the full URL of the user's Discord avatar.
	 *
	 * @param int    $discord_user_id
	 * @param string $user_avatar
	 * @return string
	 */
	protected function get_user_avatar_img(): string {
		if ( $this->discord_user_avatar ) {
			$avatar_url = '<img src="https://cdn.discordapp.com/avatars/' . $this->discord_user_id . '/' . $this->discord_user_avatar . '.png" />';
		}
		return $avatar_url ?: '<img src="https://cdn.discordapp.com/embed/avatars/0.png" />';
	}
}
