<?php
namespace CoinZoom\PartnerApi\Dto\Onboard;

class CreateRequest extends \SmartDto\Dto
{
    public $email = '';
    public $mobileNumber = 0;
    public $firstName = '';
    public $middleName = '';
    public $lastName = '';
    public $dateOfBirth = '';
    public $addressLine1 = '';
    public $addressLine2 = '';
    public $city = '';
    public $stateCode = '';
    public $zipCode = 0;
    public $countryCode = '';
    public $employmentStatus = '';
    public $preTaxAnnualIncome = '';
    public $gender = '';
}