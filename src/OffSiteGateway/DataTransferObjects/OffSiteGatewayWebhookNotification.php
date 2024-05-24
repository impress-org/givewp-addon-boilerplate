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

    public static function fromArray(array $data): OffSiteGatewayWebhookNotification
    {
        $self = new self();

        $self->notificationType = $data['notification_type'] ?? '';

        return $self;
    }
}
