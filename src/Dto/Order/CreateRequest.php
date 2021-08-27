<?php
namespace CoinZoom\Dto\Order;

class CreateRequest extends \CoinZoom\Dto
{
    public $description = '';
    public $invoiceNumber = '';
    public $returnUrl = '';
    public $expiryMinutes = 30;
    public $prices = [];
    /**
     *	@description	
        *	@param	
        */
    protected function prices()
    {
        if(!empty($this->prices)) {
            foreach($this->prices as $k => $arr) {
                $this->prices[$k] = new CreateRequestPrices($arr);
            }
        }
    }
}

class CreateRequestPrices extends \CoinZoom\Dto
{
    public $currency = 'USD';
    public $price = 0;
}