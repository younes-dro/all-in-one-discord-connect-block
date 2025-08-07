<?php
/**
 * Tutor LMS Discord Service Implementation
 *
 * Handles integration between Tutor LMS and Discord for user access and role mapping.
 *
 * @package  Dro\AIODiscordBlock\Services
 * @category Plugin
 * @author   Younes DRO
 * @license  GPL-2.0-or-later
 * @version  GIT: 1.0.0
 * @link     https://github.com/younes-dro/all-in-one-discord-connect-block
 */

namespace Dro\AIODiscordBlock\includes\Services;

use Dro\AIODiscordBlock\includes\Abstracts\Dro_AIO_Discord_Service;
use Dro\AIODiscordBlock\includes\Interfaces\Dro_AIO_Discord_Service_Interface;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Dro_AIO_Discord_TutorLMS
 *
 * Provides Tutor LMS integration for Discord role syncing.
 */
class Dro_AIO_Discord_TutorLMS extends Dro_AIO_Discord_Service implements Dro_AIO_Discord_Service_Interface {

	private const PLUGIN_NAME = 'connect-discord-tutor-lms/connect-discord-tutor-lms.php';

	/**
	 * Get the plugin slug.
	 *
	 * @return string
	 */
	protected function get_plugin_name(): string {
		return self::PLUGIN_NAME;
	}

	/**
	 * Check if Tutor LMS plugin is active.
	 *
	 * @return bool
	 */
	public function is_plugin_active(): bool {
		return $this->check_active_plugin();
	}

	/**
	 * Get Discord username linked to this Tutor LMS account.
	 *
	 * @param int $user_id
	 * @return string|null
	 */
	public function get_user_connected_account( int $user_id ): string|null {
		return get_user_meta( $user_id, '_tutor_discord_username', true ) ?: null;
	}

	/**
	 * Get enrolled course IDs for the user.
	 *
	 * @param int $user_id
	 * @return array<int>|null
	 */
	public function get_user_access_context( int $user_id ): array|null {
		// $course_ids = tutor_utils()->get_enrolled_courses_by_user( $user_id );

		// if ( ! is_array( $course_ids ) || empty( $course_ids ) ) {
		// return null;
		// }

		// return array_map( 'intval', $course_ids );
	}

	/**
	 * Get Discord role IDs based on enrolled courses.
	 *
	 * @param int $user_id
	 * @return array<int>|null
	 */
	public function get_user_active_discord_roles_ids( int $user_id ): array|null {
		// TODO: Map course IDs to Discord roles.
		return null;
	}

	/**
	 * Internal identifier for this service.
	 *
	 * @return string
	 */
	public function get_service_name(): string {
		return 'tutor-lms-discord-service';
	}

	/**
	 * Tutor LMS service icon in base64.
	 *
	 * @return string
	 */
	public function get_service_icon_url(): string {
		// TODO: Add Tutor LMS base64 icon string.
		return '';
	}
	public function build_html_block( array $attributes, string $content, \WP_Block $block ): string {
		// TODO: Implement the HTML block rendering logic.
		return '';
	}
}
