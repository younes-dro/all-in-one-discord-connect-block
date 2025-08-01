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
	 * Check if the add-on plugin is active.
	 *
	 * @return bool True if plugin is active, false otherwise.
	 */
	protected function check_active_plugin(): bool {
		$plugin_slug    = $this->get_plugin_name();
		$active_plugins = (array) get_option( 'active_plugins', array() );
		return in_array( $plugin_slug, $active_plugins, true );
	}
}
