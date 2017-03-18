<?php

namespace Lubusin\Decomposer\Controllers;

use Lubusin\Decomposer\Decomposer;
use Illuminate\Routing\Controller;

class DecomposerController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $composerArray = Decomposer::getComposerArray();

        $packages = Decomposer::getPackagesAndDependencies($composerArray['require']);

        $version = Decomposer::getDecomposerVersion($composerArray, $packages);

        $laravelEnv = Decomposer::getLaravelEnv($version);

        $serverEnv = Decomposer::getServerEnv();

        return view('Decomposer::index', compact('packages', 'laravelEnv', 'serverEnv'));
    }
}
