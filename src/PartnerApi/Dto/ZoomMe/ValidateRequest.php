<?php
namespace CoinZoom\PartnerApi\Dto\ZoomMe;

class ValidateRequest extends \SmartDto\Dto
{
    public $zoomMeHandle = '';
    /**
     *	@description	
     *	@param	
     */
    protected function beforeConstruct($array)
    {
        $array['zoomMeHandle'] = trim(str_ireplace('ZoomMe:','', 'ZoomMe:'.($array['zoomMeHandle'])?? '');
        return $array;
    }
}