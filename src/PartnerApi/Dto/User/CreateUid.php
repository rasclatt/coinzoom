<?php
namespace CoinZoom\PartnerApi\Dto\User;

class CreateUid extends \SmartDto\Dto
{
    public $minimumCardLevel = "Select";
    public $knownEmailAddress = "";

    protected function knownEmailAddress()
    {
        if(!filter_var($this->knownEmailAddress, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Invalid email address', 500);
        }
    }
}