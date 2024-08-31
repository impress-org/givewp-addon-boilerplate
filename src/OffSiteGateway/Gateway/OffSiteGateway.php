<?php

namespace GiveAddon\OffSiteGateway\Gateway;

use Exception;
use Give\Donations\Models\Donation;
use Give\Donations\Models\DonationNote;
use Give\Donations\ValueObjects\DonationStatus;
use Give\Framework\Http\Response\Types\RedirectResponse;
use Give\Framework\PaymentGateways\Commands\RedirectOffsite;
use Give\Framework\PaymentGateways\Exceptions\PaymentGatewayException;
use Give\Framework\PaymentGateways\Log\PaymentGatewayLog;
use Give\Framework\PaymentGateways\PaymentGateway;
use Give\Framework\Support\Facades\Scripts\ScriptAsset;
use GiveAddon\OffSiteGateway\DataTransferObjects\OffSiteGatewayPayment;
use GiveAddon\OffSiteGateway\DataTransferObjects\OffSiteGatewayWebhookNotification;
use GiveAddon\OffSiteGateway\Webhooks\OffSiteGatewaysWebhookNotificationHandler;

/**
 * @unreleased
 */
class OffSiteGateway extends PaymentGateway
{
    /**
     * @unreleased
     */
    public $secureRouteMethods = [
        'handleSuccessPaymentReturn',
        'handleCanceledPaymentReturn',
    ];

    /**
     * @unreleased
     */
    public $routeMethods = [
        'webhookNotificationsListener',
    ];

    /**
     * @unreleased
     */
    public function getWebhookNotificationsListener(): string
    {
        return $this->routeMethods[0];
    }

    /**
     * @unreleased
     */
    public static function id(): string
    {
        return 'ADDON_ID-off-site-gateway';
    }

    /**
     * @unreleased
     */
    public function getId(): string
    {
        return self::id();
    }

    /**
     * @unreleased
     */
    public function getName(): string
    {
        return __('ADDON_NAME - Off-Site Gateway', 'ADDON_TEXTDOMAIN');
    }

    /**
     * @unreleased
     */
    public function getPaymentMethodLabel(): string
    {
        return __('ADDON_NAME - Off-Site Gateway', 'ADDON_TEXTDOMAIN');
    }

    /**
     * Add support to v2 forms
     *
     * @unreleased
     */
    public function getLegacyFormFieldMarkup(int $formId, array $args): string
    {
        return sprintf(
            '<div style="text-align: center;"><img src="%s" alt="OffSite Gateway Logo" /><p>%s</p></div>',
            ADDON_CONSTANT_URL . 'src/OffSiteGateway/Gateway/resources/logo.svg',
            __('You will be redirected to an Off-Site Gateway simulation where will be possible to complete the payment and trigger webhook notifications for test purposes.',
                'ADDON_TEXTDOMAIN')
        );
    }

    /**
     * Add support to v3 forms
     *
     * @unreleased
     */
    public function enqueueScript(int $formId)
    {
        $assets = ScriptAsset::get(trailingslashit(ADDON_CONSTANT_DIR) . '/build/GiveAddonOffSiteGateway.asset.php');

        wp_enqueue_script(
            self::id(),
            trailingslashit(ADDON_CONSTANT_URL) . 'build/GiveAddonOffSiteGateway.js',
            $assets['dependencies'],
            $assets['version'],
            true
        );

        wp_enqueue_style(
            self::id(),
            trailingslashit(ADDON_CONSTANT_URL) . 'build/GiveAddonOffSiteGateway.css',
            [],
            $assets['version']
        );
    }

    /**
     * @unreleased
     *
     * @throws Exception
     */
    public function createPayment(Donation $donation, $gatewayData): RedirectOffsite
    {
        try {
            /**
             * Some gateways can provide an API that allows creating a transaction before redirecting to the off-site
             * checkout page, in these cases we can retrieve the gateway transaction ID and attach it to our donation
             * even before redirecting donors - we are doing it in this sample integration.
             *
             * We also are setting the donation status to PENDING because it will be changed to COMPLETE when the
             * donor is redirected back to the site and the  "handleSuccessPaymentReturn" method is triggered OR
             * when the "OffSiteGatewayWebhookRequestHandler" class receives a webhook notification sent from the
             * "OffSiteCheckoutPageSimulation" even before the donor being redirected back to the site.
             */
            $offSiteGatewayPayment = $this->createGiveAddonOffSiteGatewayPaymentApi($donation);
            $donation->gatewayTransactionId = $offSiteGatewayPayment->gatewayPaymentId;
            $donation->status = DonationStatus::PENDING();
            $donation->save();

            /**
             * Get the parameters that will be sent to the gateway off-site checkout page, in this sample integration
             * it will be sent to the "OffSiteCheckoutPageSimulation" where you can complete or cancel the donation.
             */
            $paymentParameters = $this->getPaymentParameters($donation, $gatewayData);

            /**
             * This additional parameter is necessary to make the off-site checkout page simulation work;
             * In real-world integrations, this parameter isn't necessary.
             */
            $paymentParameters['off-site-gateway-simulation'] = true;

            /**
             * Please note that we are using the "home_url()" method to redirect the donor to the "OffSiteCheckoutPageSimulation"
             * class which is an internal page that simulates an external page, but in real-world integrations, the donor should
             * be redirected to a real external checkout page provided by the gateway you are integrating.
             */
            $redirectUrl = add_query_arg($paymentParameters, home_url());

            return new RedirectOffsite($redirectUrl);
        } catch (Exception $e) {
            $donation->status = DonationStatus::FAILED();
            $donation->save();

            $errorMessage = $e->getMessage();

            DonationNote::create([
                'donationId' => $donation->id,
                'content' => sprintf(esc_html__('Donation failed. Reason: %s', 'ADDON_TEXTDOMAIN'), $errorMessage),
            ]);

            throw new PaymentGatewayException($errorMessage);
        }
    }

