<?php
namespace CoinZoom\PartnerApi\Dto;

class Notes extends \CoinZoom\PublicApi\Dto
{
    public $note = '';

    public function __toString()
    {
        return $this->note;
    }
}