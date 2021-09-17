<?php

namespace CoinZoom;

use \CoinZoom\PublicApi\{
    Currency
};

use \CoinZoom\PartnerApi\{
    PaymentGateway as Gateway
};

use \CoinZoom\PartnerApi\Dto\Notes;

use \CoinZoom\PartnerApi\Dto\PaymentGateway\{
    Payment as PaymentDto,
    Response\Payment as PaymentResponse
};

class PaymentGateway
{
    private $Payment, $Currency, $Notes, $price, $invoice;
    /**
     *	@description	
     *	@param	$price [float] Total price for the order
     *  @param  $invoice [mixed] The external invoice number for the order
     */
    public function __construct(float $price, $invoice)
    {
        $this->price = $price;
        $this->invoice = $invoice;
        $this->reset();
    }
    /**
     *	@description	Resets the currency and gateway object so multiple calls can be used in same object(s)
     */
    public function reset(): PaymentGateway
    {
        $this->Currency = new Currency();
        $this->Payment = new Gateway($this->Currency);
        # Allow chaining
        return $this;
    }
    /**
     *	@description	Create the payment
     */
    public function create(Notes $Notes = null): PaymentResponse
    {
        if (!empty($Notes))
            $this->Notes = $Notes;
        # Create the cz payment object
        $fetch = $this->Payment->create($this->price, new PaymentDto([
            'description' => $this->Notes->note,
            'invoiceNumber' => $this->invoice
        ]));
        # Return the response
        return $fetch;
    }
    /**
     *	@description	        Set the webhook for the system to return back status
     *	@param  $url [string]   This is the url
     */
    public function setWebhook(string $url): PaymentGateway
    {
        $this->Payment->{__FUNCTION__}($url);
        # Allow chaining
        return $this;
    }
    /**
     *	@description	Set the note on the order
     *	@param	$note [string] Description for the order (255 characters max)
     */
    public function setNote(string $note): PaymentGateway
    {
        $this->Notes  =   new Notes(['note' => $note]);
        # Allow for chaining
        return $this;
    }
    /**
     *	@description	Sets the account receivable currencies allowed
     *	@param	$currencies [array] An array of payment types the account will accept
     */
    public function setReceivables(array $currencies = ['USD']): PaymentGateway
    {
        foreach ($currencies as $currency) {
            $this->Payment->setPaymentOption($currency);
        }
        # Allow chaining
        return $this;
    }
}
