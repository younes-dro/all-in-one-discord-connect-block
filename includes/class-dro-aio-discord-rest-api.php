<?php

/**
 * Discord REST API Handler
 *
 * This class handles REST API endpoints for retrieving Discord service information
 * including service icons and other related data from active Discord add-ons.
 *
 * @package    Dro\AIODiscordBlock
 * @subpackage includes
 * @since      1.0.0
 * @author     Younes DRO<younesdro@gmail.com>
 */

declare(strict_types=1);

namespace Dro\AIODiscordBlock\includes;

use Dro\AIODiscordBlock\includes\Dro_AIO_Discord_Resolver as Discord_Resolver;
use Dro\AIODiscordBlock\includes\Interfaces\Dro_AIO_Discord_Service_Interface as Discord_Service_Interface;
use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;
use WP_Error;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Dro_AIO_Discord_Rest_Api
 *
 * Handles REST API endpoints for Discord service integration.
 * Implements singleton pattern to ensure only one instance exists.
 *
 * @since 1.0.0
 */
class Dro_AIO_Discord_Rest_Api {

	/**
	 * The singleton instance of the class.
	 *
	 * @since 1.0.0
	 * @var self|null
	 */
	protected static ?self $instance = null;

	/**
	 * API namespace for the REST routes.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	private const API_NAMESPACE = 'aio-discord/v1';

	/**
	 * Private constructor to prevent direct instantiation.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {
		$this->init();
	}

	/**
	 * Get the singleton instance of the class.
	 *
	 * @since 1.0.0
	 * @return self The singleton instance
	 */
	public static function get_instance(): self {
		return self::$instance ??= new self();
	}

