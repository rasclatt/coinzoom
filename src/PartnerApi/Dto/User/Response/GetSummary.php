<?php
namespace CoinZoom\PartnerApi\Dto\User\Response;

class GetSummary extends \CoinZoom\PublicApi\Dto
{
    public $identifier = '';
    public $minimumCardLevel = '';
    public $createdOn = '';
    public $signedUpOn = '';
    public $email = '';
    public $emailVerified = '';
    public $firstName = '';
    public $middleName = '';
    public $lastName = '';
    public $city = '';
    public $state = '';
    public $zipCode = '';
    public $kycSubmitted = '';
    public $kycStatus = '';
    public $kycRejectedReason = '';
    public $zoomHandle = '';
}