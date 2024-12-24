<?php
	
	namespace Sapack\Integration;
	
	use GuzzleHttp\Client;
	use GuzzleHttp\Exception\ClientException;
	use GuzzleHttp\Psr7\Request;
	use Ramsey\Uuid\Uuid;
	
	class AdmedikaHttp
	{
		var $dbhis;
		var $dbsupp;
		var $db;
		var $db2;
		
		var $admedika_env;
		var $admedika_url;
		var $admedika_customerID;
		var $admedika_securityWord;
		var $admedika_terminalID;
		
		public function __construct() {
			$CI           = & get_instance();
			$this->config = $CI->config;
			
			$this->db     = $CI->db;
			$this->dbsupp = $CI->dbsupp;
			$this->db2    = $CI->db2;
			$this->dbhis  = $CI->dbhis;
			
			$this->admedika_env          = $this->config->item('AdmedikaENV');
			$this->admedika_url          = $this->config->item('AdmedikaBaseURL');
			$this->admedika_customerID   = $this->config->item('AdmedikaCustomerID');
			$this->admedika_securityWord = $this->config->item('AdmedikaSecurityWord');
			$this->admedika_terminalID   = $this->config->item('AdmedikaTerminalID');
			
			date_default_timezone_set("Asia/Bangkok");
			
			$this->admedika_datetime = date('YmdHis');
		}
		
		public function AdToken($serviceID, $requestID) {
			$securityWordSHA256 = hash('SHA256', $this->admedika_securityWord);
			$tokenAuth = hash('SHA256', $this->admedika_customerID.':'.$securityWordSHA256.':'.$this->admedika_datetime.':'.$requestID.':'.$serviceID);
			
			return $tokenAuth;
		}
		
		public function ad_post($url, $body)
		{
			$client  = new Client();
			$request = new Request('POST', $url, $body);
			
			try {
				$res        = $client->sendAsync($request)->wait();
				$statusCode = $res->getStatusCode();
				$response   = json_decode($res->getBody()->getContents());

//			print_r([$statusCode, $response]);
				return [$statusCode, $response];
				
			} catch (ClientException $e) {
				$statusCode = $e->getResponse()->getStatusCode();
				$res        = json_decode($e->getResponse()->getBody()->getContents());

//			print_r([$statusCode, $res]);
				return [$statusCode, $res];
			}
			
			$res = $client->sendAsync($request)->wait();
			echo $res->getBody();
		}
		
		public function tipeRawatToCovID($tipe) {
			if ($tipe == 'RANAP'){
				$covID   = '01';
				$covCode = 'HNS';
				$covDesc = 'RAWAT INAP';
			}elseif ($tipe == 'RAJAL'){
				$covID   = '02';
				$covCode = 'GP';
				$covDesc = 'RAWAT JALAN';
			}elseif ($tipe == 'PREPOST'){
				$covID   = '03';
				$covCode = 'SP';
				$covDesc = 'PRE & POST';
			}elseif ($tipe == 'KACAMATA'){
				$covID   = '04';
				$covCode = 'OP';
				$covDesc = 'KACAMATA';
			}elseif ($tipe == 'GIGI'){
				$covID   = '05';
				$covCode = 'DENTAL';
				$covDesc = 'RAWAT GIGI';
			}elseif ($tipe == 'PERSALINAN'){
				$covID   = '06';
				$covCode = 'MAT';
				$covDesc = 'PERSALINAN';
			}elseif ($tipe == 'LAB'){
				$covID   = '07';
				$covCode = 'LAB';
				$covDesc = 'LABORATORY';
			}elseif ($tipe == 'FARMASI'){
				$covID   = '08';
				$covCode = 'PHAR';
				$covDesc = 'PHARMASY/APOTEK';
			}else{
				$covID   = '02';
				$covCode = 'GP';
				$covDesc = 'RAWAT JALAN';
			}
			
			return [ $covID, $covCode, $covDesc];
		}
		
	}