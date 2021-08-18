<?php
namespace CoinZoom\PartnerApi;

class Market extends \CoinZoom\Contents
{
    /**
     *	@description	
     *	@param	
     */
    public function __construct()
    {
        parent::__construct('marketwatch/');
    }
    /**
     *	@description	
     *	@param	
     */
    public function getTicker()
    {
        return $this->setService('ticker/')->get();
    }
}