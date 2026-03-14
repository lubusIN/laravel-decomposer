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

        $packages = Decomposer::getPackagesAndDependencies(array_reverse($composerArray['require']));

        $version = Decomposer::getDecomposerVersion($composerArray, $packages);

        $laravelEnv = Decomposer::getLaravelEnv($version);

        $serverEnv = Decomposer::getServerEnv();

        $serverExtras = Decomposer::getServerExtras();

        $laravelExtras = Decomposer::getLaravelExtras();

        $extraStats = Decomposer::getExtraStats();

        $svgIcons = [
            "composer" => Decomposer::svg('composer', 'h-5'),
            "statusTrue" => Decomposer::svg('status_true', 'h-5'),
            "statusFalse" => Decomposer::svg('status_false', 'h-5'),
            "laravelIcon" => Decomposer::svg('laravel_icon', 'h-5'),
            "serverIcon" => Decomposer::svg('server', 'h-5')
        ];

        $formattedPackages = collect($packages)->map(function ($pkg) {
            return [
                'name' => $pkg['name'],
                'version' => $pkg['version'],
                'dependencies' => is_array($pkg['dependencies']) ? collect($pkg['dependencies'])->map(function ($v, $k) {
                    return ['name' => $k, 'version' => $v];
                })->values() : [['name' => 'N/A', 'version' => $pkg['dependencies']]]
            ];
        })->values();

        return view('Decomposer::app', compact('packages', 'laravelEnv', 'serverEnv', 'extraStats', 'serverExtras', 'laravelExtras', 'formattedPackages', 'svgIcons'));
    }
}
