<?php
namespace CoinZoom\PartnerApi\Dto\PaymentGateway;

class CreateWithUuidRequest extends Payment
{
    public $referralToken = '';
}