<?php

namespace Naviisml\IntraApi\Api;

class ApiWrapper
{
	/**
	 * The API url
	 */
	protected $uri = null;

	/**
	 * The API endpoint
	 */
	protected $endpoint = null;

	/**
	 * The API's client id
	 */
	protected $client_id = null;

	/**
	 * The API's client secret
	 */
	protected $client_secret = null;

	/**
	 * The headers for the request
	 */
	protected $headers = [];

	/**
	 * The arguments for the request
	 */
	protected $arguments = [];

	/**
	 * The response from a API call
	 */
	protected $response;

	/**
	 * Add headers to the request
	 *
	 * @param   array  $headers
	 * @return  ApiWrapper
	 */
	public function headers(array $headers)
	{
		$this->headers = [...$this->headers, ...$headers];
		
		return $this;
	}

	/**
	 * Find the driver configuration
	 *
	 * @param   string  $provider
	 * @return  ApiWrapper
	 */
	public function driver($provider)
	{
		$this->setUrl(config("services.{$provider}.url", null));
		$this->setClientId(config("services.{$provider}.client_id", null));
		$this->setClientSecret(config("services.{$provider}.client_secret", null));

		return $this;
	}

	/**
	 * Add arguments to the API call
	 *
	 * @param   array  $args
	 * @return  ApiWrapper
	 */
	public function with(array $args)
	{
		$this->arguments = [...$this->arguments, ...$args];

		return $this;
	}

	/**
	 * Send a GET call to the endpoint
	 *
	 * @param   string  $endpoint
	 * @return  \GuzzleHttp\Client $response
	 */
	public function get(string $endpoint = null)
	{
		$client = new \GuzzleHttp\Client();

		$this->setEndpoint($endpoint);
		$this->setEndpointArguments($this->arguments);

        $this->response = $client->request('GET', $this->getEndpoint(), [
            'headers' => $this->headers,
        ]);
		
		return $this->response;
	}

	/**
	 * Send a POST call to the endpoint
	 *
	 * @param   string  $endpoint
	 * @return  \GUzzleHttp\Client $response
	 */
	public function post(string $endpoint = null)
	{
		$client = new \GuzzleHttp\Client();

		$this->setEndpoint($endpoint);

        $this->response = $client->request('POST', $this->getEndpoint(), [
			'json' => [...$this->arguments],
            'headers' => $this->headers,
        ]);
		
		return $this->response;
	}

	/**
	 * Set the client id for the API calls
	 *
	 * @param   string  $client_id
	 * @return  ApiWrapper
	 */
	public function setClientId(string $client_id = null)
	{
		$this->client_id = $client_id;
		
		return $this;
	}

	/**
	 * Set the client secret for the API calls
	 *
	 * @param   string  $client_secret
	 * @return  ApiWrapper
	 */
	public function setClientSecret(string $client_secret = null)
	{
		$this->client_secret = $client_secret;
		
		return $this;
	}

	/**
	 * Return the API url
	 *
	 * @return  string $this->uri
	 */
	public function getUrl()
	{
		return $this->uri;
	}

	/**
	 * Set the api url
	 *
	 * @param   string $url
	 * @return  ApiWrapper
	 */
	public function setUrl(string $url = null)
	{
		if ($url != NULL)
			$this->uri = $url;

		return $this;
	}

	/**
	 * Return the api endpoint
	 *
	 * @return  string
	 */
	public function getEndpoint()
	{
		return $this->getUrl() . $this->endpoint;
	}

	/**
	 * Add the arguments to the url
	 *
	 * @param   array  $args
	 * @return  string
	 */
	public function setEndpointArguments(array $args)
	{
		$query = http_build_query($args);

		if ($query)
			$this->endpoint = "{$this->endpoint}?{$query}";
		
		return $this;
	}

	/**
	 * Set the api endpoint
	 *
	 * @param   string  $endpoint
	 * @return  ApiWrapper
	 */
	public function setEndpoint(string $endpoint = null)
	{
		if ($endpoint != NULL)
			$this->endpoint = $endpoint;
			
		return $this;
	}
}
