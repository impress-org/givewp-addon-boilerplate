<?php

namespace GiveAddon\OffSiteGateway\Webhooks;

use Give\Framework\Support\Facades\ActionScheduler\AsBackgroundJobs;
use GiveAddon\OffSiteGateway\DataTransferObjects\OffSiteGatewayWebhookNotification;
use GiveAddon\OffSiteGateway\Gateway\OffSiteGateway;

/**
 * @since 1.0.0
 */
class OffSiteGatewaysWebhookNotificationHandler
{
    /**
     * @since 1.0.0
     */
    public function __invoke(OffSiteGatewayWebhookNotification $webhookNotification)
    {
        /**
         * Allow developers to handle the webhook notification.
         *
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
                AsBackgroundJobs::enqueueAsyncAction(
                    'givewp_' . OffSiteGateway::id() . '_event_donation_completed',
                    [$webhookNotification->gatewayPaymentId],
                    'ADDON_TEXTDOMAIN'
                );

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
                // Handle failed transactions here...
                break;
            case 'cancelled':
                // Handle cancelled transactions here...
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
        return 'subscription' === $webhookNotification->gatewayNotificationType;
    }
}
