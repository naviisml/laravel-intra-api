<?php

namespace Naviisml\IntraApi\Facades;

use Illuminate\Support\Facades\Facade;

class IntraAPI extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
	{
		return 'IntraAPI';
	}
}