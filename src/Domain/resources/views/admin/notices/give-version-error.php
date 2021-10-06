<?php
defined('ABSPATH') or exit; ?>

<strong>
    <?php
    _e('Activation Error:', 'ADDON_TEXTDOMAIN'); ?>
</strong>
<?php
_e('You must have', 'ADDON_TEXTDOMAIN'); ?> <a href="https://givewp.com" target="_blank">GiveWP</a>
<?php
_e('version', 'ADDON_TEXTDOMAIN'); ?> <?php
echo GIVE_VERSION; ?>+
<?php
printf(esc_html__('for the %1$s add-on to activate', 'ADDON_TEXTDOMAIN'), ADDON_CONSTANT_NAME); ?>.

