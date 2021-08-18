<?php
namespace CoinZoom\PartnerApi\Dto\PaymentGateway;

class Payment extends \CoinZoom\PublicApi\Dto
{
    public $description = '';
    public $invoiceNumber = '';
    public $returnUrl = '';
    public $expiryMinutes = 15;
    public $prices = [];
}