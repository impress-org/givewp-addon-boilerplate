<?php

namespace GiveAddon\OffSiteGateway\Gateway;

use Exception;
use Give\Donations\Models\Donation;
use Give\Donations\Models\DonationNote;
use Give\Donations\ValueObjects\DonationStatus;
use Give\Framework\Http\Response\Types\RedirectResponse;
use Give\Framework\PaymentGateways\Commands\RedirectOffsite;
use Give\Framework\PaymentGateways\Contracts\WebhookNotificationsListener;
use Give\Framework\PaymentGateways\Exceptions\PaymentGatewayException;
use Give\Framework\PaymentGateways\Log\PaymentGatewayLog;
use Give\Framework\PaymentGateways\PaymentGateway;
use Give\Framework\Support\Facades\Scripts\ScriptAsset;
use GiveAddon\OffSiteGateway\DataTransferObjects\OffSiteGatewayPayment;
use GiveAddon\OffSiteGateway\DataTransferObjects\OffSiteGatewayWebhookNotification;

/**
 * @unreleased Use new WebhookNotificationsListener interface
 * @since 1.0.0
 */
class OffSiteGateway extends PaymentGateway implements WebhookNotificationsListener
{
    /**
     * @since 1.0.0
     */
    public $secureRouteMethods = [
        'handleSuccessPaymentReturn',
        'handleCanceledPaymentReturn',
    ];

    /**
     * @since 1.0.0
     */
    public static function id(): string
    {
        return 'ADDON_ID-off-site-gateway';
    }

    /**
     * @since 1.0.0
     */
    public function getId(): string
    {
        return self::id();
    }

    /**
     * @since 1.0.0
     */
    public function getName(): string
    {
        return __('ADDON_NAME - Off-Site Gateway', 'ADDON_TEXTDOMAIN');
    }

    /**
     * @since 1.0.0
     */
    public function getPaymentMethodLabel(): string
    {
        return __('ADDON_NAME - Off-Site Gateway', 'ADDON_TEXTDOMAIN');
    }

    /**
     * Add support to forms built with Option-Based Form Editor
     *
     * @since 1.0.0
     */
    public function getLegacyFormFieldMarkup(int $formId, array $args): string
    {
        return sprintf(
            '<div style="text-align: center;"><img src="%s" alt="OffSite Gateway Logo" /><p>%s</p></div>',
            ADDON_CONSTANT_URL . 'src/OffSiteGateway/Gateway/resources/logo.svg',
            __('You will be redirected to an Off-Site Gateway simulation checkout page where will be possible to complete the payment and trigger webhook notifications for test purposes.',
                'ADDON_TEXTDOMAIN')
        );
    }

    /**
     * Add support to forms built with Visual Form Builder
     *
     * @since 1.0.0
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
     * @since 1.0.0
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
     * @since 1.0.0
     *
     * @throws Exception
     */
    public function refundDonation(Donation $donation)
    {
        try {
            $this->refundGiveAddonOffSiteGatewayPaymentApi($donation);
            $donation->status = DonationStatus::REFUNDED();
            $donation->save();

            DonationNote::create([
                'donationId' => $donation->id,
                'content' => sprintf(
                    __('Donation refunded in %s for transaction ID: %s', 'ADDON_TEXTDOMAIN'),
                    $this->getName(),
                    $donation->gatewayTransactionId
                ),
            ]);
        } catch (Exception $e) {
            DonationNote::create([
                'donationId' => $donation->id,
                'content' => sprintf(
                    __(
                        'Error! Donation %s was NOT refunded. Find more details on the error in the logs at Donations > Tools > Logs. To refund the donation, use the %s dashboard.',
                        'ADDON_TEXTDOMAIN'
                    ),
                    $donation->id,
                    $this->getName()
                ),
            ]);

            throw new PaymentGatewayException($e->getMessage());
        }
    }

    /**
     * @since 1.0.0
     */
    public function getPaymentParameters(Donation $donation, $gatewayData): array
    {
        return [
            'gatewayPaymentId' => $donation->gatewayTransactionId,
            'merchantPaymentId' => $donation->id,
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
     * @throws Exception
     */
    protected function createGiveAddonOffSiteGatewayPaymentApi(Donation $donation): OffSiteGatewayPayment
    {
        try {
            /**
             * We are mocking an external API call return and converting it to an OffSite Gateway Payment object.
             */
            return OffSiteGatewayPayment::fromArray([
                'gatewayPaymentId' => 'off-site-sample-gateway-payment-id-' . rand(),
                'merchantPaymentId' => $donation->id,
            ]);
        } catch (Exception $e) {
            throw new PaymentGatewayException(
                sprintf(
                    __('[%s] Payment not created. API Error: %s', 'ADDON_TEXTDOMAIN'),
                    $this->getName(),
                    $e->getCode() . ' - ' . $e->getMessage()
                )
            );
        }
    }

    /**
     * @param Donation $donation
     *
     * @return bool
     * @throws Exception
     */
    protected function refundGiveAddonOffSiteGatewayPaymentApi(Donation $donation): bool
    {
        try {
            /**
             * We are mocking an external API call return which is always a true boolean.
             */
            return true;
        } catch (Exception $e) {
            throw new PaymentGatewayException(
                sprintf(
                    __('[%s] Refund failed for donation %s. The refund can be initiated on the gateway side, or try again here. API Error: %s',
                        'ADDON_TEXTDOMAIN'),
                    $this->getName(),
                    $donation->id,
                    $e->getCode() . ' - ' . $e->getMessage()
                )
            );
        }
    }

    /**
     * @since 1.0.0
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
     * @since 1.0.0
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
     * @since 1.0.0
     */
    public function webhookNotificationsListener()
    {
        try {
            $webhookNotification = OffSiteGatewayWebhookNotification::fromRequest(give_clean($_REQUEST));
            give(OffSiteGatewayWebhookNotificationHandler::class)($webhookNotification);
        } catch (Exception $e) {
            esc_html_e('ADDON_NAME - Webhook Notification failed.', 'ADDON_TEXTDOMAIN');
            PaymentGatewayLog::error(
                'ADDON_NAME - Webhook Notification failed. Error: ' . $e->getMessage()
            );
        }

        exit();
    }

    /**
     * @since 1.0.0
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
     * @since 1.0.0
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
     * @since 1.0.0
     *
     * @throws Exception
     */
    private function getPaymentsWebhookUrl(Donation $donation): string
    {
        return urlencode(
            esc_url_raw(
                $this->webhook->getNotificationUrl([
                    'notification_type' => 'payments',
                    'payment_id' => $donation->id,
                ])            
            )
        );
    }
}
