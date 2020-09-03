<?php
// Exit if access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Example code to show how to add setting page to give settings.
 *
 * @package     Give
 * @subpackage  Classes/Give_BP_Admin_Settings
 * @copyright   Copyright (c) 2016, WordImpress
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class Give_BP_Admin_Settings extends Give_Settings_Page {

	/**
	 * Give_BP_Admin_Settings constructor.
	 */
	function __construct() {
		$this->id    = 'give-bd-setting-fields';
		$this->label = esc_html__( 'Give Boilerplate Custom Setting ', 'give-addon-boilerplate' );

		$this->default_tab = 'text_fields';

		parent::__construct();
	}


	/**
	 * Add setting sections.
	 *
	 * @return array
	 */
	function get_sections() {
		$sections = [
			'text_fields'     => __( 'Text Fields', 'give-addon-boilerplate' ),
			'radio_fields'    => __( 'Radio Fields', 'give-addon-boilerplate' ),
			'select_fields'   => __( 'Select Fields', 'give-addon-boilerplate' ),
			'checkbox_fields' => __( 'Checkbox Fields', 'give-addon-boilerplate' ),
			'file_fields'     => __( 'File Fields', 'give-addon-boilerplate' ),
		];

		return $sections;
	}


	/**
	 * Get setting.
	 *
	 * @return array
	 */
	function get_settings() {
		$current_section = give_get_current_setting_section();

		switch ( $current_section ) {

			case 'file_fields':
				$settings = [
					/**
					 * File field setting
					 */
					[
						'name' => esc_html__( 'File', 'give-addon-boilerplate' ),
						'desc' => '',
						'id'   => 'file_field_setting',
						'type' => 'title',
					],
					[
						'name' => esc_html__( 'File Field Settings', 'give-addon-boilerplate' ),
						'desc' => '',
						'id'   => 'give_file_field_settings',
						'type' => 'file',
					],
					[
						'id'   => 'file_field_setting',
						'type' => 'sectionend',
					],
				];
				break;

			case 'checkbox_fields':
				$settings = [
					/**
					 * Checkbox field setting
					 */
					[
						'name' => esc_html__( 'Checkbox', 'give-addon-boilerplate' ),
						'desc' => '',
						'id'   => 'checkbox_field_setting',
						'type' => 'title',
					],
					[
						'name' => esc_html__( 'Checkbox Field Settings', 'give-addon-boilerplate' ),
						'desc' => '',
						'id'   => 'give_checkbox_field_settings',
						'type' => 'checkbox',
					],
					[
						'id'   => 'checkbox_field_setting',
						'type' => 'sectionend',
					],

					/**
					 * Multi Checkbox
					 */
					[
						'name' => esc_html__( 'Multi Checkbox', 'give-addon-boilerplate' ),
						'desc' => '',
						'id'   => 'multi_checkbox_field_setting',
						'type' => 'title',
					],
					[
						'name'    => __( 'Checkbox Field Settings', 'give-addon-boilerplate' ),
						'desc'    => '',
						'id'      => 'give_multi_checkbox_field_settings',
						'type'    => 'multicheck',
						'default' => [ 'daily', 'monthly' ],
						'options' => [
							'daily'   => 'Daily',
							'weekly'  => 'Weekly',
							'monthly' => 'Monthly',
						],
					],
					[
						'id'   => 'multi_checkbox_field_setting',
						'type' => 'sectionend',
					],
				];
				break;

			case 'select_fields':
				$settings = [
					/**
					 * Select field setting
					 */
					[
						'name' => esc_html__( 'Select', 'give-addon-boilerplate' ),
						'desc' => '',
						'id'   => 'select_field_setting',
						'type' => 'title',
					],
					[
						'name'    => esc_html__( 'Select Field Settings', 'give-addon-boilerplate' ),
						'desc'    => '',
						'id'      => 'give_select_field_settings',
						'type'    => 'select',
						'default' => 'option_1',
						'options' => [
							'option_1' => __( 'Option 1', 'give-addon-boilerplate' ),
							'option_2' => __( 'Option 2', 'give-addon-boilerplate' ),
							'option_3' => __( 'Option 3', 'give-addon-boilerplate' ),
						],
					],
					[
						'id'   => 'select_field_setting',
						'type' => 'sectionend',
					],

					/**
					 * MultiSelect field setting
					 */
					[
						'name' => esc_html__( 'Multi Select', 'give-addon-boilerplate' ),
						'desc' => '',
						'id'   => 'multi_field_setting',
						'type' => 'title',
					],
					[
						'name'    => esc_html__( 'Multi Select Field Settings', 'give-addon-boilerplate' ),
						'desc'    => '',
						'id'      => 'give_multi_field_settings',
						'type'    => 'multiselect',
						'default' => 'option_1',
						'options' => [
							'option_1' => __( 'Option 1', 'give-addon-boilerplate' ),
							'option_2' => __( 'Option 2', 'give-addon-boilerplate' ),
							'option_3' => __( 'Option 3', 'give-addon-boilerplate' ),
						],
					],
					[
						'id'   => 'multi_field_setting',
						'type' => 'sectionend',
					],
				];
				break;

			case 'radio_fields':
				$settings = [

					/**
					 * Radio field setting.
					 */
					[
						'name' => esc_html__( 'Radio', 'give-addon-boilerplate' ),
						'desc' => '',
						'id'   => 'radio_field_setting',
						'type' => 'title',
					],
					[
						'name'    => esc_html__( 'Radio Field Settings', 'give-addon-boilerplate' ),
						'desc'    => '',
						'id'      => 'give_radio_field_settings',
						'type'    => 'radio',
						'default' => 'option_1',
						'options' => [
							'option_1' => __( 'Option 1', 'give-addon-boilerplate' ),
							'option_2' => __( 'Option 2', 'give-addon-boilerplate' ),
						],
					],
					[
						'id'   => 'radio_field_setting',
						'type' => 'sectionend',
					],

					/**
					 * Inline Radio field setting.
					 */
					[
						'name' => esc_html__( 'Radio inline', 'give-addon-boilerplate' ),
						'desc' => '',
						'id'   => 'radio_inline_field_setting',
						'type' => 'title',
					],
					[
						'name'    => esc_html__( 'Radio Field Settings', 'give-addon-boilerplate' ),
						'desc'    => '',
						'id'      => 'give_radio_inline_field_settings',
						'type'    => 'radio_inline',
						'default' => 'option_1',
						'options' => [
							'option_1' => __( 'Option 1', 'give-addon-boilerplate' ),
							'option_2' => __( 'Option 2', 'give-addon-boilerplate' ),
						],
					],
					[
						'id'   => 'radio_inline_field_setting',
						'type' => 'sectionend',
					],
				];
				break;

			default:
				$settings = [

					/**
					 * Text field setting.
					 */
					[
						'name' => esc_html__( 'Text', 'give-addon-boilerplate' ),
						'desc' => '',
						'id'   => 'text_field_setting',
						'type' => 'title',
					],
					[
						'name' => esc_html__( 'Text Field Settings', 'give-addon-boilerplate' ),
						'desc' => '',
						'id'   => 'give_text_field_settings',
						'type' => 'text',
					],
					[
						'id'   => 'text_field_setting',
						'type' => 'sectionend',
					],

					/**
					 * Email field setting.
					 */
					[
						'name' => esc_html__( 'Email', 'give-addon-boilerplate' ),
						'desc' => '',
						'id'   => 'email_field_setting',
						'type' => 'title',
					],
					[
						'name' => esc_html__( 'Email Field Settings', 'give-addon-boilerplate' ),
						'desc' => '',
						'id'   => 'give_email_field_settings',
						'type' => 'email',
					],
					[
						'id'   => 'give_email_field_settings',
						'type' => 'sectionend',
					],

					/**
					 * Number field setting.
					 */
					[
						'name' => esc_html__( 'Number', 'give-addon-boilerplate' ),
						'desc' => '',
						'id'   => 'number_field_setting',
						'type' => 'title',
					],
					[
						'name' => esc_html__( 'Number Field Settings', 'give-addon-boilerplate' ),
						'desc' => '',
						'id'   => 'give_number_field_settings',
						'type' => 'number',
						'css'  => 'width:12em;',
					],
					[
						'id'   => 'give_number_field_settings',
						'type' => 'sectionend',
					],

					/**
					 * Password field setting.
					 */
					[
						'name' => esc_html__( 'Password', 'give-addon-boilerplate' ),
						'desc' => '',
						'id'   => 'password_field_setting',
						'type' => 'title',
					],
					[
						'name' => esc_html__( 'Password Field Settings', 'give-addon-boilerplate' ),
						'desc' => '',
						'id'   => 'give_password_field_settings',
						'type' => 'password',
						'css'  => 'width:12em;',
					],
					[
						'id'   => 'give_password_field_settings',
						'type' => 'sectionend',
					],

					/**
					 * Textarea field setting.
					 */
					[
						'name' => esc_html__( 'TextArea', 'give-addon-boilerplate' ),
						'desc' => '',
						'id'   => 'textarea_field_setting',
						'type' => 'title',
					],
					[
						'name' => esc_html__( 'Textarea Field Settings', 'give-addon-boilerplate' ),
						'desc' => '',
						'id'   => 'give_textarea_field_settings',
						'type' => 'textarea',
					],
					[
						'id'   => 'give_textarea_field_settings',
						'type' => 'sectionend',
					],
				];
		}

		return $settings;
	}
}

