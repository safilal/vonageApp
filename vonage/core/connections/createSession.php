<?php

namespace vonage;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Client;

class createSession{
	   
	   private $vRestApi;
	   private $vUsername;
	   private $vPassword;
	   public  $client;
	   public  $cookie;
	   
	public function __construct($vRestApi, $vUsername, $vPassword){
	 
		$this->vRestApi = $vRestApi;
		$this->vUsername = $vUsername;
		$this->vPassword = $vPassword;
		$this->createClient();
		$this->createCookie();
		
		$setAccount = '/appserver/rest/user/null?';

		// authenticate session
	    $this->sendRequest($setAccount);

	}
	
	public function createClient(){
		$this->client = new \GuzzleHttp\Client([$this->vRestApi, $this->vUsername, $this->vPassword]);
		//$client->get('http://httpbin.org/cookies', ['cookies' => $jar]);
	}
	
	public function createCookie(){
		$this->cookie = new \GuzzleHttp\Cookie\CookieJar;
	}
	
	public function sendRequest($uri_path) {
		  try {
			   $uri = $this->vRestApi . $uri_path;
			   print_r("uri is $uri<br/>\n");
			   $response = $this->client->get($uri,
					[
						 'cookies' => $this->cookie,
						 'query'=> 
							  ['htmlLogin'=> $this->vUsername, 
							  'htmlPassword'=>$this->vPassword]
					]
			   );
			   return $response->getBody()->getContents();
		  } catch (Exception $e) {
			  // log errors to file and send message
			  echo "problems";
			  return false;
		  }
	}
	
}

?>