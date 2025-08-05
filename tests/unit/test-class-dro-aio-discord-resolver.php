<?php

declare(strict_types=1);

use Dro\AIODiscordBlock\includes\Dro_AIO_Discord_Resolver as Discord_Resolver;

class Dro_AIO_Discord_Resolver_Test extends WP_UnitTestCase {

    public function set_up() {
        parent::set_up();
    }

    public function tear_down() {
        Discord_Resolver::reset(); // Clear cached service
        delete_option( 'active_plugins' );
        parent::tear_down();
    }

    /**
     * Data provider for testResolve
     *
     * @return array
     */
    public function addOnProvider(): array {
        return [
            'pmpro' => [
                'pmpro-discord-add-on/pmpro-discord.php',
                'Dro\\AIODiscordBlock\\includes\\Services\\Dro_AIO_Discord_PMPro',
            ],
            'memberpress' => [
                'connect-memberpress-discord-add-on/memberpress-discord.php',
                'Dro\\AIODiscordBlock\\includes\\Services\\Dro_AIO_Discord_Memberpress',
            ],
            'ultimate_member' => [
                'ultimate-member-discord-add-on/ultimate-member-discord-add-on',
                'Dro\\AIODiscordBlock\\includes\\Services\\Dro_AIO_Discord_Ultimate_Member',
            ],
            'tutor_lms' => [
                'connect-discord-tutor-lms/connect-discord-tutor-lms.php',
                'Dro\\AIODiscordBlock\\includes\\Services\\Dro_AIO_Discord_Tutor_LMS',
            ],
        ];
    }

    /**
     * @dataProvider addOnProvider
     */
    public function test_resolve( string $plugin, string $expected_class ) {
        // Reset service resolver to clear static state
        Discord_Resolver::reset();

        // Activate only the plugin being tested
        update_option( 'active_plugins', [ $plugin ] );

        // Resolve the Discord service
        $service = Discord_Resolver::resolve();

        // Assert that the resolved instance matches the expected class
        $this->assertInstanceOf( $expected_class, $service );
    }
}
