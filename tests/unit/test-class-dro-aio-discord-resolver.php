<?php
/**
 *
 */

declare(strict_types=1);

use Dro\AIODiscordBlock\includes\Dro_AIO_Discord_Resolver as Discord_Resolver;

class Dro_AIO_Discord_Resolver_Test extends WP_UnitTestCase{


	public function set_up()
	{

		parent::set_up();
		$this->mock_active_plugin();
	}
	public function tear_down()
	{
		delete_option( 'active_plugins' );
		parent::tear_down();

	}

	private function mock_active_plugin(){
		$pmpro_discord_addon_slug = 'pmpro-discord-add-on/pmpro-discord.php';

		update_option( 'active_plugins', array($pmpro_discord_addon_slug));
	}

	public function test_resolve(){

		$active_service = Discord_Resolver::resolve();

		$reflection_resolver = new ReflectionClass(Discord_Resolver::class);
		$reflection_active_service = $reflection_resolver->getProperty( 'active_service');
		$reflection_active_service->setAccessible(true);

		$a = $reflection_active_service->getValue( $reflection_active_service);

		$this->assertEquals( 'pmpro', $a);

		error_log(print_r($active_service,true));

	}
	public function test_pmpro_get_active_service(){

	}

}
