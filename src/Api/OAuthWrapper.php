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
	protected $userUrl;

	/**
    * @var string[]
    */
    protected $scopes;

    /**
    * @var string
    */
    protected $scopeSeparator;

	protected $access_token;

	protected $refresh_token;

	protected $expires_in;

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
		return $this->getSchemeAndHttpHost() . $this->redirectUrl;
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

	/**
	 * Map the user's data to a object
	 *
	 * @param   array  $user
	 * @return  $user
	 */
	public function mapUserToObject(array $user)
	{
		return $user;
	}

	public function map(array $user)
	{
		$user['user'] = $this->response;
		$user['token'] = $this->access_token;
		$user['expiresIn'] = $this->expires_in;
		$user['refreshToken'] = $this->refresh_token;

		return $user;
	}

	/**
	 * Get the user data
	 *
	 * @param   string  $access_token
	 * @return  json $user
	 */
	public function user()
	{
		$this->setEndpoint($this->userUrl);

		$this->with([
			'client_id' => $this->client_id,
			'client_secret' => $this->client_secret,
		]);

		$this->headers([
			'Authorization' => 'Bearer ' . $this->access_token,
		]);
		
		$this->response = json_decode($this->get()->getBody(), true);

		return $this->mapUserToObject($this->response);
	}
	
	/**
	 * Get the access token from the code
	 *
	 * @param   string  $code
	 * @return  \GuzzleHttp\Client $response
	 */
	public function stateless()
	{
		$this->setEndpoint($this->tokenUrl);

		$this->with([
			'response_type' => 'authorization_code',
			'grant_type' => 'authorization_code',
			'client_id' => $this->client_id,
			'client_secret' => $this->client_secret,
			'redirect_uri' => $this->getRedirectUri(),
			'code' => request()->get('code')
		]);
		
		$this->response = json_decode($this->post()->getBody(), true);
		
		$this->access_token = $this->response['access_token'];
		$this->refresh_token = $this->response['refresh_token'];
		$this->expires_in = $this->response['expires_in'];

		return $this;
	}

	/**
	 * Return the current url and http scheme
	 *
	 * @return  $url
	 */
	protected function getSchemeAndHttpHost()
	{
		$hostname = $_SERVER['HTTP_HOST']; 
		
		if (env('APP_FORCE_HTTPS') != true)
			$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https' ? 'https' : 'http';
		else
			$protocol = 'https';

		return $protocol . '://' . $hostname;
	}

	/**
	 * Set the user's access token
	 *
	 * @param   string  $access_token
	 */
	public function setAccessToken($access_token = null)
	{
		$this->access_token = $access_token;

		return $this;
	}
}