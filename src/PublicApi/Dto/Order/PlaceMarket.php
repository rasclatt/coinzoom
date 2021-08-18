<?php
namespace CoinZoom\PublicApi\Dto\Order;

class PlaceMarket extends \CoinZoom\PublicApi\Dto
{
    public $symbol = '';
    public $orderType = 'MARKET';
    public $orderSide = 'BUY';
    public $quantity = 0;
    public $payFeesWithZoomToken = true;
}