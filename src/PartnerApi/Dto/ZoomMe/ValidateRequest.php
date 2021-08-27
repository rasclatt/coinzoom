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
        if(!empty($array['handle']))
            $handle = $array['handle'];
        else
            $handle = ($array['zoomMeHandle'])?? '';
                
        $array['zoomMeHandle'] = 'ZoomMe:'.trim(str_ireplace('ZoomMe:','', ('ZoomMe:'.$handle)));
        return $array;
    }
}