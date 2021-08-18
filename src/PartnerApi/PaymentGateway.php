<?php
namespace CoinZoom\PartnerApi;

use \CoinZoom\ {
    Contents,
    PublicApi\Currency
};

use \CoinZoom\PartnerApi\Dto\PaymentGateway\ {
    Payment,
    Status,
    Response\Payment as PaymentResponse
};

class PaymentGateway extends Contents
{
    private $_webhook, $paymentOptions, $Currency;

    public $expiration = 15;
    /**
     *	@description	Set the order request data
     */
    public function __construct(Currency $Currency)
    {
        parent::__construct('payment/');

        $this->Currency = $Currency;
    }
    /**
     *	@description	Create the new order request
     */
    public function create(float $price, Payment $Create): PaymentResponse
    {
        # Generate all the account currencies (accepted) with converted prices
        $currencies =   $this->Currency->toUsd($price);
        # Set the usd default
        if(empty($this->paymentOptions))
            $this->setPaymentOption('usd');
        # Loop through all the payment types and store
        foreach($this->paymentOptions as $curr) {
            $Create->prices[] = [
                'currency' => $curr,
                'price' => $currencies[$curr]
            ];
        }
        # Set the webhook
        $Create->returnUrl = (!empty($this->_webhook))? $this->_webhook : null;
        # Set the price expiration
        $Create->expiryMinutes = $this->expiration;
        # Generate the order
        return new PaymentResponse($this->setService(__FUNCTION__)->addBody($Create->toArray())->post());
    }
    /**
     *	@description	Get the status of the order
     *	@param	$Status [object] Dto for returning the order id
     */
    public function getStatus(Status $Status)
    {
        return $this->setService("get/{$Status->id}")->get();
    }
    /**
     *	@description	Sets the cz response webook destination
     *	@param	$url [string]   The webhook url that cz will return a response to
     */
    public function setWebhook(string $url): PaymentGateway
    {
        $this->_webhook =   $url;
        return $this;
    }
    /**
     *	@description	
     *	@param	
     */
    public function setPaymentOption(string $currency): PaymentGateway
    {
        $this->paymentOptions[] =   strtoupper($currency);
        return $this;
    }
}