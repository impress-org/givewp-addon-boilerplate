<?php defined( 'ABSPATH' ) or exit; ?>

<div class="notice notice-error">
	<p>
		<strong><?php _e( 'Activation Error:', 'ADDON_TEXTDOMAIN' ); ?></strong>
		<?php _e( 'You must have the', 'ADDON_TEXTDOMAIN' ); ?> <a href="https://givewp.com" target="_blank">GiveWP</a>
		<?php printf( __( 'plugin installed and activated for the %s add-on to activate', 'ADDON_TEXTDOMAIN' ), ADDON_CONSTANT_NAME ); ?>
	</p>
</div>
