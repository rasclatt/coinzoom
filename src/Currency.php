<?php
namespace CoinZoom;

use \CoinZoom\Market;

class Currency extends Contents
{
    private $Market;
    /**
     *	@description	
     *	@param	
     */
    public function __construct(Market $Market)
    {
        $this->Market   =   $Market;
        parent::__construct('currencies');
    }
    /**
     *	@description	
     *	@param	
     */
    public function get()
    {
        return parent::get();
    }
    /**
     *	@description	
     *	@param	
     */
    public function getPrices()
    {
        $z  =   [];
        foreach($this->Market->getTicker() as $sym => $row) {
            if(preg_match('/_usd$/i', $sym) && !empty($row['last_price'])) {
                $z[str_ireplace('_usd', '', $sym)]    =   $row['last_price'];
            }
        }

        return $z;
    }
    /**
     *	@description	
     *	@param	
     */
    public function toUsd(float $price)
    {
        $z = [];
        foreach($this->getPrices() as $k => $v) {
            if($v != null)
                $z[$k] = (float) $price / (float) $v;
        }
        $z['USD']   =   $price;
        ksort($z);
        return $z;
    }
}