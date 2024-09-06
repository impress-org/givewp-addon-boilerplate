<?php

namespace GiveAddon\OffSiteGateway\DataTransferObjects;

/**
 * This Data Transfer Object class converts the gateway webhook notification to a local object where we know
 * what properties can be accessed. The fromRequest() method is where the conversion from the gateway webhook
 * notification to an object of this class is made. You should edit this method according to the gateway you
 * are integrating since the webhook notification attributes probably should differ.
 *
 * @since 1.0.0
 */
class OffSiteGatewayWebhookNotification
{
    /**
     * @var string
     */
    public $gatewayNotificationType;

    /**
     * @var string
     */
    public $gatewayPaymentStatus;

    /**
     * @var string
     */
    public $gatewayPaymentId;

    /**
     * @var string
     */
    public $merchantPaymentId;

    /**
     * @since 1.0.0
     */
    public static function fromRequest(array $request): OffSiteGatewayWebhookNotification
    {
        $self = new self();

        $self->gatewayNotificationType = $request['notification_type'] ?? '';
        $self->gatewayPaymentStatus = $request['payment_status'] ?? '';
        $self->gatewayPaymentId = $request['payment_id'] ?? '';
        $self->merchantPaymentId = $request['merchant_payment_id'] ?? '';

        return $self;
    }
}
