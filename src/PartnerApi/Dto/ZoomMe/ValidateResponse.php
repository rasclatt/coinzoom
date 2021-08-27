<?php
namespace CoinZoom\PartnerApi\Dto\ZoomMe;

class ValidateResponse extends \SmartDto\Dto
{
    public $valid = false;
    public $first_name = "";
    public $last_name = "";
    public $kyc_approved = false;
    public $email = false;
    public $identifier = null;
    public $linked_to_another_organisation = false;
    /**
     *	@description	
     *	@param	
     */
    protected function beforeConstruct($array)
    {
        $array = \CoinZoom\Helpers::alterKeys($array);
        $array['valid'] = !empty(array_filter($array));
        return $array;
    }
}