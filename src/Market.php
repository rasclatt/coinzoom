<?php

namespace CoinZoom;

class Market extends Contents
{
    /**
     *	@description	
     *	@param	
     */
    public function __construct()
    {
        parent::__construct('marketwatch');
    }
    /**
     *	@description	
     *	@param	
     */
    public function getTicker()
    {
        return $this->setService('/ticker')->get();
    }
}
