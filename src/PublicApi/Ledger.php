<?php
namespace CoinZoom\PublicApi;

class Ledger extends \CoinZoom\Contents
{
    /**
     *	@description	
     *	@param	
     */
    public function __construct()
    {
        parent::__construct('ledger/');
    }
    /**
     *	@description	
     *	@param	
     */
    public function get()
    {
        $this->setService('list/');
        return parent::get();
    }
}