<?php

namespace GiveAddon\OffSiteGateway\Gateway;

/**
 * IMPORTANT: you don't need to keep this file in your integration; this is just a sample to demonstrate how off-site gateway integrations should work.
 *
 * @since 1.0.0
 */
class OffSiteCheckoutPageSimulation
{
    /**
     * @since 1.0.0
     */
    public function __invoke()
    {
        if ( ! isset($_GET['off-site-gateway-simulation'])) {
            return;
        }

        /**
         * We need to do this workaround because the legacy forms submit logic tries to redirect URLs from
         * the same site inside the donation form iframe instead of using the parent page as the reference.
         */
        if ($this->isLegacyFormReferrer()) {
            echo '<script>window.top.location.href ="' . home_url($_SERVER['REQUEST_URI']) . '";</script>';
            exit();
        }

        ob_start();

        $this->loadOffSiteGatewaySimulationMarkup();

        echo ob_get_clean();

        exit();
    }

    /**
     * @since 1.0.0
     */
    private function isLegacyFormReferrer(): bool
    {
        //V2 referrer: https://example.com/give/v2-tests?giveDonationFormInIframe=1
        //V3 referrer: https://example.com/?givewp-route=donation-form-view&form-id=1350
        return strpos($_SERVER['HTTP_REFERER'], 'giveDonationFormInIframe') !== false;
    }

    /**
     * @since 1.0.0
     */
    private function loadOffSiteGatewaySimulationMarkup()
    {
        ?>
        <style>
            .container {
                font-family: "Open Sans", Helvetica, Arial, sans-serif;
                max-width: 800px;
                margin: 60px auto;
            }
            a {
                font-size: 1.5rem;
            }
        </style>
        <div class="container">
            <h1>Off-site Checkout Page Simulation</h1>
            <p>
                Gateway Payment ID: <strong><?php
                    echo $_GET['gatewayPaymentId'] ?? ' -'; ?></strong>
            </p>
            <p>
                Donation amount: <strong><?php
                    echo isset($_GET['amount']) ? $_GET['amount']['currency'] . ' ' . $_GET['amount']['value'] : ' -'; ?></strong>
            </p>
            <p>
                Description: <strong><?php
                    echo $_GET['description'] ?? ' -'; ?></strong>
            </p>
            <hr />
            <p>
                <strong>Click on the links below to simulate off-site gateway actions:</strong>
            </p>
            <a style="color:#696969;font-weight:bold;font-size: 1.2rem" target="_blank" rel="noopener noreferrer"
               href="<?php
            echo add_query_arg([
                'notification_type' => 'one-time',
                'payment_status' => 'complete',
                'payment_id' => $_GET['gatewayPaymentId'],
                'merchant_payment_id' => $_GET['merchantPaymentId'],
            ],
                $_GET['webhookUrl']) ?>">
                Send Webhook Notification To Change Donation Status To Complete ⭷
            </a>
            <p>
                🛈 Some gateways send webhook notifications to change the transaction status a few hours after the
                payment process is finished, and others can send them even before the user is redirected back to the
                referrer's website — the action above simulates this last scenario.
            </p>
            <a style="color:green;font-weight: bold;" href="<?php
            echo $_GET['returnUrl'] ?>">Success Payment</a> | <a style="color:red;font-weight: bold;" href="<?php
            echo $_GET['cancelUrl'] ?>">Canceled Payment</a>
            <br />
            <br />
            <p>
                ⚠️ This page is being loaded directly from your website to demonstrate how off-site gateways work. In
                real-world integrations, this page should be the checkout page provided by the gateway you are
                integrating, so users can complete or cancel the payment and be redirected back to your site.
            </p>
        </div>
        <?php
    }
}
