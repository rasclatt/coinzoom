<?php
namespace CoinZoom;

/*use \GuzzleHttp\ {
	Client as Http,
	Exception\RequestException
};
*/

use \HttpClient\Curl as Http;

class Service
{
    const DEVMODE   =   true;
    const PRODMODE  =   false;
    public static $mode = false;
	# Path to the ssl cert
	public static $certpath	= '/etc/ssl/certs/ca-bundle.crt';
	# Set the call timeout
    public  $timeout    =   10;
	# The raw return
	public	$response;
	# Various call attributes
    private $headers, $body, $endpoint, $errors, $debug;
	# Send type
	private $sendType;
    public $partnerZoomme = false;
	/**
	 *	@description	Do base setup
	 */
	public function __construct($_endpoint, $_uri, $sendType = 'json', string $partnerZoomme = null)
	{
		$this->partnerZoomme = $partnerZoomme;
		$this->sendType	=	$sendType;
        $this->endpoint =   $_endpoint.$_uri;
        $this
		->addHeader('Coinzoom-Api-Key', (self::$mode)? CZ_APIKEY_DEV : CZ_APIKEY)
		->addHeader('Coinzoom-Api-Secret', (self::$mode)? CZ_APISECRET_DEV : CZ_APISECRET)
		->addHeader('Content-type', ($this->sendType == 'json')? 'application/json' : 'application/x-www-form-urlencoded');
		# Add header if public zoomme is supplied
		if(!empty($this->partnerZoomme))
			$this->addHeader('User-Agent', 'ZoomMe: '.$this->partnerZoomme);
	}
    /**
     *	@description	
     *	@param	
     */
    public function getPublicUri()
    {
        return (self::$mode)? CZ_ENDPOINT_PUB_DEV : CZ_ENDPOINT_PUB;
    }
    /**
     *	@description	
     *	@param	
     */
    public function setSendType(string $sendType)
    {
        $this->sendType =   $sendType;
        return $this;
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
	public function addBody(array $array = null)
	{
        $this->body =   (!empty($this->body))? array_merge($this->body, $array): $array;
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
		return $this->build(function($Http) use ($type) {
			return $Http->query($type);
		});
	}
	/**
	 *	@description	Creates a get-like request (get, delete)
	 */
	public function createGetLike($type)
	{
		return $this->build(function($Http) use ($type) {
			return $Http->query($type, $this->sendType, $this->sendType, 'GET');
		});
	}
	/**
	 *	@description	
	 *	@param	
	 */
	public function build($sendFunc)
	{
        $Http	=	$this->init();
		foreach($this->headers as $k => $v) {
			$Http->addHeader("{$k}: {$v}");
		}
		$Http->addBody($this->body);
		$Http->addOption(CURLOPT_SSL_VERIFYPEER, 0)
		->addOption(CURLOPT_SSL_VERIFYHOST, 0);
		//->addOption(CURLOPT_CAINFO, self::$certpath);

		$data = $sendFunc($Http);
		$this->debug	=	$Http->getDebug();
		$this->response	=	$Http->getResponse();
		$this->errors	=	$Http->getErrors();

		if(!empty($this->errors))
			throw new \Exception($this->errors, 500);
		elseif(empty($data) && !empty($this->response))
			throw new \Exception("Computer says ".substr(strip_tags($this->response), 0, 100), 500);

		return $data;
	}
	/**
	 *	@description	Creates a new Guzzle instance
	 */
	public function init()
	{
        return new Http($this->endpoint);
	}
	/**
	 *	@description	Universal error response
	 */
	public function invalidReturn(\Exception $e)
	{
		return [
			'error' => $e->getMessage(),
			'code' => $e->getCode()
		];
	}
	/**
	 *	@description	
	 *	@param	
	 */
	public function getErrors()
	{
		return $this->errors;
	}
	/**
	 *	@description	
	 *	@param	
	 */
	public function getResponse()
	{
		return $this->response;
	}
	/**
	 *	@description	
	 *	@param	
	 */
	public function getDebug()
	{
		return $this->debug;
	}
}