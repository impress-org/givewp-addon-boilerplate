<?php

namespace GiveAddon\OffSiteGateway\Webhooks;

use Give\Framework\Support\Facades\ActionScheduler\AsBackgroundJobs;
use GiveAddon\OffSiteGateway\DataTransferObjects\OffSiteGatewayWebhookNotification;

/**
 * @unreleased
 */
class OffSiteGatewaysWebhookNotificationHandler
{
    /**
     * @unreleased
     */
    public function __invoke(OffSiteGatewayWebhookNotification $webhookNotification)
    {
        /**
         * Allow developers to handle the webhook notification.
         *
         * @unreleased
         *
         * @param OffSiteGatewayWebhookNotification $webhookNotification
         */
        do_action("givewp_off-site_gateway_sample_webhook_notification_handler", $webhookNotification);

        // We will handle recurring donations in a separate submodule sample that will enable Subscription on the Off-site gateway sample.
        if ($this->isRecurringDonation($webhookNotification)) {
            return;
        }

        switch (strtolower($webhookNotification->paymentStatus)) {
            case 'complete':
                AsBackgroundJobs::enqueueAsyncAction(
                    'givewp_off-site_gateway_sample_event_donation_completed',
                    [$webhookNotification->gatewayPaymentId],
                    'ADDON_TEXTDOMAIN'
                );
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
     * @unreleased
     */
    private function isRecurringDonation(OffSiteGatewayWebhookNotification $webhookNotification): bool
    {
        return 'subscription' === $webhookNotification->notificationType;
    }
}
