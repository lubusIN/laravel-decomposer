<?php

namespace Lubusin\Decomposer;

use Illuminate\Support\ServiceProvider;

class DecomposerServiceProvider extends ServiceProvider
{

    /**
     * Boot up the package. Load the views from the correct directory.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'decomposer');
        $this->publishes([
            $this->getConfigFile() => config_path('decomposer.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            $this->getConfigFile(),
            'decomposer'
        );
    }

    /**
     * @return string
     */
    protected function getConfigFile()
    {
        return __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'decomposer.php';
    }
}
