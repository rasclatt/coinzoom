<?php
namespace CoinZoom;

use \CoinZoom\Currency;
use \CoinZoom\PartnerApi\Dto\PaymentGateway\Create as PaymentGatewayDto;

class Order extends Contents
{
    private $_price, $_distid, $_invoice, $_webhook, $paymentOptions, $Create;
    public $expiration = 15;
    /**
     *	@description	Set the order request data
     */
    public function __construct(Dto\Order\Create $Create)
    {
        $this->Create   =   $Create;
        parent::__construct('payment/');
    }
    /**
     *	@description	
     *	@param	
     */
    public function setWebhook(string $url)
    {
        $this->_webhook =   $url;
        return $this;
    }
    /**
     *	@description	
     *	@param	
     */
    public function setPaymentOption(string $currency)
    {
        $this->paymentOptions[] =   strtoupper($currency);
        return $this;
    }
    /**
     *	@description	Create the new order request
     */
    public function create(Currency $Currency)
    {
        $this->_price   =   $this->Create->price;
        $this->_distid  =   $this->Create->distid;
        $this->_invoice =   $this->Create->invoice;
        
        $currencies =   $Currency->toUsd($this->_price);
        $allowed    =   [];
        foreach($this->paymentOptions as $curr) {
            $allowed[]  =   [
                'currency' => $curr,
                'price' => $currencies[$curr]
            ];
        }
        $send = $this->setService(__FUNCTION__)
            ->addBody((new PaymentGatewayDto([
                'description' => "Create order for invoice #{$this->_invoice} for user {$this->_distid}",
                'invoiceNumber' => $this->_invoice,
                'returnUrl' => (!empty($this->_webhook))? $this->_webhook : null,
                'expiryMinutes' => $this->expiration,
                'prices' => $allowed
            ]))->toArray());
            
        $data = $send->post();
        
        return $data;
    }
    /**
     *	@description	
     *	@param	
     */
    public function getStatus()
    {
        return $this->setService("get/{$this->Create->id}")->get();
    }
}