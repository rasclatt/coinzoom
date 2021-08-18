<?php
namespace CoinZoom\PublicApi\Dto\Order;

class PlaceLimit extends \CoinZoom\PublicApi\Dto
{
    public $symbol = '';
    public $orderType = 'LIMIT';
    public $orderSide = 'BUY';
    public $quantity = 0;
    public $price = 0;
    public $payFeesWithZoomToken = true;
}