<?php
namespace CoinZoom;

use \CoinZoom\PartnerApi\ {
    User as UserModel
};

use \CoinZoom\PartnerApi\Dto\ {
    User\CreateUid,
    User\UpdateUid,
    User\GetSummary
};

class User
{
    /**
     *	@description	
     *	@param	
     */
    public function create(string $email, $accountLevel = 'Select')
    {
        $fetch = $this->getModel();
        $data = $fetch->createUid(new CreateUid([
            'minimumCardLevel' => ucfirst(strtolower($accountLevel)),
            'knownEmailAddress' => $email
        ]));
        /*
        if(stripos($fetch->getResponseHeaders()[0], 'bad')) {
            throw new \Exception('User may already be created.', 500);
        }
        */
        return $data->getuuid();
    }
    /**
     *	@description	
     *	@param	
     */
    public function update(string $uuid, string $accountLevel = 'Preferred')
    {
        $this->getModel()->updateTier(new UpdateUid([
            'identifier' => $uuid,
            'minimumCardLevel' => ucfirst(strtolower($accountLevel))
        ]));

        return $this->getModel()->getSummary(new GetSummary(['identifier' => $uuid]));
    }
    /**
     *	@description	
     *	@param	
     */
    public function getSummary(string $uuid)
    {
        $User = new \CoinZoom\PartnerApi\User();

        return @$User->{__FUNCTION__}(new \CoinZoom\PartnerApi\Dto\User\GetSummary([
            'identifier' => $uuid
        ]));
    }
    /**
     *	@description	
     *	@param	
     */
    private function getModel()
    {
        return new UserModel();
    }
}