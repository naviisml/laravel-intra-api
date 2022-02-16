<?php

namespace Naviisml\IntraApi;

use Naviisml\IntraApi\Api\Wrapper;

class IntraAPI extends Wrapper
{
	/**
	 * [__construct description]
	 *
	 * @return  [type]  [return description]
	 */
	public function __construct()
	{
		$this->setUrl(config('services.intra.url'));
		$this->setClientId(config('services.intra.client_id'));
		$this->setClientSecret(config('services.intra.client_secret'));

		return $this;
	}
}