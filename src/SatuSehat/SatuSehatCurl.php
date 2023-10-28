<?php
	
	namespace Bridging\SatuSehat;
	
	class SatuSehatCurl{
		var $config;
		
		private  $headers,
		 $data,
		 $url,
		 $ch,
		 $results,
		 $curl_returntransfer = true,
		 $curl_header = false,
		 $error = false,
		 $errorMsg;
		
		public function __construct($params = NULL) {
			$CI                = &get_instance();
			$CI->SatuSehatHttp = $this;
			$this->config      = $CI->config;
			
			$this->OAuthBaseURL = $this->config->item('SatuSehatOAuthBaseURL');
			$this->BaseURL      = $this->config->item('SatuSehatBaseURL');
			$this->ConsentURL   = $this->config->item('SatuSehatConsentURL');
			
			if(!is_null($params)){
				$this->setOptions($params);
			}
			
		}
		
		public function setOptions($params) {
			foreach ($params as $key => $val) {
				$this->{$key} = $val;
			}
			
			$this->ch = curl_init();
			curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, $this->curl_returntransfer);
			curl_setopt($this->ch, CURLOPT_HEADER, $this->curl_header);
			curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
		}
		
		private function execute()
		{
			$this->error = false;
			
			//executes the curl
			$this->results = curl_exec($this->ch);
			
			if(curl_errno($this->ch)){
				//set error message
				$this->error = true;
				$this->errorMsg = curl_error($this->ch);
				curl_close($this->ch);
				return false;
			} else {
				curl_close($this->ch);
				return true;
			}
		}
		
		public function getResults()
		{
			return $this->results;
		}
		
		public function getResultsArray()
		{
			return json_decode( $this->results, true );
		}
		
		public function getError()
		{
			return $this->error;
		}
		
		public function getErrorMsg()
		{
			return $this->errorMsg;
		}
		
		private function queryData($d)
		{
			if (is_array($d)) {
				$data = http_build_query($d);
			} else {
				$data = $d;
			}
			return $data;
		}
		
		private function checkEssentials()
		{
			$this->error = false;
			if (!empty($this->url) && !empty($this->data)) {
				return true;
			}
			
			$this->error = true;
			$this->errorMsg = 'No URL/Data provided';
			return false;
		}
		
		public function post()
		{
			if ($this->checkEssentials()) {
				$post_data = $this->queryData($this->data);
				
				$options = array(
				 CURLOPT_URL => $this->url,
				 //CURLOPT_POST => count($post_data), //default
				 CURLOPT_POST => true,
				 CURLOPT_POSTFIELDS => $post_data,
				);
				
				curl_setopt_array ( $this->ch, $options );
				
				//set headers
				if( !empty($this->headers) ){
					curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
				}
				return $this->execute();
			}
			return false;
		}
		
		public function get()
		{
			if ($this->checkEssentials()) {
				
				$get_data = $this->queryData($this->data);
				
				curl_setopt($this->ch, CURLOPT_URL, $this->url . '?' . $get_data);
				
				//set headers
				if (!empty($this->headers)) {
					curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
				}
				return $this->execute();
			}
			return false;
		}
		
		public function getToken()
		{
			$this->setOptions(
			 array(
				'data' => array(
				 'client_id'     => $this->config->item('SatuSehatClientID'),
				 'client_secret' => $this->config->item('SatuSehatClientSecret')
				),
				'url' => $this->OAuthBaseURL.'/accesstoken?grant_type=client_credentials',
			 ));
			
			if($this->post()){
				$result =  $this->getResultsArray() ;
				return $result;
			} else {
				echo $this->getErrorMsg();
			}
		}
		
		public function SatuSehatToken()
		{
			$req          = $this->SatuSehatHttp->getToken();
			$access_token = 'Bearer '.$req['access_token'];
			return $access_token;
		}
		
		public function SatuSehatGET($enpoint)
		{
			$access_token = $this->SatuSehatToken();
			$this->setOptions(
			 array(
				'headers' => array(
				 'Authorization:'.$access_token.'',
				 'Content-Type: application/json',
				),
				'url' => $this->BaseURL.$enpoint,
			 ));
			
			if($this->get()){
				return $this->getResultsArray();
			} else {
				echo $this->getErrorMsg();
			}
		}
		
		public function SatuSehatPOST($enpoint, $data)
		{
			$access_token = $this->SatuSehatToken();
			
			$this->setOptions(
			 array(
				'headers' => array(
				 'Authorization:'.$access_token.'',
				 'Content-Type: application/x-www-form-urlencoded',
				),
				'data' => $data,
				'url' => $this->BaseURL.$enpoint,
			 ));
			
			if($this->post()){
				return $this->getResultsArray();
			} else {
				echo $this->getErrorMsg();
			}
		}
		
	}
