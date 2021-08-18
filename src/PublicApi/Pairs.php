<?php
namespace CoinZoom\PublicApi;

class Pairs extends \CoinZoom\Contents
{
    /**
     *	@description	
     *	@param	
     */
    public function __construct()
    {
        parent::__construct('instruments/');
    }
}