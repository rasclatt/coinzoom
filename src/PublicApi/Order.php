<?php
namespace CoinZoom\PublicApi;

use \CoinZoom\PublicApi\Dto\Order\ {
    PlaceLimit,
    PlaceMarket,
    StopLimit,
    Cancel,
    GetOpen
};

class Order extends \CoinZoom\Contents
{
    /**
     *	@description	
     *	@param	
     */
    public function __construct()
    {
        parent::__construct('orders/');
    }
    /**
     *	@description	
     *	@param	
     */
    public function placeLimit(PlaceLimit $Dto)
    {
        return $this->fetchPost('new', $Dto);
    }
    /**
     *	@description	
     *	@param	
     */
    public function placeMarket(PlaceMarket $Dto)
    {
        return $this->fetchPost('new', $Dto);
    }
    /**
     *	@description	
     *	@param	
     */
    public function stopLimit(StopLimit $Dto)
    {
        return $this->fetchPost('new', $Dto);
    }
    /**
     *	@description	
     *	@param	
     */
    public function cancel(Cancel $Dto)
    {
        return $this->fetchPost('cancel', $Dto);
    }
    /**
     *	@description	
     *	@param	
     */
    public function getOpen(GetOpen $Dto)
    {
        $Dto->orderStatuses =   ["NEW", "PARTIALLY_FILLED"];
        return $this->fetchPost('list', $Dto);
    }
    /**
     *	@description	
     *	@param	
     */
    public function getHistoric(GetOpen $Dto)
    {
        $Dto->orderStatuses =   ["FILLED", "CANCELLED", "REJECTED"];
        return $this->fetchPost('list', $Dto);
    }
    /**
     *	@description	
     *	@param	
     */
    public function fetchPost($service, $Dto)
    {
        return $this->setService("{$service}/")->addBody($Dto->toArray())->post();
    }
}