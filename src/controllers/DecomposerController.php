<?php

namespace Lubusin\Decomposer\Controllers;

use App;
use Illuminate\Routing\Controller;

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
                $dependencies = array_key_exists('require', $dependenciesArray) ? $dependenciesArray['require'] : 'No dependencies';

                $packages[] = [
                    'name' => $key,
                    'version' => $value,
                    'dependencies' => $dependencies
                ];
            }
        }

        $laravelEnv = $this->getLaravelEnv($packagesArray);

        $serverEnv = $this->getServerEnv();

        return view('Decomposer::index', compact('packages', 'laravelEnv', 'serverEnv'));
    }

    /**
     * Get Laravel environment details
     * @return array
     */

    private function getLaravelEnv($packagesArray)
    {
        return [
            'version' => App::version(),
            'timezone' => config('app.timezone'),
            'debug_mode' => config('app.debug'),
            'storage_dir_writable' => is_writable(base_path('storage')),
            'cache_dir_writable' => is_writable(base_path('bootstrap/cache')),
            'decomposer_version' => $packagesArray['lubusin/laravel-decomposer'],
            'app_size' => $this->sizeFormat($this->folderSize(base_path()))
        ];
    }

    /**
     * Get PHP/Server environment details
     * @return array
     */

    private function getServerEnv()
    {
        return [
            'version' => phpversion(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'],
            'server_os' => php_uname(),
            'database_connection_name' => config('database.default'),
            'ssl_installed' => $this->checkSslIsInstalled(),
            'cache_driver' => config('cache.default'),
            'session_driver' => config('session.driver'),
            'openssl' => extension_loaded('openssl'),
            'pdo' => extension_loaded('pdo'),
            'mbstring' => extension_loaded('mbstring'),
            'tokenizer' => extension_loaded('tokenizer'),
            'xml' => extension_loaded('xml')
        ];
    }

    /**
     * Check if SSL is installed or not
     * @return boolean
     */

    private function checkSslIsInstalled()
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? true : false;
    }

    /**
     * Get the laravel app's size
     * @return int
     */

    private function folderSize($dir)
    {
        $size = 0;
        foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
            $size += is_file($each) ? filesize($each) : $this->folderSize($each);
        }
        return $size;
    }

    /**
     * Format the app's size in correct units
     * @return string
     */

    private function sizeFormat($bytes)
    {
        $kb = 1024;
        $mb = $kb * 1024;
        $gb = $mb * 1024;
        $tb = $gb * 1024;

        if (($bytes >= 0) && ($bytes < $kb)) {
            return $bytes . ' B';
        } elseif (($bytes >= $kb) && ($bytes < $mb)) {
            return ceil($bytes / $kb) . ' KB';
        } elseif (($bytes >= $mb) && ($bytes < $gb)) {
            return ceil($bytes / $mb) . ' MB';
        } elseif (($bytes >= $gb) && ($bytes < $tb)) {
            return ceil($bytes / $gb) . ' GB';
        } elseif ($bytes >= $tb) {
            return ceil($bytes / $tb) . ' TB';
        } else {
            return $bytes . ' B';
        }
    }
}
