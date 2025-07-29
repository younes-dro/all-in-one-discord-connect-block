<?php
/**
 * * Class Dro_AIO_Discord_Resolver
 * * This class will detect which services sould be used.
 * * and save it in global variable $dro_aio_discord_active_service.
 * * In case more than one service is available, it will use the first one.
 */

declare(strict_types=1);
namespace Dro\AIODiscordBlock\includes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Dro_AIO_Discord_Resolver {

	/**
	 * * This method will return the service class based on the service name.
	 *
	 * @param string $service_name The name of the service.
	 * @return Dro_AIO_Discord_Service_Interface|null The service class or null if not found.
	 */
	public static function get_service( $service_name ) {
		$service_class = 'Dro_' . ucfirst( $service_name ) . '_Service';

		if ( class_exists( $service_class ) ) {
			return new $service_class();
		}

		return null;
	}
}
