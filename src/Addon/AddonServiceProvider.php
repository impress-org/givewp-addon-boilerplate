<?php
namespace GiveAddon\Addon;

use Give\Helpers\Hooks;
use Give\ServiceProviders\ServiceProvider;

use GiveAddon\Addon\Helpers\License;
use GiveAddon\Addon\Helpers\SettingsPage;
use GiveAddon\Addon\Helpers\Language;
use GiveAddon\Addon\SettingsPage as AddonSettingsPage;
use GiveAddon\Addon\Helpers\ActivationBanner;

/**
 * Example of a service provider responsible for add-on initialization.
 *
 * @package     GiveAddon\Addon
 * @copyright   Copyright (c) 2020, GiveWP
 */
class AddonServiceProvider implements ServiceProvider {

	/**
	 * @inheritDoc
	 */
	public function register() {
		give()->singleton( Activation::class );
	}

	/**
	 * @inheritDoc
	 */
	public function boot() {
		// Load add-on translations.
		Hooks::addAction( 'admin_init', Language::class, 'load' );

		is_admin()
			? $this->loadBackend()
			: $this->loadFrontend();

	}


	private function loadBackend() {
		// Register settings page
		SettingsPage::registerPage( AddonSettingsPage::class );
		// Activation hooks.
		Hooks::addAction( 'admin_init', Activation::class, 'registerActions' );
		Hooks::addAction( 'admin_init', License::class, 'check' );
		Hooks::addAction( 'admin_init', ActivationBanner::class, 'show' );
		// Load backend assets.
		Hooks::addAction( 'admin_enqueue_scripts', Assets::class, 'loadBackendAssets' );
		/**
		 * Example of how to extend an existing settings page.
		 */

		//      // Remove settings page section.
		//      SettingsPage::removePageSection( 'general', 'access-control' );
		//      // Add new settings page section.
		//      SettingsPage::addPageSection( 'general', 'new-section', 'New Access Control Section' );
		//      // Add page settings.
		//      SettingsPage::addSettings( 'general', 'new-section', [
		//          [
		//              'name' => __( 'Custom Setting Field', 'give-addon-boilerplate' ),
		//              'id'   => 'custom_setting_field',
		//              'desc' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ', 'give-addon-boilerplate' ),
		//              'type' => 'text'
		//          ]
		//      ] );
	}


	private function loadFrontend() {
		// Load front-end assets.
		Hooks::addAction( 'admin_enqueue_scripts', Assets::class, 'loadFrontendAssets' );
	}

}
