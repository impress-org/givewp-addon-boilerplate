<?php

namespace GiveAddon\OffSiteGateway;

use Exception;
use Give\Framework\PaymentGateways\PaymentGatewayRegister;
use Give\Helpers\Hooks;
use Give\ServiceProviders\ServiceProvider;
use GiveAddon\OffSiteGateway\Gateway\OffSiteCheckoutPageSimulation;
use GiveAddon\OffSiteGateway\Gateway\OffSiteGateway;

/**
 * @since 1.0.0
 */
class OffSiteGatewayServiceProvider implements ServiceProvider
{
    /**
     * @since 1.0.0
     */
    public function register()
    {
        // TODO: Implement register() method.
    }

    /**
     * @since 1.0.0
     *
     * @throws Exception
     */
    public function boot()
    {
        add_action(
            'givewp_register_payment_gateway',
            function (PaymentGatewayRegister $registrar) {
                $registrar->registerGateway(OffSiteGateway::class);
            }
        );

        /**
         * IMPORTANT: remember to remove this hook when removing the OffSiteCheckoutPageSimulation class from your real-world gateway integration.
         */
        Hooks::addAction('init', OffSiteCheckoutPageSimulation::class);
    }
}
