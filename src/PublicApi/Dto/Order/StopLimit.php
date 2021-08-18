<?php
namespace CoinZoom\PublicApi\Dto\Order;

class StopLimit extends \CoinZoom\PublicApi\Dto
{
    public $symbol = '';
    public $orderType = "STOP_LIMIT";
    public $orderSide = "BUY";
    public $quantity = 0;
    public $price = 0;
    public $stopPrice = 0;
    public $payFeesWithZoomToken = true;
}