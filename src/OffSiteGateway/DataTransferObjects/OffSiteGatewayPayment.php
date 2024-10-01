<?php

namespace GiveAddon\OffSiteGateway\DataTransferObjects;

/**
 * This Data Transfer Object class converts the gateway API response (when creating a new payment) to a local
 * object where we know what properties can be accessed. The fromArray() method is where the conversion from
 * the gateway API response to an object of this class is made. You should edit this method according to the
 * gateway you are integrating since the API response probably should differ.
 *
 * @since 1.0.0
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
