<?php

namespace Naviisml\IntraApi;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class IntraServiceProvider extends ServiceProvider
{
    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'Naviisml\\IntraApi\\Http\\Controllers';

    /**
     * [register description]
     *
     * @return [type] [description]
     */
    public function register()
    {
		//
    }

    /**
     * [boot description]
     *
     * @return [type] [description]
     */
    public function boot()
    {
        $this->handleDatabase( $this->base_dir( 'database/migrations' ) );
        $this->handleConfig( $this->base_dir( 'config' ) );
        $this->handleRoutes();
        $this->handleViews();
    }

    /**
     * [handleDatabase description]
     *
     * @param  [type] $folder [description]
     * @return [type]         [description]
     */
    protected function handleDatabase( $folder )
    {
        $this->loadMigrationsFrom( $folder );

        $this->publishes([
            $folder => database_path( 'migrations' ),
        ], 'migrations');
    }

    /**
     * [handleConfig description]
     *
     * @param  [type] $folder [description]
     * @return [type]         [description]
     */
    protected function handleConfig( $folder )
    {
        $this->publishes([
            $folder => config_path(),
        ], 'config');
    }

    /**
     * [handleRoutes description]
     *
     * @return [type] [description]
     */
    protected function handleRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group( $this->base_dir( 'routes/web.php' ) );

        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group( $this->base_dir( 'routes/api.php' ) );
    }

    /**
     * [handleViews description]
     *
     * @return [type] [description]
     */
    protected function handleViews()
    {
        $this->loadViewsFrom( [
            $this->base_dir( 'resources/views' ),
            $this->base_dir( 'resources/views/pages' ),
        ], 'navel_collections' );
    }

    /**
     * [base_dir description]
     *
     * @param  boolean $dir [description]
     * @return [type]       [description]
     */
    protected function base_dir( $dir = false )
    {
        return __DIR__ . '/../' . $dir ?? '';
    }
}
