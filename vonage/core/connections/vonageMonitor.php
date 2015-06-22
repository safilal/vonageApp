<?php

namespace vonage;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

Class monitorVonage{
	
	private	$session;
	
	public function __construct(createSession $session){
		$this->session = $session;
	}
	
	public function checkStatus($extension) {
		// create path
		$path = '/presence/dashui?filterExtension=' . $extension . '&firstRequest=true';

		// send the request
		$vonageResponse = $this->session->sendRequest($path);
		
		// show the response
		// var_dump($vonageResponse);
		return $vonageResponse;
	}

}
?>