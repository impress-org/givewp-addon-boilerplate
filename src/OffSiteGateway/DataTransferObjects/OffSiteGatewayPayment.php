<?php

namespace GiveAddon\OffSiteGateway\DataTransferObjects;

/**
 * @unreleased
 */
class OffSiteGatewayPayment
{
    /**
     * @var string
     */
    public $merchantPaymentId;

    /**
     * @var string
     */
    public $gatewayPaymentId;

    public static function fromArray(array $data): OffSiteGatewayPayment
    {
        $self = new self();

        $self->gatewayPaymentId = $data['gatewayPaymentId'] ?? '';
        $self->merchantPaymentId = $data['merchantPaymentId'] ?? '';

        return $self;
    }
}
