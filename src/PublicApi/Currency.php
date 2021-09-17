<?php

namespace CoinZoom\PublicApi;

use \CoinZoom\PartnerApi\Market;

class Currency extends \CoinZoom\Contents
{
    /**
     *	@description	
     *	@param	
     */
    public function __construct()
    {
        parent::__construct('currencies/');
    }
    /**
     *	@description	
     *	@param	
     */
    public function getPrices(Market $Market)
    {
        $z  =   [];
        foreach ($Market->getTicker() as $sym => $row) {
            if (preg_match('/_usd$/i', $sym) && !empty($row['last_price'])) {
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
        foreach ($this->getPrices(new Market()) as $k => $v) {
            if ($v != null)
                $z[$k] = (float) $price / (float) $v;
        }
        $z['USD']   =   $price;
        ksort($z);
        return $z;
    }
}
