<?php

namespace Naviisml\IntraApi;

use Naviisml\IntraApi\Api\OAuthWrapper;

class IntraOAuth extends OAuthWrapper
{
	/**
    * @var string[]
    */
	protected $authUrl = '/oauth/authorize';

	/**
    * @var string[]
    */
	protected $tokenUrl = '/oauth/token';

	/**
    * @var string[]
    */
	protected $redirectUrl = '/api/v1/oauth/intra/callback';

	/**
    * @var string[]
    */
    protected $scopes = [
		'public',
		'profile',
		'projects',
		'tig'
	];

    /**
    * @var string
    */
    protected $scopeSeparator = ' ';
}