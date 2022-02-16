<?php

namespace Naviisml\IntraApi\Api;

class Wrapper
{
	/**
	 * [$uri description]
	 */
	protected $uri = null;

	/**
	 * [$endpoint description]
	 */
	protected $endpoint = null;

	/**
	 * [$client_id description]
	 */
	protected $client_id = null;

	/**
	 * [$client_secret description]
	 */
	protected $client_secret = null;

	/**
	 * [$headers description]
	 */
	protected $headers = [];

	/**
	 * [$arguments description]
	 */
	protected $arguments = [];

	/**
	 * [$response description]
	 */
	protected $response;

	/**
	 * [headers description]
	 *
	 * @param   array  $headers
	 * @return  IntraController
	 */
	public function headers(array $headers)
	{
		$this->headers = [...$this->headers, ...$headers];
		
		return $this;
	}

	/**
	 * [with description]
	 *
	 * @param   array  $args
	 * @return  IntraController
	 */
	public function with(array $args)
	{
		$this->arguments = [...$this->arguments, ...$args];

		return $this;
	}

	/**
	 * [get description]
	 *
	 * @param   string  $endpoint
	 * @return  IntraController
	 */
	public function get(string $endpoint = null)
	{
		$client = new \GuzzleHttp\Client();

		$this->setEndpoint($endpoint);
		$this->setEndpointArguments($this->arguments);

        $this->response = $client->get($this->getEndpoint(), [
            'headers' => $this->headers,
        ]);
		
		return $this->response;
	}

	/**
	 * [post description]
	 *
	 * @param   string  $endpoint
	 * @return  IntraController
	 */
	public function post(string $endpoint = null)
	{
		$client = new \GuzzleHttp\Client();

		$this->setEndpoint($endpoint);
		
        $this->response = $client->post($this->getEndpoint(), [
			...$this->arguments,
            'headers' => $this->headers,
        ]);
		
		return $this->response;
	}

	/**
	 * [setClientId description]
	 *
	 * @param   string  $client_id  [$client_id description]
	 * @return  [type]              [return description]
	 */
	public function setClientId(string $client_id = null)
	{
		$this->client_id = $client_id;
		
		return $this;
	}

	/**
	 * [setClientSecret description]
	 *
	 * @param   string  $client_secret  [$client_secret description]
	 * @return  [type]                  [return description]
	 */
	public function setClientSecret(string $client_secret = null)
	{
		$this->client_secret = $client_secret;
		
		return $this;
	}

	/**
	 * Return the API url
	 *
	 * @return  string
	 */
	public function getUrl()
	{
		return $this->uri;
	}

	/**
	 * Set the api url
	 *
	 * @param   string $url
	 * @return  IntraController
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
	 * @return  IntraController
	 */
	public function setEndpoint(string $endpoint = null)
	{
		if ($endpoint != NULL)
			$this->endpoint = $endpoint;
			
		return $this;
	}
}
