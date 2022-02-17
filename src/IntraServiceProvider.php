<?php

namespace Naviisml\IntraApi;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class IntraServiceProvider extends ServiceProvider
{
    /**
     * [register description]
     *
     * @return [type] [description]
     */
    public function register()
    {
		$this->registerFacades();
    }

    /**
     * [boot description]
     *
     * @return [type] [description]
     */
    public function boot()
    {
        $this->handleDatabase($this->base_dir('database/migrations'));
        $this->handleConfig($this->base_dir('config'));
    }

    /**
     * [handleDatabase description]
     *
     * @param  [type] $folder [description]
     * @return [type]         [description]
     */
    protected function handleDatabase($folder)
    {
        $this->loadMigrationsFrom($folder);

        $this->publishes([
            $folder => database_path('migrations'),
        ], 'migrations');
    }

    /**
     * [handleConfig description]
     *
     * @param  [type] $folder [description]
     * @return [type]         [description]
     */
    protected function handleConfig($folder)
    {
        $this->publishes([
            $folder => config_path(),
        ], 'config');
    }

	/**
	 * [registerFacades description]
	 *
	 * @return  [type]  [return description]
	 */
	protected function registerFacades()
	{
		$this->app->bind('IntraAPI', function() {
			return new IntraAPI;
		});

		$this->app->bind('IntraOAuth', function() {
			return new IntraOAuth;
		});
	}

    /**
     * [base_dir description]
     *
     * @param  boolean $dir [description]
     * @return [type]       [description]
     */
    protected function base_dir($dir = false)
    {
        return __DIR__ . '/../' . $dir ?? '';
    }
}
