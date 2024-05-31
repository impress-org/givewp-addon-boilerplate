<?php

namespace GiveAddon\OffSiteGateway\Gateway;

class OffSiteSimulation
{
    public function __invoke()
    {
        if ( ! isset($_GET['off-site-gateway-simulation'])) {
            return;
        }

        $referrer = $_SERVER['HTTP_REFERER'];

        //V2 referrer: https://givewp.local/give/v2-tests?giveDonationFormInIframe=1

        //V3 referrer: https://givewp.local/?givewp-route=donation-form-view&form-id=1350


        echo 'Off-site Gateway Simulation';

        exit();
    }
}
