<?php

namespace CoinZoom;
# Use Guzzle to create requests
use GuzzleHttp\Client as Http;

/**
 *	@description	
 */
class Guzzle implements \HttpClient\IHttpClient
{
	const DEVMODE   =   true;
	const PRODMODE  =   false;
	public static $mode = true;
	public  $timeout    =   20;
	private $options, $ch, $headers, $body, $endpoint;
	private $sendType   =   'json';
	/**
	 *	@description	
	 */
	public function __construct(string $endpoint = null)
	{
		$this->endpoint =   $endpoint;

		$this->addHeader('Coinzoom-Api-Key', (self::$mode) ? CZ_APIKEY_DEV : CZ_APIKEY)
			->addHeader('Coinzoom-Api-Secret', (self::$mode) ? CZ_APISECRET_DEV : CZ_APISECRET)
			->addHeader('Content-type', ($this->sendType == 'json') ? 'application/json' : 'application/x-www-form-urlencoded');
	}
	/**
	 *	@description	
	 *	@param	
	 */
	public function getPublicUri()
	{
		return (self::$mode) ? CZ_ENDPOINT_PUB_DEV : CZ_ENDPOINT_PUB;
	}
	/**
	 *	@description	
	 */
	public function setService(string $service)
	{
		$this->endpoint .= $service;
		return $this;
	}
	/**
	 *	@description	
	 */
	public function addHeader($key, $value)
	{
		$this->headers[$key]    =   $value;
		return $this;
	}
	/**
	 *	@description	
	 */
	public function addAuth($token)
	{
		$this->addHeader('Authorization', 'Bearer ' . $token);
		return $this;
	}
	/**
	 *	@description    
	 */
	public function addBody(array $array = null)
	{
		$this->body =   (!empty($this->body)) ? array_merge($this->body, $array) : $array;
		return $this;
	}
	/**
	 *	@description	
	 */
	public function post()
	{
		return $this->createPostLike(__FUNCTION__);
	}
	/**
	 *	@description	
	 */
	public function patch()
	{
		return $this->createPostLike(__FUNCTION__);
	}
	/**
	 *	@description	
	 */
	public function get()
	{
		return $this->createGetLike(__FUNCTION__);
	}
	/**
	 *	@description	
	 */
	public function delete()
	{
		return $this->createGetLike(__FUNCTION__);
	}
	/**
	 *	@description	Creates a post-like request (patch and post)
	 */
	public function createPostLike($type)
	{
		return json_decode($this->init()->request(strtoupper($type), $this->endpoint, [
			'headers' => $this->headers,
			(($this->sendType == 'json') ? 'json' : 'form_params') => $this->body
		])->getBody());
	}
	/**
	 *	@description	Creates a get-like request (get, delete)
	 */
	public function createGetLike($type)
	{
		if (!empty($this->body))
			$this->endpoint .=  '?' . http_build_query($this->body);

		return json_decode($this->init()->request(strtoupper($type), $this->endpoint, [
			'headers' => $this->headers
		])->getBody(), 1);
	}
	/**
	 *	@description	Creates a new Guzzle instance
	 */
	public function init()
	{
		return new Http([
			'base_uri' => $this->getPublicUri(),
			'timeout'  => $this->timeout,
			'debug' => true,
			'verify' => false
		]);
	}
}
