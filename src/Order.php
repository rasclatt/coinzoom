<?php

namespace CoinZoom;

use \CoinZoom\Currency;
use \CoinZoom\Dto\Order\{
    CreateRequest as OrderCreateRequest,
    CreateRequestWithUuid as OrderCreateRequestWithUuid
};
use \CoinZoom\PartnerApi\Dto\PaymentGateway\Create as PaymentGatewayDto;

class Order extends Contents
{
    private $_price, $_distid, $_invoice, $_webhook, $paymentOptions, $_referralToken, $Create;
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
        $this->_price = $this->Create->price;
        $this->_distid = $this->Create->distid;
        $this->_invoice = $this->Create->invoice;
        $this->_referralToken = ($this->Create->referralToken) ?? null;

        $currencies =   $Currency->toUsd($this->_price);
        $allowed    =   [];
        foreach ($this->paymentOptions as $curr) {
            $allowed[]  =   [
                'currency' => $curr,
                'price' => $currencies[$curr]
            ];
        }
        # Set the data
        $data = [
            'description' => "Create order for invoice #{$this->_invoice} for user {$this->_distid}",
            'invoiceNumber' => $this->_invoice,
            'returnUrl' => (!empty($this->_webhook)) ? $this->_webhook : null,
            'expiryMinutes' => $this->expiration,
            'prices' => $allowed
        ];
        # If there is an order to create with UUID use different Dto
        if (!empty($this->_referralToken)) {
            # Set the uuid
            $data['referralToken'] = $this->_referralToken;
            $body = new OrderCreateRequestWithUuid($data);
        } else {
            $body = new OrderCreateRequest($data);
        }

        $compile = $this->setService(__FUNCTION__)->addBody($body->toArray());
        $response = $compile->post();

        if (empty($response)) {
            $h = $compile->getResponseHeaders();
            $e = str_replace('HTTP/1.1', '', array_shift($h));
            throw new \Exception($e, preg_replace('/[^\d]/', '', $e));
        }

        return $response;
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
