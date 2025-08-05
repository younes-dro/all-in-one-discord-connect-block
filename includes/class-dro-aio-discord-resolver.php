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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Dro_AIO_Discord_Resolver
 * This class is responsible for resolving the active Discord service based on installed plugins.
 * It checks for active plugins and returns the corresponding service instance.
 * The priority order is defined in the $priority_map array.
 *
 * @package Dro\AIODiscordBlock\includes
 * @since 1.0.0
 * @version 1.0.0
 * @author Younes DRO<younesdro@gmail.com>
 * @license GPL-2.0-or-later
 */
class Dro_AIO_Discord_Resolver {

	/**
	 * The active service instance.
	 * This property holds the currently active Discord service instance.
	 * It is initialized to null and will be set when the resolve method is called.
	 *
	 * @var Dro_AIO_Discord_Service_Interface|null
	 */
	protected static ?Dro_AIO_Discord_Service_Interface $active_service = null;

	/**
	 * Array mapping plugin slugs to service keys.
	 * This array defines the priority order for services based on active plugins.
	 * Supported add-ons are:
	 * - PMPro Discord Add-On
	 * - MemberPress Discord Add-On
	 * - Ultimate Member Discord Add-On
	 * - Tutor LMS Discord Add-On
	 *
	 * @var array
	 */
	private static array $priority_map = array(
		'pmpro-discord-add-on/pmpro-discord.php' => 'Pmpro',
		'expresstechsoftwares-memberpress-discord-add-on/memberpress-discord.php' => 'MemberPress',
		'ultimate-member-discord-add-on/ultimate-member-discord-add-on.php' => 'UltimateMember',
		'connect-discord-tutor-lms/connect-discord-tutor-lms.php' => 'tutor_lms',

	);

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
			// error_log("Not null");
			return self::$active_service;
		}

		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		foreach ( self::$priority_map as $plugin_slug => $service_key ) {
			if ( is_plugin_active( $plugin_slug ) ) {
				// error_log( print_r( $plugin_slug, true));
				self::$active_service = self::set_active_service( $service_key );
				break;
			} else {
				// error_log( print_r( 'Not Active : '. $plugin_slug, true));
			}
		}

		// $GLOBALS['dro_aio_discord_active_service'] = self::$active_service;
		// error_log(print_r(  self::$active_service, true));
		return self::$active_service;
	}


	public static function set_active_service( string $service_name ): ?Dro_AIO_Discord_Service_Interface {
		$service_class = $service_class = '\\Dro\\AIODiscordBlock\\includes\\Services\\Dro_AIO_Discord_' . ucfirst( $service_name );
		// error_log( print_r( $service_class, true));
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
