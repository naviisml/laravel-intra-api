<?php

namespace Naviisml\IntraApi\Facades;

use Illuminate\Support\Facades\Facade;

class IntraOAuth extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
	{
		return 'IntraOAuth';
	}
}