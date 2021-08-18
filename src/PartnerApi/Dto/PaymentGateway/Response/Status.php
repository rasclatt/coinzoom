<?php
namespace CoinZoom\PartnerApi\Dto\PaymentGateway\Response;

class Status extends \CoinZoom\PublicApi\Dto
{
    public $paymentId = '';
    public $created = '';
    public $status = '';
    public $invoiceNumber = '';
    public $timePaid = '';
    public $paidCurrency = ''; 
    public $paidPrice =  '';
    public $recurringStatus = ''; 
    public $recurringUnit =  '';
    public $recurringFrequency = ''; 
    public $recurringPaymentId =  '';
    public $timeCancelled = '';
    public $zoomMeHandle = '';
}