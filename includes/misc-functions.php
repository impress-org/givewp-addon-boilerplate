<?php
/**
 * Show plugin dependency notice
 *
 * @since
 */
function __give_addon_boilerplate_dependency_notice() {
	// Admin notice.
	$message = sprintf(
		'<strong>%1$s</strong> %2$s <a href="%3$s" target="_blank">%4$s</a>  %5$s %6$s+ %7$s.',
		__( 'Activation Error:', 'give-addon-boilerplate' ),
		__( 'You must have', 'give-addon-boilerplate' ),
		'https://givewp.com',
		__( 'Give', 'give-addon-boilerplate' ),
		__( 'version', 'give-addon-boilerplate' ),
		GIVE_ADDON_BOILERPLATE_MIN_GIVE_VERSION,
		__( 'for the Give Addon Boilerplate add-on to activate', 'give-addon-boilerplate' )
	);

	Give()->notices->register_notice(
		[
			'id'          => 'give-activation-error',
			'type'        => 'error',
			'description' => $message,
			'show'        => true,
		]
	);
}

/**
 * Notice for No Core Activation
 *
 * @since
 */
function __give_addon_boilerplate_inactive_notice() {
	// Admin notice.
	$message = sprintf(
		'<div class="notice notice-error"><p><strong>%1$s</strong> %2$s <a href="%3$s" target="_blank">%4$s</a> %5$s.</p></div>',
		__( 'Activation Error:', 'give-addon-boilerplate' ),
		__( 'You must have', 'give-addon-boilerplate' ),
		'https://givewp.com',
		__( 'Give', 'give-addon-boilerplate' ),
		__( ' plugin installed and activated for the Give Addon Boilerplate add-on to activate', 'give-addon-boilerplate' )
	);

	echo $message;
}


/**
 * Plugin row meta links.
 *
 * @since
 *
 * @param array $plugin_meta An array of the plugin's metadata.
 * @param string $plugin_file Path to the plugin file, relative to the plugins directory.
 *
 * @return array
 */
function __give_addon_boilerplate_plugin_row_meta( $plugin_meta, $plugin_file ) {
	$new_meta_links['setting'] = sprintf(
		'<a href="%1$s">%2$s</a>',
		admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=give-bd-setting-fields' ),
		__( 'Settings', 'give-addon-boilerplate' )
	);

	$new_meta_links['documentation'] = sprintf(
		'<a href="%1$s" target="_blank">%2$s</a>',
		esc_url(
			add_query_arg(
				[
					'utm_source'   => 'plugins-page',
					'utm_medium'   => 'plugin-row',
					'utm_campaign' => 'admin',
				],
				'https://givewp.com/addons/'
			)
		),
		__( 'Add-ons', 'give-addon-boilerplate' )
	);

	return array_merge( $plugin_meta, $new_meta_links );
}


/**
 * Show activation banner
 *
 * @since
 * @return void
 */
function __give_addon_boilerplate_activation_banner() {

	// Check for activation banner inclusion.
	if ( ! class_exists( 'Give_Addon_Activation_Banner' )
		 && file_exists( GIVE_PLUGIN_DIR . 'includes/admin/class-addon-activation-banner.php' )
	) {

		include GIVE_PLUGIN_DIR . 'includes/admin/class-addon-activation-banner.php';
	}

	// Initialize activation welcome banner.
	if ( class_exists( 'Give_Addon_Activation_Banner' ) ) {

		// Only runs on admin.
		$args = [
			'file'              => GIVE_ADDON_BOILERPLATE_FILE,
			'name'              => __( 'Boilerplate', 'give-addon-boilerplate' ),
			'version'           => GIVE_ADDON_BOILERPLATE_VERSION,
			'settings_url'      => admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=give-bd-setting-fields' ),
			'documentation_url' => 'https://givewp.com/documentation/add-ons/boilerplate/',
			'support_url'       => 'https://givewp.com/support/',
			'testing'           => false, // Never leave true.
		];

		new Give_Addon_Activation_Banner( $args );

	}
}
