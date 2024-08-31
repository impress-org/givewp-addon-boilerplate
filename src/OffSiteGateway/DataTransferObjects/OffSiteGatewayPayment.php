<?php

namespace GiveAddon\OffSiteGateway\DataTransferObjects;

class OffSiteGatewayPayment
{
    /**
     * @var string
     */
    public $id;

    public static function fromArray(array $data): OffSiteGatewayPayment
    {
        $self = new self();

        $self->id = $data['id'] ?? '';

        return $self;
    }
}
