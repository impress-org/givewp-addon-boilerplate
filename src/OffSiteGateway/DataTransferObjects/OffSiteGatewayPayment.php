<?php

namespace GiveAddon\OffSiteGateway\DataTransferObjects;

class OffSiteGatewayPayment
{

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $checkoutUrl;

    public static function fromArray(array $data): OffSiteGatewayPayment
    {
        $self = new self();

        $self->id = $data['id'] ?? '';
        $self->checkoutUrl = $data['checkoutUrl'] ?? '';

        return $self;
    }
}
