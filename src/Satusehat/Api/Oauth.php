<?php

namespace SatuSehat\Bridging\Api;

use SatuSehat\Bridging\SatuSehatCurl;

class Oauth extends SatuSehatCurl
{
	public function SatuSehatToken()
	{
		$req = $this->SatuSehatHttp->getToken();
		return $req;
	}
}
