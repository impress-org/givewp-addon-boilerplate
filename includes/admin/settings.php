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
		$this->label = esc_html__( 'Give Boilerplate Custom Setting ' );

		$this->default_tab = 'text_fields';

		parent::__construct();
	}


	/**
	 * Add setting sections.
	 *
	 * @return array
	 */
	function get_sections() {
		$sections = array(
			'text_fields'     => __( 'Text Fields', 'give' ),
			'radio_fields'    => __( 'Radio Fields', 'give' ),
			'select_fields'   => __( 'Select Fields', 'give' ),
			'checkbox_fields' => __( 'Checkbox Fields', 'give' ),
			'file_fields'     => __( 'File Fields', 'give' ),
		);

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
				$settings = array(
					/**
					 * File field setting
					 */
					array(
						'name' => esc_html__( 'File', 'give' ),
						'desc' => '',
						'id'   => 'file_field_setting',
						'type' => 'title',
					),
					array(
						'name' => esc_html__( 'File Field Settings', 'give' ),
						'desc' => '',
						'id'   => 'give_file_field_settings',
						'type' => 'file',
					),
					array(
						'id'   => 'file_field_setting',
						'type' => 'sectionend',
					),
				);
				break;

			case 'checkbox_fields' :
				$settings = array(
					/**
					 * Checkbox field setting
					 */
					array(
						'name' => esc_html__( 'Checkbox', 'give' ),
						'desc' => '',
						'id'   => 'checkbox_field_setting',
						'type' => 'title',
					),
					array(
						'name' => esc_html__( 'Checkbox Field Settings', 'give' ),
						'desc' => '',
						'id'   => 'give_checkbox_field_settings',
						'type' => 'checkbox',
					),
					array(
						'id'   => 'checkbox_field_setting',
						'type' => 'sectionend',
					),

					/**
					 * Multi Checkbox
					 */
					array(
						'name' => esc_html__( 'Multi Checkbox', 'give' ),
						'desc' => '',
						'id'   => 'multi_checkbox_field_setting',
						'type' => 'title',
					),
					array(
						'name'    => __( 'Checkbox Field Settings', 'give' ),
						'desc'    => '',
						'id'      => 'give_multi_checkbox_field_settings',
						'type'    => 'multicheck',
						'default' => array( 'daily', 'monthly' ),
						'options' => array(
							'daily'   => 'Daily',
							'weekly'  => 'Weekly',
							'monthly' => 'Monthly',
						),
					),
					array(
						'id'   => 'multi_checkbox_field_setting',
						'type' => 'sectionend',
					),
				);
				break;

			case 'select_fields':
				$settings = array(
					/**
					 * Select field setting
					 */
					array(
						'name' => esc_html__( 'Select', 'give' ),
						'desc' => '',
						'id'   => 'select_field_setting',
						'type' => 'title',
					),
					array(
						'name'    => esc_html__( 'Select Field Settings', 'give' ),
						'desc'    => '',
						'id'      => 'give_select_field_settings',
						'type'    => 'select',
						'default' => 'option_1',
						'options' => array(
							'option_1' => __( 'Option 1', 'give' ),
							'option_2' => __( 'Option 2', 'give' ),
							'option_3' => __( 'Option 3', 'give' ),
						),
					),
					array(
						'id'   => 'select_field_setting',
						'type' => 'sectionend',
					),

					/**
					 * MultiSelect field setting
					 */
					array(
						'name' => esc_html__( 'Multi Select', 'give' ),
						'desc' => '',
						'id'   => 'multi_field_setting',
						'type' => 'title',
					),
					array(
						'name'    => esc_html__( 'Multi Select Field Settings', 'give' ),
						'desc'    => '',
						'id'      => 'give_multi_field_settings',
						'type'    => 'multiselect',
						'default' => 'option_1',
						'options' => array(
							'option_1' => __( 'Option 1', 'give' ),
							'option_2' => __( 'Option 2', 'give' ),
							'option_3' => __( 'Option 3', 'give' ),
						),
					),
					array(
						'id'   => 'multi_field_setting',
						'type' => 'sectionend',
					),
				);
				break;

			case 'radio_fields' :
				$settings = array(

					/**
					 * Radio field setting.
					 */
					array(
						'name' => esc_html__( 'Radio', 'give' ),
						'desc' => '',
						'id'   => 'radio_field_setting',
						'type' => 'title',
					),
					array(
						'name'    => esc_html__( 'Radio Field Settings', 'give' ),
						'desc'    => '',
						'id'      => 'give_radio_field_settings',
						'type'    => 'radio',
						'default' => 'option_1',
						'options' => array(
							'option_1' => __( 'Option 1', 'give' ),
							'option_2' => __( 'Option 2', 'give' ),
						),
					),
					array(
						'id'   => 'radio_field_setting',
						'type' => 'sectionend',
					),

					/**
					 * Inline Radio field setting.
					 */
					array(
						'name' => esc_html__( 'Radio inline', 'give' ),
						'desc' => '',
						'id'   => 'radio_inline_field_setting',
						'type' => 'title',
					),
					array(
						'name'    => esc_html__( 'Radio Field Settings', 'give' ),
						'desc'    => '',
						'id'      => 'give_radio_inline_field_settings',
						'type'    => 'radio_inline',
						'default' => 'option_1',
						'options' => array(
							'option_1' => __( 'Option 1', 'give' ),
							'option_2' => __( 'Option 2', 'give' ),
						),
					),
					array(
						'id'   => 'radio_inline_field_setting',
						'type' => 'sectionend',
					),
				);
				break;

			default:
				$settings = array(

					/**
					 * Text field setting.
					 */
					array(
						'name' => esc_html__( 'Text', 'give' ),
						'desc' => '',
						'id'   => 'text_field_setting',
						'type' => 'title',
					),
					array(
						'name' => esc_html__( 'Text Field Settings', 'give' ),
						'desc' => '',
						'id'   => 'give_text_field_settings',
						'type' => 'text',
					),
					array(
						'id'   => 'text_field_setting',
						'type' => 'sectionend',
					),

					/**
					 * Email field setting.
					 */
					array(
						'name' => esc_html__( 'Email', 'give' ),
						'desc' => '',
						'id'   => 'email_field_setting',
						'type' => 'title',
					),
					array(
						'name' => esc_html__( 'Email Field Settings', 'give' ),
						'desc' => '',
						'id'   => 'give_email_field_settings',
						'type' => 'email',
					),
					array(
						'id'   => 'give_email_field_settings',
						'type' => 'sectionend',
					),

					/**
					 * Number field setting.
					 */
					array(
						'name' => esc_html__( 'Number', 'give' ),
						'desc' => '',
						'id'   => 'number_field_setting',
						'type' => 'title',
					),
					array(
						'name' => esc_html__( 'Number Field Settings', 'give' ),
						'desc' => '',
						'id'   => 'give_number_field_settings',
						'type' => 'number',
						'css'  => 'width:12em;',
					),
					array(
						'id'   => 'give_number_field_settings',
						'type' => 'sectionend',
					),


					/**
					 * Password field setting.
					 */
					array(
						'name' => esc_html__( 'Password', 'give' ),
						'desc' => '',
						'id'   => 'password_field_setting',
						'type' => 'title',
					),
					array(
						'name' => esc_html__( 'Password Field Settings', 'give' ),
						'desc' => '',
						'id'   => 'give_password_field_settings',
						'type' => 'password',
						'css'  => 'width:12em;',
					),
					array(
						'id'   => 'give_password_field_settings',
						'type' => 'sectionend',
					),

					/**
					 * Textarea field setting.
					 */
					array(
						'name' => esc_html__( 'TextArea', 'give' ),
						'desc' => '',
						'id'   => 'textarea_field_setting',
						'type' => 'title',
					),
					array(
						'name' => esc_html__( 'Textarea Field Settings', 'give' ),
						'desc' => '',
						'id'   => 'give_textarea_field_settings',
						'type' => 'textarea',
					),
					array(
						'id'   => 'give_textarea_field_settings',
						'type' => 'sectionend',
					),
				);
		}

		return $settings;
	}
}

