<?php
namespace CoinZoom\PartnerApi\Dto\PaymentGateway\Response;

class Prices extends \CoinZoom\PublicApi\Dto
{
    public $currency = '';
    public $url = '';
    public $qrCode = '';
    public $qrImg = '';
    public $urlHtml = '';

    public function qrCode()
    {
        if(empty($this->qrCode))
            return $this->qrImg;

        $this->qrImg = "<img src=\"data:image/png;base64, {$this->qrCode}\" />";
    }

    public function url()
    {
        if(empty($this->url))
            return $this->url;

        $this->urlHtml = "<a {{attr}} href=\"{$this->url}\">{{content}}</a>";
    }
}