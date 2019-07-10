<?php
/**
 * Add setting to exiting section and tab
 * If you want to add setting to existing tab and existing section then find a required filter for setting and add your logic.
 * With current code we are adding a setting field to "General" section of "General" tab
 *
 * @param $settings
 *
 * @return array
 */
function give_bp_add_setting_into_existing_tab( $settings ) {
	if ( ! Give_Admin_Settings::is_setting_page( 'general', 'general-settings' ) ) {
		return $settings;
	}

	// Make sure you will create your own section or add new setting before array with type 'sectionend' otherwise setting field with not align properly with other setting fields.
	$new_setting = array();
	foreach ( $settings as $key => $setting ) {
		if( 'give_docs_link' === $setting['type'] ) { // You can use id to compare or create own sub section to add new setting.
			$new_setting[] = array(
				'name' => __( 'Custom Setting Field', 'give' ),
				'id'   => 'custom_setting_field',
				'desc' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ' ),
				'type' => 'text',
			);
		}

		$new_setting[] = $setting;
	}

	return $new_setting;
}

add_filter( 'give_get_settings_general', 'give_bp_add_setting_into_existing_tab' );


/**
 * Add setting to new section 'Custom Settings' of 'General' Tab
 * @param $settings
 *
 * @return array
 */
function give_bp_add_setting_into_new_section( $settings ) {
	if ( ! Give_Admin_Settings::is_setting_page( 'general', 'custom-settings' ) ) {
		return $settings;
	}

	$settings[] = array(
		'type' => 'title',
		'id'   => 'custom_settings',
	);

	$settings[] = array(
		'name' => __( 'Custom Setting Field', 'give' ),
		'id'   => 'custom_setting_field',
		'desc' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ' ),
		'type' => 'text',
	);

	$settings[] = array(
		'id'   => 'custom_settings',
		'type' => 'sectionend',
	);

	return $settings;
}

add_filter( 'give_get_settings_general', 'give_bp_add_setting_into_new_section' );

/**
 * Add new section to "General" setting tab
 *
 * @param $sections
 *
 * @return array
 */
function give_bd_add_new_setting_section( $sections ) {
	$sections['custom-settings'] = __( 'Custom Settings' );
	return $sections;
}

add_filter( 'give_get_sections_general', 'give_bd_add_new_setting_section' );
