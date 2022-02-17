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

		$query = http_build_query([
			'response_type' => 'code',
			'client_id' => $this->client_id,
			'client_secret' => $this->client_secret,
			'redirect_uri' => $this->getRedirectUri(),
			'scope' => $this->parseScopes(),
			'state' => $state,
		]);

		return $this->getAuthUrl() . '?' . $query;
	}

	/**
	 * Implode the $scopes array with $scopeSeparator
	 *
	 * @return  array $scopes
	 */
	protected function parseScopes()
	{
		return implode($this->scopeSeparator, $this->scopes);
	}

	/**
	 * Return the redirect_uri
	 *
	 * @return  string $redirect_uri
	 */
	public function getRedirectUri()
	{
		return request()->getSchemeAndHttpHost() . $this->redirectUrl;
	}

	/**
	 * Return the authUrl
	 *
	 * @return  string $authUrl
	 */
	public function getAuthUrl()
	{
		return $this->getUrl() . $this->authUrl;
	}
}