	/**
	 * Prevent cloning of the instance.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __clone() {
		$cloning_message = sprintf(
			/* translators: %s is the class name that cannot be cloned */
			esc_html__( 'You cannot clone instance of %s', 'dro-aio-discord-block' ),
			get_class( $this )
		);
		_doing_it_wrong( __FUNCTION__, esc_html( $cloning_message ), esc_html( DRO_AIO_DISCORD_BLOCK_VERSION ) );
	}

	/**
	 * Prevent unserializing of the instance.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __wakeup() {
		$unserializing_message = sprintf(
			/* translators: %s is the class name that cannot be unserialized */
			esc_html__( 'You cannot unserialize instance of %s', 'dro-aio-discord-block' ),
			get_class( $this )
		);
		_doing_it_wrong( __FUNCTION__, esc_html( $unserializing_message ), esc_html( DRO_AIO_DISCORD_BLOCK_VERSION ) );
	}

	/**
	 * Initialize the REST API hooks and register routes.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function init(): void {

		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );
	}

	/**
	 * Register all REST API routes.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function register_routes(): void {

		register_rest_route(
			self::API_NAMESPACE,
			'/icons',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_icons' ),
				'permission_callback' => array( $this, 'check_permissions' ),
				'args'                => $this->get_icons_args(),
			)
		);
	}

	/**
	 * Define arguments for the icons endpoint.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	private function get_icons_args(): array {
		// No arguments needed for now - returns official icon URL directly
		return array();
	}

	/**
	 * Check permissions for API endpoints.
	 *
	 * Verifies nonce for Gutenberg block requests and ensures user has appropriate capabilities.
	 *
	 * @since 1.0.0
	 * @param WP_REST_Request $request The REST request object
	 * @return bool|WP_Error True if allowed, WP_Error if not
	 */
	public function check_permissions( WP_REST_Request $request ) {

		if ( ! current_user_can( 'read' ) ) {
			return new WP_Error(
				'rest_forbidden',
				__( 'You must be logged in to access this endpoint.', 'dro-aio-discord-block' ),
				array( 'status' => 403 )
			);
		}

		$nonce = $request->get_header( 'X-WP-Nonce' );

		if ( empty( $nonce ) ) {
			$nonce = $request->get_param( '_wpnonce' );
		}

		if ( empty( $nonce ) ) {
			return new WP_Error(
				'missing_nonce',
				__( 'Missing security token. Please refresh the page and try again.', 'dro-aio-discord-block' ),
				array( 'status' => 403 )
			);
		}

		if ( ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
			return new WP_Error(
				'invalid_nonce',
				__( 'Invalid security token. Please refresh the page and try again.', 'dro-aio-discord-block' ),
				array( 'status' => 403 )
			);
		}

		if ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) {
			return true;
		}

		// For non-admin users, ensure they can at least read
		if ( current_user_can( 'read' ) ) {
			return true;
		}

		return new WP_Error(
			'insufficient_permissions',
			__( 'You do not have sufficient permissions to access this endpoint.', 'dro-aio-discord-block' ),
			array( 'status' => 403 )
		);
	}

	/**
	 * Get Discord service icons.
	 *
	 * Returns the official icon URL from the WordPress plugin repository.
	 * Endpoint: GET /wp-json/aio-discord/v1/icons
	 *
	 * @since 1.0.0
	 * @param WP_REST_Request $request The REST request object
	 * @return WP_REST_Response|WP_Error Response object or WP_Error on failure
	 */
	public function get_icons( WP_REST_Request $request ) {
		try {
			$active_service = Discord_Resolver::get_active_service();

			if ( ! $active_service instanceof Discord_Service_Interface ) {
				return new WP_Error(
					'no_active_service',
					__( 'No active Discord service found.', 'dro-aio-discord-block' ),
					array( 'status' => 404 )
				);
			}
			$service_icon = $active_service->get_service_icon_url();

			if ( empty( $service_icon ) ) {
				return new WP_Error(
					'no_icon_available',
					__( 'No icon available for the active service.', 'dro-aio-discord-block' ),
					array( 'status' => 404 )
				);
			}

			if ( ! filter_var( $service_icon, FILTER_VALIDATE_URL ) ) {
				return new WP_Error(
					'invalid_icon_url',
					__( 'Invalid icon URL returned from service.', 'dro-aio-discord-block' ),
					array( 'status' => 500 )
				);
			}

			$response_data = array(
				'success'    => true,
				'data'       => array(
					'icon_url'     => esc_url( $service_icon ),
					'service_name' => method_exists( $active_service, 'get_service_name' )
									? $active_service->get_service_name()
									: 'Discord Service',
					'is_official'  => true,
				),
				'timestamp'  => time(),
				'cache_time' => 3600,
			);

			$response = new WP_REST_Response( $response_data, 200 );

			$response->header( 'Cache-Control', 'public, max-age=3600' );

			return $response;
		} catch ( Exception $e ) {
			return new WP_Error(
				'internal_error',
				__( 'An internal error occurred while fetching the icon.', 'dro-aio-discord-block' ),
				array( 'status' => 500 )
			);
		}
	}

	/**
	 * Get comprehensive service information.
	 *
	 * Endpoint: GET /wp-json/aio-discord/v1/service-info
	 *
	 * @since 1.0.0
	 * @param WP_REST_Request $request The REST request object
	 * @return WP_REST_Response|WP_Error Response object or WP_Error on failure
	 */
	public function get_service_info( WP_REST_Request $request ) {
		try {
			$active_service = Discord_Resolver::get_active_service();
			if ( ! $active_service instanceof Discord_Service_Interface ) {
				return new WP_Error(
					'no_active_service',
					__( 'No active Discord service found.', 'dro-aio-discord-block' ),
					array( 'status' => 404 )
				);
			}

			$service_info = array(
				'service_name' => method_exists( $active_service, 'get_service_name' )
								? $active_service->get_service_name()
								: 'Discord Service',
				'icon_url'     => esc_url( $active_service->get_service_icon_url() ),
				'is_active'    => true,
				'version'      => method_exists( $active_service, 'get_version' )
								? $active_service->get_version()
								: '1.0.0',
			);

			if ( method_exists( $active_service, 'get_service_description' ) ) {
				$service_info['description'] = $active_service->get_service_description();
			}

			if ( method_exists( $active_service, 'get_service_status' ) ) {
				$service_info['status'] = $active_service->get_service_status();
			}

			$response_data = array(
				'success'   => true,
				'data'      => $service_info,
				'timestamp' => time(),
			);

			return new WP_REST_Response( $response_data, 200 );
		} catch ( Exception $e ) {
			return new WP_Error(
				'internal_error',
				__( 'An internal error occurred while fetching service information.', 'dro-aio-discord-block' ),
				array( 'status' => 500 )
			);
		}
	}


	/**
	 * Get the API namespace.
	 *
	 * @since 1.0.0
	 * @return string The API namespace
	 */
	public function get_api_namespace(): string {
		return self::API_NAMESPACE;
	}

	/**
	 * Check if the service is available.
	 *
	 * @since 1.0.0
	 * @return bool True if service is available, false otherwise
	 */
	public function is_service_available(): bool {
		try {
			$active_service = Discord_Resolver::get_active_service();
			return $active_service instanceof Discord_Service_Interface;
		} catch ( Exception $e ) {
			return false;
		}
	}

	/**
	 * Enqueue assets for Gutenberg block editor.
	 *
	 * Provides REST API endpoints and nonce for secure requests from Gutenberg blocks.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_block_editor_assets(): void {
		// Localize script data for Gutenberg blocks
		wp_localize_script(
			'wp-api-fetch', // WordPress core script that handles REST API requests
			'droDiscordApi',
			array(
				'apiUrl'    => rest_url( self::API_NAMESPACE ),
				'nonce'     => wp_create_nonce( 'wp_rest' ),
				'endpoints' => array(
					'icons'       => rest_url( self::API_NAMESPACE . '/icons' ),
					'serviceInfo' => rest_url( self::API_NAMESPACE . '/service-info' ),
				),
			)
		);
	}

	/**
	 * Get REST API endpoints for external use.
	 *
	 * Useful for providing endpoint URLs to JavaScript or other integrations.
	 *
	 * @since 1.0.0
	 * @return array Array of endpoint URLs
	 */
	public function get_endpoints(): array {
		return array(
			'icons'       => rest_url( self::API_NAMESPACE . '/icons' ),
			'serviceInfo' => rest_url( self::API_NAMESPACE . '/service-info' ),
		);
	}
}
