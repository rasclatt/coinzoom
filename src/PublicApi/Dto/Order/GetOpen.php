<?php
namespace CoinZoom\PublicApi\Dto\Order;

class GetOpen extends \CoinZoom\PublicApi\Dto
{
    /**
	 * possible $orderStatuses = ['NEW', 'PARTIALLY_FILLED', 'FILLED', 'CANCELLED', 'REJECTED'];
	 **/
    public $symbol = null;
	public $orderSide = null;
	public $orderStatuses = null;
	public $size = 100;
	public $bookmarkOrderId = null;
}