<?php
namespace CoinZoom\PartnerApi\Dto\Onboard;

class CreateResponse extends \SmartDto\Dto
{
    public $email = '';
    public $success = false;
    public $message = '';
    public $externalIdentifier = '';
    public $zoomMeHandle = null;
}