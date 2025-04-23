<?php

namespace Lubusin\Decomposer;

use App;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Decomposer
{
    /**
     * Make Decomposer name as a constant to be used
     * in resolving its version number
     */

    const PACKAGE_NAME = 'lubusin/laravel-decomposer';

    /**
     * Initialise blank arrays for extra stats to be added
     * by app or other package devs
     */

    public static $laravelExtras = [];
    public static $serverExtras = [];
    public static $extraStats = [];

    /**
     * Get the Decomposer system report as a PHP array
     * @return array
     */

    public static function getReportArray()
    {
        $composerArray = self::getComposerArray();
        $packages = self::getPackagesAndDependencies($composerArray['require']);
        $version = self::getDecomposerVersion($composerArray, $packages);

        $reportArray['Server Environment'] = self::getServerEnv();
        $reportArray['Laravel Environment'] = self::getLaravelEnv($version);
        $reportArray['Installed Packages'] = self::getPackagesArray($composerArray['require']);

        empty(self::getExtraStats()) ? '' : $reportArray['Extra Stats'] = self::getExtraStats();

        return $reportArray;
    }

    /**
     * Add Extra stats by app or any other package dev
     * @param $extraStatsArray
     */

    public static function addExtraStats(array $extraStatsArray)
    {
        self::$extraStats = array_merge(self::$extraStats, $extraStatsArray);
    }

    /**
     * Add Laravel specific stats by app or any other package dev
     * @param $serverStatsArray
     */

    public static function addLaravelStats(array $laravelStatsArray)
    {
        self::$laravelExtras = array_merge(self::$laravelExtras, $laravelStatsArray);
    }


    /**
     * Add Server specific stats by app or any other package dev
     * @param $serverStatsArray
     */

    public static function addServerStats(array $serverStatsArray)
    {
        self::$serverExtras = array_merge(self::$serverExtras, $serverStatsArray);
    }

    /**
     * Get the extra stats added by the app or any other package dev
     * @return array
     */

    public static function getExtraStats()
    {
        return self::$extraStats;
    }

    /**
     * Get additional server info added by the app or any other package dev
     * @return array
     */

    public static function getServerExtras()
    {
        return self::$serverExtras;
    }

    /**
     * Get additional laravel info added by the app or any other package dev
     * @return array
     */

    public static function getLaravelExtras()
    {
        return self::$laravelExtras;
    }

    /**
     * Get the Decomposer system report as JSON
     * @return json
     */

    public static function getReportJson()
    {
        return json_encode(self::getReportArray());
    }

    /**
     * Get the Composer file contents as an array
     * @return array
     */

    public static function getComposerArray()
    {
        $json = file_get_contents(base_path('composer.json'));
        return json_decode($json, true);
    }

    /**
     * Get Installed packages & their Dependencies
     *
     * @param $packagesArray
     * @return array
     */

    public static function getPackagesAndDependencies($packagesArray)
    {
        foreach ($packagesArray as $key => $value) {
            $packageFile = base_path("/vendor/{$key}/composer.json");

            if ($key !== 'php' && file_exists($packageFile)) {
                $json2 = file_get_contents($packageFile);
                $dependenciesArray = json_decode($json2, true);
                $dependencies = array_key_exists('require', $dependenciesArray) ? $dependenciesArray['require'] : 'No dependencies';
                $devDependencies = array_key_exists('require-dev', $dependenciesArray) ? $dependenciesArray['require-dev'] : 'No dependencies';

                $packages[] = [
                    'name' => $key,
                    'version' => $value,
                    'dependencies' => $dependencies,
                    'dev-dependencies' => $devDependencies
                ];
            }
        }

        return $packages;
    }

    /**
     * Get Laravel environment details
     *
     * @param $decomposerVersion
     * @return array
     */

    public static function getLaravelEnv($decomposerVersion)
    {
        return array_merge([
            'version' => App::version(),
            'timezone' => config('app.timezone'),
            'debug_mode' => config('app.debug'),
            'storage_dir_writable' => is_writable(base_path('storage')),
            'cache_dir_writable' => is_writable(base_path('bootstrap/cache')),
            'decomposer_version' => $decomposerVersion,
            'app_size' => self::sizeFormat(self::folderSize(base_path()))
        ], self::getLaravelExtras());
    }

    /**
     * Get PHP/Server environment details
     * @return array
     */
    public static function getServerEnv()
    {
        return array_merge([
            'version' => phpversion(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'],
            'server_os' => php_uname(),
            'database_connection_name' => config('database.default'),
            'ssl_installed' => self::checkSslIsInstalled(),
            'cache_driver' => config('cache.default'),
            'session_driver' => config('session.driver'),
            'openssl' => extension_loaded('openssl'),
            'pdo' => extension_loaded('pdo'),
            'mbstring' => extension_loaded('mbstring'),
            'tokenizer' => extension_loaded('tokenizer'),
            'xml' => extension_loaded('xml')
        ], self::getServerExtras());
    }

    /**
     * Get Installed packages & their version numbers as an associative array
     *
     * @param $packagesArray
     * @return array
     */

    private static function getPackagesArray($composerRequireArray)
    {
        $packagesArray = self::getPackagesAndDependencies($composerRequireArray);

        foreach ($packagesArray as $packageArray) {
            $packages[$packageArray['name']] = $packageArray['version'];
        }

        return $packages;
    }

    /**
     * Get current installed Decomposer version
     *
     * @param $composerArray
     * @param $packages
     * @return string
     */

    public static function getDecomposerVersion($composerArray, $packages)
    {
        if (isset($composerArray['require'][self::PACKAGE_NAME])) {
            return $composerArray['require'][self::PACKAGE_NAME];
        }

        if (isset($composerArray['require-dev'][self::PACKAGE_NAME])) {
            return $composerArray['require-dev'][self::PACKAGE_NAME];
        }

        foreach ($packages as $package) {
            if (isset($package['dependencies'][self::PACKAGE_NAME])) {
                return $package['dependencies'][self::PACKAGE_NAME];
            }

            if (isset($package['dev-dependencies'][self::PACKAGE_NAME])) {
                return $package['dev-dependencies'][self::PACKAGE_NAME];
            }
        }

        return 'unknown';
    }

    /**
     * Check if SSL is installed or not
     * @return boolean
     */

    private static function checkSslIsInstalled()
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off');
    }

    /**
     * Get the laravel app's size
     *
     * @param $dir
     * @return int
     */

    private static function folderSize($dir)
    {
        $size = 0;
              $excludedFolders = ['vendor', 'node_modules', 'storage', 'tests', '.git'];

        try {
            $directoryIterator = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
            $iterator = new RecursiveIteratorIterator($directoryIterator);

            foreach ($iterator as $file) {
                // Skip symlinks and check if file
                if (!$file->isFile() || $file->isLink()) continue;

                foreach ($excludedFolders as $excluded) {
                    if (strpos($file->getPathname(), DIRECTORY_SEPARATOR . $excluded . DIRECTORY_SEPARATOR) !== false) {
                        continue 2;
                    }
                }

                $size += $file->getSize();
            }
        } catch (\Throwable $e) {
        }

        return $size;
    }

    /**
     * Format the app's size in correct units
     *
     * @param $bytes
     * @return string
     */

    private static function sizeFormat($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        for ($i = 0; $bytes >= 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Return the svg code from the filename and also adds classes to the svg file.
     * 
     * @param $name
     * @param $class
     * 
     * @return string
     */
    public static function svg($name, $class = '')
    {
        $path = __DIR__ . '/svg/' . $name . ".svg";
        if (!file_exists($path)) return '';
        $svg = file_get_contents($path);
        return str_replace('<svg', "<svg class=\"{$class}\"", $svg);
    }
}
