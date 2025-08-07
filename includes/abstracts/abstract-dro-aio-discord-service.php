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
	 * The Discord user ID.
	 *
	 * @var integer|null
	 */
	protected ?int $discord_user_id = null;
	/**
	 * The Discord user avatar.
	 *
	 * @var string|null
	 */
	protected ?string $discord_user_avatar = null;

	/**
	 * The Discord user name.
	 *
	 * @var string|null
	 */
	protected ?string $discord_user_name = null;

	/**
	 * The Block attributes with default values.
	 *
	 * @var array
	 */
	protected array $attributes = array(
		'loggedInText'                => 'Connect to Discord',
		'loggedOutText'               => 'Disconnect from Discord',
		'connectButtonBgColor'        => '#77a02e',
		'connectButtonTextColor'      => '#ffffff',
		'disconnectButtonBgColor'     => '#ff0000',
		'disconnectButtonTextColor'   => '#ffffff',
		'discordConnectedAccountText' => 'Connected account:',
		'roleWillAssignText'          => 'You will be assigned the following Discord roles:',
		'roleAssignedText'            => 'You have been assigned the following Discord roles:',
	);

	/**
	 * Map of attribute keys to their sanitization callbacks.
	 *
	 * @var array
	 */
	protected array $attribute_sanitizers = array(
		'loggedInText'                => 'esc_html',
		'loggedOutText'               => 'esc_html',
		'connectButtonBgColor'        => 'esc_attr',
		'connectButtonTextColor'      => 'esc_attr',
		'disconnectButtonBgColor'     => 'esc_attr',
		'disconnectButtonTextColor'   => 'esc_attr',
		'discordConnectedAccountText' => 'esc_html',
		'roleWillAssignText'          => 'esc_html',
		'roleAssignedText'            => 'esc_html',
	);



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
	 * Merge the block attributes with defaults and sanitize them.
	 *
	 * @param array $attributes
	 * @return array
	 */
	protected function set_block_attributes( array $attributes ): array {
		$merged = wp_parse_args( $attributes, $this->attributes );

		foreach ( $merged as $key => $value ) {
			if ( isset( $this->attribute_sanitizers[ $key ] ) && is_callable( $this->attribute_sanitizers[ $key ] ) ) {
				$merged[ $key ] = call_user_func( $this->attribute_sanitizers[ $key ], $value );
			}
		}

		return $merged;
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
