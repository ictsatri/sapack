<?php

namespace SatuSehat\Bridging\Oauth;

use SatuSehat\Bridging\SatuSehatCurl;

class Oauth extends SatuSehatCurl
{
	public function SatuSehatToken()
	{
		$req          = $this->SatuSehatHttp->getToken();
		return $req;
	}
}