    /**
     * @unreleased
     */
    public function refundDonation(Donation $donation)
    {
        // TODO: Implement refundDonation() method.
    }

    /**
     * @unreleased
     */
    public function getPaymentParameters(Donation $donation, $gatewayData): array
    {
        return [
            'gatewayPaymentId' => $donation->gatewayTransactionId,
            'amount' => [
                'value' => $donation->amount->formatToDecimal(),
                'currency' => $donation->amount->getCurrency()->getCode(),
            ],
            'description' => $donation->formTitle,
            'returnUrl' => $this->getPaymentsReturnURL($donation, $gatewayData),
            'cancelUrl' => $this->getPaymentsCancelURL($donation, $gatewayData),
            'webhookUrl' => $this->getPaymentsWebhookUrl($donation),
        ];
    }

    /**
     * @param Donation $donation
     *
     * @return OffSiteGatewayPayment
     */
    protected function createGiveAddonOffSiteGatewayPaymentApi(Donation $donation): OffSiteGatewayPayment
    {
        /**
         * We are mocking an external API call return and converting it to an OffSite Gateway Payment object.
         */
        return OffSiteGatewayPayment::fromArray([
            'gatewayPaymentId' => 'off-site-sample-gateway-payment-id-' . rand(),
            'merchantPaymentId' => $donation->id,
        ]);
    }

    /**
     * @unreleased
     *
     * @throws Exception
     */
    protected function handleSuccessPaymentReturn(array $queryParams): RedirectResponse
    {
        $donation = Donation::find((int)$queryParams['donation-id']);

        /**
         * Verify the status before changing it because maybe the "OffSiteGatewayWebhookRequestHandler" class already
         * received a webhook notification sent from the ""OffSiteCheckoutPageSimulation" and has changed it before.
         */
        if ( ! $donation->status->isComplete()) {
            $donation->status = DonationStatus::COMPLETE();
            $donation->save();
        }

        return new RedirectResponse(esc_url_raw($queryParams['givewp-return-url']));
    }

    /**
     * @unreleased
     *
     * @throws Exception
     */
    protected function handleCanceledPaymentReturn(array $queryParams): RedirectResponse
    {
        $donation = Donation::find((int)$queryParams['donation-id']);

        $donation->status = DonationStatus::CANCELLED();
        $donation->save();

        return new RedirectResponse(esc_url_raw($queryParams['givewp-return-url']));
    }

    /**
     * @unreleased
     */
    protected function webhookNotificationsListener()
    {
        try {
            $webhookNotification = OffSiteGatewayWebhookNotification::fromRequest($_REQUEST);
            give(OffSiteGatewaysWebhookNotificationHandler::class)($webhookNotification);
        } catch (Exception $e) {
            esc_html_e('Off-site gateway Webhook Notification failed.', 'ADDON_TEXTDOMAIN');
            PaymentGatewayLog::error(
                'Off-site gateway Webhook Notification failed. Error: ' . $e->getMessage()
            );
        }

        exit();
    }

    /**
     * @unreleased
     */
    private function getPaymentsReturnURL(Donation $donation, $gatewayData): string
    {
        return urlencode(
            esc_url_raw(
                $this->generateSecureGatewayRouteUrl(
                    'handleSuccessPaymentReturn',
                    $donation->id,
                    [
                        'donation-id' => $donation->id,
                        'givewp-return-url' => $gatewayData['successUrl'],
                    ]
                )
            )
        );
    }

    /**
     * @unreleased
     */
    private function getPaymentsCancelURL(Donation $donation, $gatewayData): string
    {
        return urlencode(
            esc_url_raw(
                $this->generateSecureGatewayRouteUrl(
                    'handleCanceledPaymentReturn',
                    $donation->id,
                    [
                        'donation-id' => $donation->id,
                        'givewp-return-url' => $gatewayData['cancelUrl'],
                    ]
                )
            )
        );
    }

    /**
     * @unreleased
     */
    private function getPaymentsWebhookUrl(Donation $donation): string
    {
        return urlencode(
            esc_url_raw(
                $this->generateGatewayRouteUrl(
                    $this->getWebhookNotificationsListener(),
                    [
                        'notification_type' => 'payments',
                        'payment_id' => $donation->id,
                    ]
                )
            )
        );
    }
}
