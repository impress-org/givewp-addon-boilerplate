<?php

namespace GiveAddon\OffSiteGateway\Gateway;

use Give\PaymentGateways\Gateways\TestGateway\TestGateway;
use GiveAddon\OffSiteGateway\DataTransferObjects\OffSiteGatewayWebhookNotification;

/**
 * @since 1.0.0
 */
class OffSiteGatewayWebhookNotificationHandler
{
    /**
     * @since 1.0.0
     */
    public function __invoke(OffSiteGatewayWebhookNotification $webhookNotification)
    {
        /**
         * Allow developers to handle the webhook notification.
         *
         * @unreleased Use new webhook events API instead of the old one.
         * @since 1.0.0
         *
         * @param OffSiteGatewayWebhookNotification $webhookNotification
         */
        do_action('givewp_' . OffSiteGateway::id() . '_webhook_notification_handler', $webhookNotification);

        // We will handle recurring donations in a separate submodule sample that will enable Subscription on the Off-site gateway sample.
        if ($this->isRecurringDonation($webhookNotification)) {
            return;
        }

        switch (strtolower($webhookNotification->gatewayPaymentStatus)) {
            case 'complete':
                // Handling completed transactions...
                OffSiteGateway::webhook()->events->donationCompleted($webhookNotification->gatewayPaymentId);

                /**
                 * The block below is not necessary for real-world integrations;
                 * We are adding it here just for educational purposes.
                 */
                $asyncJobUrl = admin_url('tools.php?page=action-scheduler&s=' . $webhookNotification->gatewayPaymentId);
                ?>
                <style>
                    .container {
                        font-family: "Open Sans", Helvetica, Arial, sans-serif;
                        max-width: 800px;
                        margin: 60px auto;
                    }

                    a {
                        font-weight: bold;
                    }
                </style>
                <div class="container">
                    <h1>Webhook Notification Handler</h1>
                    <p>
                        ✅ We schedule an async job in the server background to change the donation status to "complete"
                        as
                        soon as possible. This approach prevents overloading the server as the webhook notification will
                        be handled only when the server has enough processing power available. You can check the
                        background job status at the following link:
                    </p>
                    <a href="<?php
                    echo $asyncJobUrl ?>"> <?php
                        echo $asyncJobUrl ?></a>
                </div>
                <?php
                break;
            case 'failed':
                // Handling failed transactions...
                OffSiteGateway::webhook()->events->donationFailed($webhookNotification->gatewayPaymentId);
                break;
            case 'cancelled':
                // Handling cancelled transactions...
                OffSiteGateway::webhook()->events->donationCancelled($webhookNotification->gatewayPaymentId);
                break;
            case 'refunded':
                // Handling refunded transactions...
                OffSiteGateway::webhook()->events->donationRefunded($webhookNotification->gatewayPaymentId);
                break;
            default:
                break;
        }
    }

    /**
     * @since 1.0.0
     */
    private function isRecurringDonation(OffSiteGatewayWebhookNotification $webhookNotification): bool
    {
        TestGateway::webhook()->getNotificationUrl();
        return 'subscription' === $webhookNotification->gatewayNotificationType;
    }
}
