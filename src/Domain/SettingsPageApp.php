<?php

namespace GiveAddon\Domain;

use Give_Settings_Page;

/**
 * @unreleased
 */
class SettingsPageApp extends Give_Settings_Page
{
    protected $enable_save = false;

    /**
     * @unreleased
     */
    public function __construct()
    {
        $this->id = 'ADDON_ID-settings-page-app';
        $this->label = esc_html__('ADDON_NAME Settings React App', 'ADDON_TEXTDOMAIN');

        parent::__construct();
    }

    /**
     * @unreleased
     */
    public function output()
    {
        $GLOBALS['give_hide_save_button'] = true;
        ?>
        <div id="ADDON_ID-settings-page-app"></div>
        <?php
    }
}
