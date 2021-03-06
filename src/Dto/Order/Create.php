<?php
namespace CoinZoom\Dto\Order;

class Create extends \CoinZoom\Dto
{
    public $price = 0;
    public $distid = 0;
    public $invoice = 0;
    public $id = 0;

        /**
         *	@description	
         *	@param	
         */
        public function __construct(array $array = null)
        {
            if(empty($array))
                return $this;

            foreach($array as $k => $v) {
                if(isset($this->{$k}))
                    $this->{$k} =   $v;
            }
        }
}