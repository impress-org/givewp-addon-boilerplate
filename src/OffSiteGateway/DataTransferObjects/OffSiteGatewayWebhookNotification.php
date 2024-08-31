<?php

namespace GiveAddon\OffSiteGateway\DataTransferObjects;

/**
 * @unreleased
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
     * @unreleased
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
