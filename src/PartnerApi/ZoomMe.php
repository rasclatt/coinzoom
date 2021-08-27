<?php
namespace CoinZoom\PartnerApi;

use \CoinZoom\PartnerApi\Dto\ZoomMe\ {
    ValidateRequest,
    ValidateResponse
};

class ZoomMe extends \CoinZoom\Contents
{
    private $request;
    /**
     *	@description	
     *	@param	
     */
    public function __construct(
        ValidateRequest $request
    )
    {
        $this->request = $request;
        parent::__construct('transfer/validate/');
    }
    /**
     *	@description	
     *	@param	
     */
    public function validate(): ValidateResponse
    {
        $data = $this->fetchPost('zoomme', $this->request, false);
        return new ValidateResponse((!empty($data))? $data : []);
    }
}