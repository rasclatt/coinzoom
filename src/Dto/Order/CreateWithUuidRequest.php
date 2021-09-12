<?php
namespace CoinZoom\Dto\Order;

class CreateWithUuidRequest extends CreateRequest
{
    public $referralToken = '';
}