<?php
namespace CoinZoom\PartnerApi\Dto\Onboard;

class CreateResponse extends \SmartDto\Dto
{
    public $email = '';
    public $success = false;
    public $message = '';
    public $externalIdentifier = '';
    public $zoomMeHandle = null;
    /**
     *	@description	
     *	@param	
     */
    protected function message()
    {
        if(!$this->success && stripos($this->message, 'onboarding failed') !== false)
            $this->message = 'This email address is likely aready in use. If you already have a ZoomMe, please using your ZoomMe handle.';
    }
}