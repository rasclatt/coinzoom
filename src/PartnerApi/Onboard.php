<?php
namespace CoinZoom\PartnerApi;

use \CoinZoom\PartnerApi\Dto\Onboard\ {
    CreateRequest,
    CreateResponse
};

class Onboard extends \CoinZoom\Contents
{
    /**
     *	@description	
     *	@param	
     */
    public function __construct()
    {
        parent::__construct('onboard/');
    }
    /**
     *	@description	
     *	@param	
     */
    public function create(CreateRequest ...$request)
    {
        $data = array_map(function($v) {
            return $v->toArray();
        }, $request);

        $fetch = $this->addBody((array) $data);
        
        try {
            $response = $fetch->post();
            
            if(!empty($response) && is_array($response)) {
                $arr = [];
                foreach($response as $row) {
                    $arr[] = new CreateResponse($row);
                }
                return $arr;
            }
            return $response;
        }
        catch (\Exception $e) {
            return [
                new CreateResponse([
                    'success' => false,
                    'onboarded' => [],
                    'message' => $e->getMessage(),
                    'email' => '',
                    "externalIdentifier" => null,
                    "zoomMeHandle" => null
                ])
            ];
        }
    }
}