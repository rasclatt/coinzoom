<?php
namespace CoinZoom\Dto\Content;

class Init extends \SmartDto\Dto
{
    public $endpoint = '';
    public $api_key = '';
    public $api_secret = '';
    public $content_type = '';
    public $user_agent = '';
}