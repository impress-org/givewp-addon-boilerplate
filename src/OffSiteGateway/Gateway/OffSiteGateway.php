<?php

namespace GiveAddon\OffSiteGateway\Gateway;

use Exception;
use Give\Donations\Models\Donation;
use Give\Donations\Models\DonationNote;
use Give\Donations\ValueObjects\DonationStatus;
use Give\Framework\Http\Response\Types\RedirectResponse;
use Give\Framework\PaymentGateways\Commands\RedirectOffsite;
use Give\Framework\PaymentGateways\Exceptions\PaymentGatewayException;
use Give\Framework\PaymentGateways\PaymentGateway;
use Give\Framework\Support\Facades\Scripts\ScriptAsset;
use GiveAddon\OffSiteGateway\DataTransferObjects\OffSiteGatewayPayment;

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
            $paymentParameters = $this->getPaymentParameters($donation, $gatewayData);
            $payment = $this->createGiveAddonOffSiteGatewayPayment($donation, $paymentParameters);
            $donation->gatewayTransactionId = $payment->id;
            $donation->save();

            return new RedirectOffsite($payment->checkoutUrl);
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
            'amount' => [
                'value' => $donation->amount->formatToDecimal(),
                'currency' => $donation->amount->getCurrency()->getCode(),
            ],
            //'description' => MollieApi::getPaymentDescription($donation),
            'returnUrl' => $this->getPaymentsReturnURL($donation, $gatewayData),
            'cancelUrl' => $this->getPaymentsCancelURL($donation, $gatewayData),
            'webhookUrl' => $this->getPaymentsWebhookUrl($donation),
        ];
    }

    /**
     * @param Donation $donation
     * @param array    $paymentParameters
     *
     * @return OffSiteGatewayPayment
     */
    protected function createGiveAddonOffSiteGatewayPayment(
        Donation $donation,
        array $paymentParameters
    ): OffSiteGatewayPayment {
        return OffSiteGatewayPayment::fromArray([
            'id' => 'payment-id',
            'checkoutUrl' => 'https://example.com/',
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

        $donation->status = DonationStatus::COMPLETE();
        $donation->save();

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
    private function getPaymentsReturnURL(Donation $donation, $gatewayData): string
    {
        return $this->generateSecureGatewayRouteUrl(
            'handleSuccessPaymentReturn',
            $donation->id,
            [
                'donation-id' => $donation->id,
                'givewp-return-url' => $gatewayData['successUrl'],
            ]
        );
    }

    /**
     * @unreleased
     */
    private function getPaymentsCancelURL(Donation $donation, $gatewayData): string
    {
        return $this->generateSecureGatewayRouteUrl(
            'handleCanceledPaymentReturn',
            $donation->id,
            [
                'donation-id' => $donation->id,
                'givewp-return-url' => $gatewayData['cancelUrl'],
            ]
        );
    }

    /**
     * @unreleased
     */
    private function getPaymentsWebhookUrl(Donation $donation): string
    {
        return $this->generateGatewayRouteUrl(
            $this->getWebhookNotificationsListener(),
            [
                'notification_type' => 'payments',
                'payment_id' => $donation->id,
            ]
        );
    }
}
