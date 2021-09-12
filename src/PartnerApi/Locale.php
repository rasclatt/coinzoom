<?php
namespace CoinZoom\PartnerApi;

class Locale extends \CoinZoom\Contents
{
    /**
     *	@description	
     *	@param	
     */
    public function __construct()
    {
        parent::__construct('countries/');
    }
    /**
     *	@description	
     *	@param	
     */
    public function getCountries()
    {
        return $this->get();
    }
    /**
     *	@description	
     *	@param	
     */
    public function getRegions(string $abbr3)
    {
        $abbr3 = strtoupper($abbr3);
        return $this->setService("{$abbr3}/states")->get();
    }
}