<?php
namespace CoinZoom\PartnerApi;

use \CoinZoom\PartnerApi\Dto\User\ {
    CreateUid,
    Response\CreateUid as CreateUidResponse,
    GetSummary,
    Response\GetSummary as GetSummaryResponse,
    UpdateUid
};

class User extends \CoinZoom\Contents
{
    private $accountTypes = [
        'Select', // Free Tier
        'Preferred', // Free Tier
        'Gold',
        'Platinum',
        'Black'
    ];
    /**
     *	@description	Sets the base service name
     */
    public function __construct()
    {
        parent::__construct('external_reference/');
    }
    /**
     *	@description	Fetches the name of the Tier by the index
     */
    public function getAccountLevelByNumber($number)
    {
        return $this->accountTypes[$number - 1];
    }
    /**
     *	@description	Creates a new user id
     */
    public function createUid(CreateUid $Dto): CreateUidResponse
    {
        # Create the post
        $this->fetchPost("new", $Dto);
        # Fetch the main undecoded response
        $uuid = $this->getRawResponse();
        # Send data back
        return new CreateUidResponse([ 'uuid' => $uuid ]);
    }
    /**
     *	@description    Updates the users's account tier
     *  @note           The first two tiers are free, last three incurr a cost to the company
     *  @returns        This returns nothing for some reason
     */
    public function updateTier(UpdateUid $Dto): void
    {
        $this->fetchPost('update', $Dto);
    }
    /**
     *	@description	Fetches the user's account information
     */
    public function getSummary(GetSummary $Dto): GetSummaryResponse
    {
        return new GetSummaryResponse($this->fetchPost('get', $Dto));
    }
    /**
     *	@description	Single mechanism to fetch posts
     */
    private function fetchPost($service, $Dto)
    {
        return $this->setService("{$service}/")
            ->addBody($Dto->toArray())
            ->post();
    }
    /**
     *	@description	Allows altering of the Coinzoom tier
     */
    public function alterTierList(string $tier, $action = true)
    {
        if($action) {
            $this->accountTypes[] = $tier;
        }
        else {
            if(in_array($tier, $this->accountTypes)) {
                unset($this->accountTypes[array_search($tier, $this->accountTypes)]);
            }
        }
        return $this;
    }
}