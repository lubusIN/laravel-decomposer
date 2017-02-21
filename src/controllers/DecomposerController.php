<?php

namespace Lubusin\Decomposer\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;

class DecomposerController extends Controller
{

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $json = file_get_contents(base_path('composer.json'));
        $composerArray = json_decode($json, true);
        $packagesArray = $composerArray['require'];

        foreach ($packagesArray as $key => $value) {
            if ($key !== 'php') {
                $json2 = file_get_contents(base_path("/vendor/{$key}/composer.json"));
                $dependenciesArray = json_decode($json2, true);
                $dependencies = $dependenciesArray['require'];
                
                $packages[] = [
                    'name' => $key,
                    'version' => $value,
                    'dependencies' => $dependencies
                ];
            }
        }

        return view('Decomposer::index', compact('packages'));
    }
}
