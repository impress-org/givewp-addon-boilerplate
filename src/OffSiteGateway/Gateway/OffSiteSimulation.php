<?php

namespace GiveAddon\OffSiteGateway\Gateway;

/**
 * @unreleased
 */
class OffSiteSimulation
{
    /**
     * @unreleased
     */
    public function __invoke()
    {
        if ( ! isset($_GET['off-site-gateway-simulation'])) {
            return;
        }

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
     * @unreleased
     */
    private function isLegacyFormReferrer(): bool
    {
        //V2 referrer: https://example.com/give/v2-tests?giveDonationFormInIframe=1
        //V3 referrer: https://example.com/?givewp-route=donation-form-view&form-id=1350
        return strpos($_SERVER['HTTP_REFERER'], 'giveDonationFormInIframe') !== false;
    }

    /**
     * @unreleased
     */
    private function loadOffSiteGatewaySimulationMarkup()
    {
        ?>
        <style>
            .container {
                font-family: "Open Sans", Helvetica, Arial, sans-serif;
                max-width: 800px;
                margin: 100px auto;
            }

            a {
                font-size: 1.5rem;
            }
        </style>
        <div class="container">
            <h1>
                <?php
                echo esc_html__('Off-site Gateway Simulation', 'ADDON_TEXTDOMAIN');
                ?>
            </h1>
            <p>
                <?php
                echo esc_html__('Donation amount:', 'ADDON_TEXTDOMAIN');
                ?>
                <strong>
                    <?php
                    echo isset($_GET['amount']) ? $_GET['amount']['currency'] . ' ' . $_GET['amount']['value'] : 0;
                    ?>
                </strong>
            </p>
            <hr />
            <p>
                <strong>
                    <?php
                    echo esc_html__('Click on the links below to simulate off-site gateway actions:',
                        'ADDON_TEXTDOMAIN');
                    ?>
                </strong>
            </p>
            <a style="color:green;font-weight: bold;" href="<?php
            echo $_GET['returnUrl'] ?>">Success Payment</a> | <a style="color:red;font-weight: bold;" href="<?php
            echo $_GET['cancelUrl'] ?>">Canceled Payment</a>
            <br />
            <br />
            <p>
                <?php
                echo ⚠️ . esc_html__('This page is being loaded directly from your site to demonstrate how off-site gateways work. In real-world integrations, this page should be the checkout page provided by the gateway you are integrating, so users can complete or cancel the payment and be redirected back to your site.',
                        'ADDON_TEXTDOMAIN');
                ?>
            </p>
        </div>
        <?php
    }
}
