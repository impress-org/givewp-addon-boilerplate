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
    public $notificationType;

    /**
     * @var string
     */
    public $paymentStatus;

    /**
     * @var string
     */
    public $merchantPaymentId;

    /**
     * @var string
     */
    public $gatewayPaymentId;

    public static function fromRequest(array $request): OffSiteGatewayWebhookNotification
    {
        $self = new self();

        $self->notificationType = $request['notification_type'] ?? '';

        return $self;
    }
}
