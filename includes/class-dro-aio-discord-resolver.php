<?php
/**
 * * Class Dro_AIO_Discord_Resolver
 * * This class will detect which services sould be used.
 * * and save it in global variable $dro_aio_discord_active_service.
 * * In case more than one service is available, it will use the first one.
 */

declare(strict_types=1);
namespace Dro\AIODiscordBlock\includes;

use Dro\AIODiscordBlock\includes\Interfaces\Dro_AIO_Discord_Service_Interface;
use Dro\AIODiscordBlock\includes\Services\Dro_AIO_Discord_Pmpro;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Dro_AIO_Discord_Resolver {

	protected static ?Dro_AIO_Discord_Service_Interface $active_service = null;

	/**
	 * Checks if a required plugin is active.
	 *
	 * @param string $plugin_file Relative plugin path (e.g., 'pmpro/pmpro.php').
	 * @return bool
	 */
	protected static function is_plugin_active( string $plugin_file ): bool {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		return is_plugin_active( $plugin_file );
	}

	/**
	 * Resolves and sets the active service, based on installed/active add-ons.
	 *
	 * @return Dro_AIO_Discord_Service_Interface|null
	 */
	public static function resolve(): ?Dro_AIO_Discord_Service_Interface {

		if ( self::$active_service !== null ) {
			error_log( 'Active service already set.' );
			return self::$active_service;
		}


		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		// Ordered map: plugin slug => service key
		$priority_map = array(
			'pmpro-discord-add-on/pmpro-discord.php' => 'pmpro',
			'memberpress/memberpress.php'            => 'memberpress',
			'ultimate-member-discord-add-on/ultimate-member-discord-add-on'    => 'ultimate_member',

		);

		foreach ( $priority_map as $plugin_slug => $service_key ) {
			if ( is_plugin_active( $plugin_slug ) ) {
				self::$active_service = self::set_active_service( $service_key );
				break;
			}
		}

		// $GLOBALS['dro_aio_discord_active_service'] = self::$active_service;

		return self::$active_service;
	}


	public static function set_active_service( string $service_name ): ?Dro_AIO_Discord_Service_Interface {
		$service_class = $service_class = '\\Dro\\AIODiscordBlock\\includes\\Services\\Dro_AIO_Discord_' . ucfirst( $service_name );

		if ( class_exists( $service_class ) ) {

			return new $service_class();
		}
		return null;
	}

	public static function get_active_service(): ?Dro_AIO_Discord_Service_Interface {
		if ( self::$active_service === null ) {
			self::resolve();
		}
		return self::$active_service;
	}
}
