![Maintenance](https://img.shields.io/badge/Maintained%3F-yes-green.svg)


## PHP SDK for Coinzoom

It should be noted that this SDK is skewed towards Multi-level Marketing so there may be lingo related to that field so for example `distid`, would be a Member Id or Clent Id.

> It should also be noted this is early stages of tooling and development.

### Example 1: Fetch countries

```php
use \CoinZoom\PartnerApi\Locale;

$arr = [];
array_map(function($v) use (&$arr) {
    $arr[$v['isoCode3']] = $v['name'];
}, (new Locale())->getCountries());
print_r($arr);

```

### Example 2: Fetch Region

```php
use \CoinZoom\PartnerApi\Locale;

$regions = (new Locale())->getRegions('USA'); 
$arr = [];
array_map(function($v) use (&$arr) {
    $arr[$v['code']] = $v['name'];
}, $regions);
print_r($arr);
```

### Example 3: Onboard New Members

```php
class OnboardCreateRequest extends \SmartDto\Dto
{
    public $email = 'someemail@example.com';
    public $mobileNumber = 1322131231231;
    public $firstName = 'Jane';
    public $middleName = '';
    public $lastName = 'Doe';
    public $dateOfBirth = '1982-04-17';
    public $addressLine1 = '101 Some Address';
    public $addressLine2 = '';
    public $city = 'Reno';
    public $stateCode = 'NV';
    public $zipCode = 89523;
    public $countryCode = 'USA';
    public $employmentStatus = 'FULL_TIME';
    public $preTaxAnnualIncome = '50k-100k';
    public $gender = 'FEMALE';
    public $distid = '112932';
}

$coinzoomData = new OnboardCreateRequest();
$Onboarding = new \CoinZoom\PartnerApi\Onboard();

try {
    # Create a new user
    $data = $Onboarding->create(...[
        new OnboardCreateRequest($coinzoomData)
    ]);
}
catch (\Exception $e) {
    print_r([
        'success' => false,
        'message' => 'Missing required values'
    ]);
}
# If the user was not created, tell
if(empty($data[0]->success)) {
    print_r([
        'success' => false,
        'message' => str_replace(['{','}','='],['','',': '],$data[0]->message)
    ]);
}
else {
    # Create a new Dto for ease of use
    print_r($data[0]->toArray());
}
```

### Example 4: Create a transaction

```php
use \CoinZoom\Dto\ {
    Order\Create as OrderCreate,
    Order\CreateWithUuidRequest as OrderCreateUuid
};
use \CoinZoom\ {
    Order,
    Currency,
    Market
};

# Create an order dto to send to wallet
$data = [
    'distid' => $request->distid,
    'invoice' => $request->invoice,
    'price' => $request->total
];
# Create new user order
if(!empty($request->referralToken)) {
    $data['referralToken'] = $request->referralToken;
    $CreateDto = new OrderCreateUuid($data);
}
# Create current user order
else
    $CreateDto = new OrderCreate($data);
# Start transaction
$CZ = new Order($CreateDto);
# Set reply url (spinner)
$CZ->setWebhook('https://www.example.com/webhook/')
# Set the default currency
    ->setPaymentOption('USD');
# Try and create the CZ transaction
try {
    # Create the CZ transaction
    $createTransaction = $CZ->create(new Currency(new Market()));
}
catch (\Exception $e) {
    die('Wallet failed with error: '.$e->getMessage().':'.$e->getCode());
}
print_r($createTransaction);
```
