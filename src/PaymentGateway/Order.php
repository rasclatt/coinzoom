<?php

namespace CoinZoom\PaymentGateway;

use \CoinZoom\PartnerApi\{
    PaymentGateway\Order as OrderService
};

use \CoinZoom\PartnerApi\Dto\PaymentGateway\{
    Status,
    Response\Status as StatusResponse
};

class Order
{
    private $Order, $id;
    /**
     *	@param	$id [string] The payment id from CZ
     */
    public function __construct(string $id)
    {
        $this->id = $id;
        $this->Order = new OrderService(new Status(['id' => $this->id]));
    }
    /**
     *	@description	Fetch the order summary
     */
    public function getSummary(): StatusResponse
    {
        return $this->Order->{__FUNCTION__}();
    }
}
