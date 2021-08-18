<?php
namespace CoinZoom\Dto\Order;

class Status extends Create
{
    public $id;
    /**
     *	@description	
     *	@param	
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }
}