<?php

namespace GiveAddon\Addon;

use Give_License;

class License
{

    /**
     * Check add-on license.
     *
     * @since 1.0.0
     * @return void
     */
    public function check()
    {
        new Give_License(
            ADDON_CONSTANT_FILE,
            ADDON_CONSTANT_NAME,
            ADDON_CONSTANT_VERSION,
            'GiveWP'
        );
    }
}
