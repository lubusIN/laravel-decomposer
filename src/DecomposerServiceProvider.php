<?php

namespace Lubusin\Decomposer;

use Illuminate\Support\ServiceProvider;

class DecomposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'Decomposer');
    }
    
    public function register()
    {
		// Don't register anything for now
    }
}
