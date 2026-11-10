<?php

namespace Lubusin\Decomposer\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Lubusin\Decomposer\DecomposerServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            DecomposerServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'base64:m+p/Gl0mwcBL7xY/npsO30u4m07eX8/59u4i6l6lU1U=');
    }
}
