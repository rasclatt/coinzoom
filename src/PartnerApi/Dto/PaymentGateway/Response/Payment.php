<?php
namespace CoinZoom\PartnerApi\Dto\PaymentGateway\Response;

use CoinZoom\PartnerApi\Dto\PaymentGateway\Response\Prices;

class Payment extends \CoinZoom\PublicApi\Dto
{
    public $id = '';
    public $prices = [];

    public function prices()
    {
        if(empty($this->prices))
            return (object) $this->prices;

        foreach($this->prices as $k => $row) {
            $this->prices[$k] = new Prices($row);
        }
        $this->prices = (object) $this->prices;
    }
}