<?php
/**
 * Show plugin dependency notice
 *
 * @since
 */
function __give_addon_boilerplate_dependency_notice(){
	// Admin notice.
	$message = sprintf(
		'<strong>%1$s</strong> %2$s <a href="%3$s" target="_blank">%4$s</a>  %5$s %6$s+ %7$s.',
		__( 'Activation Error:', 'giveboilerplate' ),
		__( 'You must have', 'giveboilerplate' ),
		'https://givewp.com',
		__( 'Give', 'giveboilerplate' ),
		__( 'version', 'giveboilerplate' ),
		GIVE_ADDON_BOILERPLATE_VERSION,
		__( 'for the Recurring Donations add-on to activate', 'giveboilerplate' )
	);

	Give()->notices->register_notice( array(
		'id'          => 'give-activation-error',
		'type'        => 'error',
		'description' => $message,
		'show'        => true,
	) );
}