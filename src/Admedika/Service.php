<?php
	
	namespace Sapack\Integration\Admedika;
	
	use Sapack\Integration\AdmedikaHttp;
	
	class Service extends AdmedikaHttp
	{
		
		public function eligibility($requestID, $cardNo, $covID) {
			$serviceID = 'ELIGIBILITY';
			$url       = '';
			
			$token = $this->AdToken($serviceID, $requestID);
			$payload = [
				"input" => [
					"tokenAuth"   => $token,
					"serviceID"   => $serviceID,
					"customerID"  => $this->admedika_customerID,
					"requestID"   => $serviceID,
					"txnData"     => [
						"eligibilityRequest" => [
							"eligibility" => [
								"terminalID"        => $this->admedika_terminalID,
								"cardNo"            => $cardNo,
								"covID"             => $covID,
								"diagnosisCodeList" => "",
								"providerTransID"   => "",
								"nationalID"        => "",
								"familyCardID"      => "",
								"physicianName"     => "TEST",
								"accidentFlag"      => "N",
								"surgicalFlag"      => "N",
								"roomType"          => "O",
								"roomPrice"         => "0",
								"remarks"           => "",
							],
						],
					],
					"txnRequestDateTime" => $this->admedika_datetime,
				],
			];
			
			$body = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
			return $this->ad_post($url, $body);
		}
		
		public function getEntitlement($requestID, $cardNo) {
			$serviceID = 'GET_ENTITLEMENT';
			$url       = '';
			
			$token = $this->AdToken($serviceID, $requestID);
			
			$payload = [
				"input" => [
					"tokenAuth"   => $token,
					"serviceID"   => $serviceID,
					"customerID"  => $this->admedika_customerID,
					"requestID"   => $requestID,
					"txnData" => [
						"getEntitlementRequest" => [
							"getEntitlement" => [
								"terminalID"  => $this->admedika_terminalID,
								"cardNo"      => $cardNo,
							],
						],
					],
					"txnRequestDateTime" => $this->admedika_datetime,
				],
			];
			
			$body = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
			return $this->ad_post($url, $body);
		}
		
		public function dailyMonitoring($requestID, $cardNo) {
			$serviceID = 'DAILY_MONITORING';
			$url       = '';
			
			$token = $this->AdToken($serviceID, $requestID);
			
			$payload = [
				"input" => [
					"tokenAuth"   => $token,
					"serviceID"   => $serviceID,
					"customerID"  => $this->admedika_customerID,
					"requestID"   => $requestID,
					"txnData"     => [
						"dailyMonitoringRequest" => [
							"dailyMonitoring" => [
								"terminalID"      => $this->admedika_terminalID,
								"cardNo"          => $cardNo,
								"providerTransID" => "",
								"clID"            => "122060658",
								"dmUser"          => "BA TEST",
								"dmForms"         => [
									[
										"code"  => "003-A",
										"name"  => "Nama Ruang Perawatan",
										"input" => "Test",
										"date"  => "11052023",
									],
								],
							],
						],
					],
					"txnRequestDateTime" => $this->admedika_datetime,
				],
			];
			
			$body = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
			return $this->ad_post($url, $body);
		}
		
		public function finalBill($requestID) {
			$serviceID = 'DAILY_MONITORING';
			$url       = '';
			
			$token = $this->AdToken($serviceID, $requestID);
			
			$payload = [
				"input" => [
					"tokenAuth"   => $token,
					"serviceID"   => $serviceID,
					"customerID"  => $this->admedika_customerID,
					"requestID"   => $requestID,
					"txnData" => [
						"finalBillRequest" => [
							"finalBill" => [
								"terminalID"      => $this->admedika_terminalID,
								"cardNo"          => "8000991200017526",
								"providerTransID" => "",
								"clID"            => "135653849",
								"finalFlag"       => "N",
								"invoiceNo"       => "ADTEST-135653849-DUMMY",
								"invoiceDate"     => "08072024",
								"dateAdmission"   => "08072024",
								"dateDischarge"   => "08072024",
								"preparedBy"      => "AMELLYA SILVER",
								"itemGroups" => [
									[
										"groupCode" => "95000000",
										"groupName" => "Bed Charges",
										"ItemList"  => [
											[
												"code"      => "950000001",
												"name"      => "Room Charge : I - A Pediatric",
												"issueDate" => "08072024",
												"qty"       => "2",
												"totPrice"  => "50,000",
												"benID"     => "02",
												"remarks"   => "",
											],
											[
												"code"      => "950000002",
												"name"      => "Kamar Operasi Sedang Elektif Bdn THT",
												"issueDate" => "08072024",
												"qty"       => "1",
												"totPrice"  => "50,000",
												"benID"     => "02",
												"remarks"   => "",
											],
										],
									],
									[
										"groupCode" => "9799999",
										"groupName" => "Medical Equipment",
										"ItemList"  => [
											[
												"code"      => "97999999",
												"name"      => "Pemakalan Warm Air",
												"issueDate" => "08072024",
												"qty"       => "1",
												"totPrice"  => "100,000",
												"benID"     => "05",
												"remarks"   => "",
											],
										],
									],
									[
										"groupCode" => "98000000",
										"groupName" => "Pharmaceuticals",
										"ItemList"  => [
											[
												"code"      => "980000001",
												"name"      => "Ecosol Nacl 0.9% Infusion 100ml",
												"issueDate" => "08072024",
												"qty"       => "1",
												"totPrice"  => "15,000",
												"benID"     => "14",
												"remarks"   => "Infusion 100ml",
											],
											[
												"code"      => "980000002",
												"name"      => "Transamin Capsul 250 mg",
												"issueDate" => "08072024",
												"qty"       => "15",
												"totPrice"  => "15,000",
												"benID"     => "14",
												"remarks"   => "250mg",
											],
											[
												"code"      => "980000003",
												"name"      => "Sanmol infusion 10ml/ML -60ml",
												"issueDate" => "08072024",
												"qty"       => "2",
												"totPrice"  => "30,000",
												"benID"     => "14",
												"remarks"   => "250mg",
											],
										],
									],
								],
								"remarks" => "Test Remarks",
							],
						],
					],
					"txnRequestDateTime" => $this->admedika_datetime,
				],
			];
			
			$body = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
			return $this->ad_post($url, $body);
			
		}
		
		public function dischargeOP($requestID) {
			$serviceID = 'DISCHARGE_OP';
			$url       = '';
			
			$token = $this->AdToken($serviceID, $requestID);
			
			$payload = [
				"input" => [
					"tokenAuth"   => $token,
					"serviceID"   => $serviceID,
					"customerID"  => $this->admedika_customerID,
					"requestID"   => $requestID,
					"txnData"     => [
						"dischargeRequest" => [
							"discharge" => [
								"terminalID"        => $this->admedika_terminalID,
								"cardNo"            => "8000195100154799",
								"diagnosisCodeList" => "A04",
								"mcDays"            => "",
								"physicianName"     => "TEST",
								"accidentFlag"      => "N",
								"surgicalFlag"      => "N",
								"remarks"           => "TEST API",
								"entitlement"       => [
									[
										"benID"       => "41",
										"benAmount"   => "40,000",
										"benItemList" => [
											[
												"code"     => "001-0000000307",
												"name"     => "Antalgin Berlico caplet 500 mg",
												"qty"      => "2",
												"totPrice" => "15,000",
											],
											[
												"code"     => "001-0000000315",
												"name"     => "Biogesic oral liqd 160 mg5 mL",
												"qty"      => "2",
												"totPrice" => "10,000",
											],
											[
												"code"     => "001-0000000320",
												"name"     => "Contratemp oral drops 100 mgmL",
												"qty"      => "2",
												"totPrice" => "15,000",
											],
										],
									],
									[
										"benID"       => "39",
										"benAmount"   => "18870",
										"benItemList" => [
											[
												"code"     => "S2080020xx",
												"name"     => "Biaya doctor Umum",
												"qty"      => "1",
												"totPrice" => "18870",
											],
										],
									],
									[
										"benID"       => "07",
										"benAmount"   => "99900",
										"benItemList" => [
											[
												"code"     => "S2080000xx",
												"name"     => "Biaya doctor Specialis",
												"qty"      => "1",
												"totPrice" => "99900",
											],
										],
									],
									[
										"benID"       => "15",
										"benAmount"   => "20000",
										"benItemList" => [
											[
												"code"     => "S2080000xx",
												"name"     => "Telemedicine",
												"qty"      => "1",
												"totPrice" => "20000",
											],
										],
									],
								],
							],
						],
					],
					"txnRequestDateTime" => $this->admedika_datetime,
				],
			];
			
			$body = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
			return $this->ad_post($url, $body);
		}
		
		public function dischargeIP($requestID) {
			$serviceID = 'DISCHARGE_IP';
			$url       = '';
			
			$token = $this->AdToken($serviceID, $requestID);
			
			$payload = [];
			
			$body = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
			return $this->ad_post($url, $body);
		}
		
		public function cancelClaim($requestID, $cardNo, $remark) {
			$serviceID = 'CANCEL_OPEN_CLAIMS_TXN';
			$url       = '';
			
			$token = $this->AdToken($serviceID, $requestID);
			
			$payload = [
				"input" => [
					"tokenAuth"   => $token,
					"serviceID"   => $serviceID,
					"customerID"  => $this->admedika_customerID,
					"requestID"   => $requestID,
					"txnData"     => [
						"cancelOpenClaimTxnRequest" => [
							"cancelOpenClaimTxn" => [
								"terminalID" => $this->admedika_terminalID,
								"cardNo"     => $cardNo,
								"remarks"    => $remark,
							],
						],
					],
					"txnRequestDateTime" => $this->admedika_datetime,
				],
			];
			
			$body = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
			return $this->ad_post($url, $body);
		}
		
		public function getMemberEnrollPlan($requestID, $cardNo, $covID, $condition) {
			$serviceID = 'GET_MEMBER_ENROLLED_PLAN_TC';
			$url       = '';
			
			$token = $this->AdToken($serviceID, $requestID);
			
			$payload = [
				"input" => [
					"tokenAuth"   => $token,
					"serviceID"   => $serviceID,
					"customerID"  => $this->admedika_customerID,
					"requestID"   => $requestID,
					"txnData"     => [
						"getMemberEnrolledPlanTCRequest" => [
							"getMemberEnrolledPlanTC" => [
								"cardNo"                 => $cardNo,
								"covID"                  => $covID,
								"searchForTermCondition" => $condition,
							],
						],
					],
					"txnRequestDateTime" => $this->admedika_datetime,
				],
			];
			
			$body = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
			return $this->ad_post($url, $body);
		}
		
		public function edocsUpload() {
			$serviceID = 'EDOCS_UPLOAD';
			$url       = '';
			
		}
		
		public function checkICD($requestID, $cardNo, $covID, $icdList) {
			$serviceID = 'CHECK_ICD_EXCLUSION';
			$url       = '';
			
			$token = $this->AdToken($serviceID, $requestID);
			
			$payload = [
				"input" => [
					"tokenAuth"   => $token,
					"serviceID"   => $serviceID,
					"customerID"  => $this->admedika_customerID,
					"requestID"   => $requestID,
					"txnData"     => [
						"checkIcdExclusionRequest" => [
							"checkIcdExclusion" => [
								"cardNo"            => $cardNo,
								"covID"             => $covID,
								"diagnosisCodeList" => $icdList, //"A00.0, A01"
							],
						],
					],
					"txnRequestDateTime" => $this->admedika_datetime,
				],
			];
			
			$body = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
			return $this->ad_post($url, $body);
		}
		
		public function checkMemberClaimStatus($requestID, $cardNo) {
			$serviceID = 'CHECK_MEMBER_CLAIM_TXN_STATUS';
			$url       = '';
			
			$token = $this->AdToken($serviceID, $requestID);
			
			$payload = [
				"input" => [
					"tokenAuth"   => $token,
					"serviceID"   => $serviceID,
					"customerID"  => $this->admedika_customerID,
					"requestID"   => $requestID,
					"txnData"     => [
						"checkMemberClaimTxnStatusRequest" => [
							"checkMemberClaimTxnStatus" => [
								"terminalID" => $this->admedika_terminalID,
								"cardNo"     => $cardNo,
								"clID"       => "",
							],
						],
					],
					"txnRequestDateTime" => $this->admedika_datetime,
				],
			];
			
			$body = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
			return $this->ad_post($url, $body);
		}
	
	}