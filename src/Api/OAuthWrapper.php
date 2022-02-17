<?php

namespace Naviisml\IntraApi\Api;

class OAuthWrapper extends ApiWrapper
{
	/**
	 * The OAuth url
	 */
	protected $authUrl;

	/**
	 * The token url
	 */
	protected $tokenUrl;

	/**
    * @var string[]
    */
    protected $scopes;

    /**
    * @var string
    */
    protected $scopeSeparator;

	/**
	 * Build and return the OAuth url
	 *
	 * @return  string $endpoint
	 */
	public function buildAuthUrl($state = null)
	{
		if ($state != null)
			$this->with(['state' => $state]);

		// Add the other parameters like: scopes, client_id, client_secret, redirect_uri
		

		return $this->getUrl() . $this->authUrl;
	}
}