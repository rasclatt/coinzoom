<?php

namespace CoinZoom;

use \CoinZoom\Dto\Content\Init;

/**
 * @description To set to dev mode, use the public constant before constructor.
 * 
 * use \CoinZoom\ {
 *  PublicApi\Currency,
 *  Contents as CoinZoom
 * };
 * 
 * CoinZoom::$mode = CoinZoom::DEVMODE
 * $CoinZoom = new Currency();
 * ...do stuff
 */

class Contents implements \HttpClient\IHttpClient
{
    const DEVMODE   =   true;
    const PRODMODE  =   false;

    // Set to "true" for dev mode default
    public static $mode = false;
    public static $apiKey = false;
    public static $apiSecret = false;

    private $endpoint, $context, $body, $response;
    private $sendType = 'json';
    /**
     *	@description	
     *	@param	
     */
    public function __construct(string $baseService = null)
    {
        # Start the call attr
        $this->context['http']  =   [];
        # Set the connection attributes for the call
        $attr = $this->getConnectionAttributes($baseService);
        # Store final endpoint
        $this->endpoint =   $attr->endpoint;
        # Create our credential headers
        foreach ([
            'Coinzoom-Api-Key' => $attr->api_key,
            'Coinzoom-Api-Secret' => $attr->api_secret,
            'Content-type' => $attr->content_type
        ] as $key => $value) {
            $this->addHeader($key, $value);
        }
    }
    /**
     *	@description	Returns connection attributes option for credentials
     */
    private function getConnectionAttributes(string $baseService): Init
    {
        return new Init([
            'endpoint' => constant('CZ_ENDPOINT_PUB' . ((self::$mode) ? '_DEV' : '')) . $baseService,
            'api_key' => (!empty(self::$apiKey)) ? self::$apiKey : constant('CZ_APIKEY' . ((self::$mode) ? '_DEV' : '')),
            'api_secret' => (!empty(self::$apiSecret)) ? self::$apiSecret : constant('CZ_APISECRET' . ((self::$mode) ? '_DEV' : '')),
            'content_type' => ($this->sendType == 'json') ? 'application/json' : 'application/x-www-form-urlencoded'
        ]);
    }
    /**
     *	@description	Appends main endpoint with a service string
     */
    public function setService(string $service)
    {
        $this->endpoint .=  $service;
        return $this;
    }
    /**
     *	@description	Adds headers to call
     */
    public function addHeader($key, $value)
    {
        $this->context['http']['header'][]    =   "{$key}: {$value}";
        return $this;
    }
    /**
     *	@description	
     */
    public function addAuth($token)
    {
    }
    /**
     *	@description	
     */
    public function addBody(array $array = null)
    {
        $this->body =   $array;
        return $this;
    }
    /**
     *	@description	
     */
    public function post()
    {
        return $this->init(__FUNCTION__)->getResponse();
    }
    /**
     *	@description	
     */
    public function patch()
    {
        return $this->init(__FUNCTION__)->getResponse();
    }
    /**
     *	@description	
     */
    public function get()
    {
        return $this->init(__FUNCTION__)->getResponse();
    }
    /**
     *	@description	
     */
    public function delete()
    {
        return $this->init(__FUNCTION__)->getResponse();
    }
    /**
     *	@description	
     *	@param	
     */
    public function init($type)
    {
        $this->context['http']['method']    =   $type = strtoupper($type);
        if (!empty($this->body)) {
            if (in_array($type, ['POST', 'PATCH'])) {
                $this->context['http']['content'] = ($this->sendType == 'json') ? json_encode($this->body) : http_build_query($this->body);
            } else {
                $this->endpoint .= '?' . http_build_query($this->body);
            }
        }
        $context = stream_context_create($this->context);
        $fetch  =   @file_get_contents($this->endpoint, false, $context);
        $this->response['headers'] =   ($http_response_header) ?? [];
        $this->response['response'] = $fetch;
        return $this;
    }
    /**
     *	@description	
     *	@param	
     */
    public function getRawResponse()
    {
        return $this->response['response'];
    }
    /**
     *	@description	
     *	@param	
     */
    public function getResponse()
    {
        return ($this->sendType == 'json' && is_string($this->response['response'])) ? json_decode($this->response['response'], 1) : $this->response['response'];
    }
    /**
     *	@description	
     *	@param	
     */
    public function getResponseHeaders()
    {
        return $this->response['headers'];
    }
    /**
     *	@description	
     *	@param	
     */
    public function debug()
    {
        return [
            'response' => $this->response,
            'endpoint' => $this->endpoint,
            'body' => $this->body,
            'context' => $this->context
        ];
    }
    /**
     *	@description	Single mechanism to fetch posts
     */
    protected function fetchPost(string $service, \SmartDto\Dto $Dto, $sep = '/')
    {
        return $this->setService("{$service}{$sep}")
            ->addBody($Dto->toArray())
            ->post();
    }
}
