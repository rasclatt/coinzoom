<?php
namespace CoinZoom\PartnerApi\PaymentGateway;

use \CoinZoom\PartnerApi\Dto\PaymentGateway\ {
    Status,
    Response\Status as StatusResponse
};

class Order extends \CoinZoom\Contents
{
    private $id;
    /**
     *	@description	
     *	@param	
     */
    public function __construct(Status $Status)
    {
        parent::__construct('payment/');
        $this->id = $Status->id;
    }
    /**
     *	@description	
     *	@param	
     */
    public function getSummary()
    {
        return new StatusResponse($this->setService("get/{$this->id}")->get());
    }
}