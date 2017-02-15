<?php
/**
 * The Give Addon Boilerplate Metabox
 *
 * This file creates a new Metabox on all Give Form Edit screens
 *
 * @copyright   Copyright (c) 2015, WordImpress
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Because Give already requires CMB2
// And this Addon requires Give, there's no need to require CMB2
// We can just jump right into metabox creation with the CMB2 action
add_action( 'cmb2_admin_init', 'give_addon_boilerplate_metabox' );

function give_addon_boilerplate_metabox() {
	// Start with an underscore to hide fields from custom fields list
	$prefix = '_giveboilerplate_';
	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$giveaddboil = new_cmb2_box( array(
		'id'           => $prefix . 'give_addboil_metabox',
		'title'        => __( 'Boilerplate Metabox', 'giveboilerplate' ),
		'object_types' => array( 'give_forms' ),
		'context'      => 'normal',
		'priority'     => 'core',
	) );

	$giveaddboil->add_field( array(
		'name' => __( 'Boilerplate Text Field', 'giveboilerplate' ),
		'desc' => __( 'This is just a simple text field shown for demo purposes.', 'ggfd' ),
		'id'   => $prefix . 'demo_title',
		'type' => 'text',
	) );

}
