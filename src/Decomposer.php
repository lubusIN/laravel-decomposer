<?php

namespace Lubusin\Decomposer;

use Illuminate\Support\Facades\App;
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
        $requireArray = $composerArray['require'] ?? [];
        $packages = self::getPackagesAndDependencies($requireArray);
        $version = self::getDecomposerVersion($composerArray, $packages);

        $reportArray = [
            'Server Environment' => self::getServerEnv(),
            'Laravel Environment' => self::getLaravelEnv($version),
            'Installed Packages' => self::getPackagesArray($requireArray),
        ];

        $extraStats = self::getExtraStats();
        if (!empty($extraStats)) {
            $reportArray['Extra Stats'] = $extraStats;
        }

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
     * @param $laravelStatsArray
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
     * @return string
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
        $path = base_path('composer.json');
        if (!file_exists($path)) {
            return [];
        }

        $json = @file_get_contents($path);
        if (!is_string($json)) {
            return [];
        }

        $decoded = json_decode($json, true);
        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Get Installed packages & their Dependencies
     *
     * @param $packagesArray
     * @return array
     */
    public static function getPackagesAndDependencies($packagesArray)
    {
        $packageLockDetails = [];
        $lockPath = base_path('composer.lock');

        if (file_exists($lockPath)) {
            $lockContent = @file_get_contents($lockPath);
            $lockFile = is_string($lockContent) ? json_decode($lockContent) : null;

            if ($lockFile && is_object($lockFile)) {
                if (!empty($lockFile->packages) && is_iterable($lockFile->packages)) {
                    foreach ($lockFile->packages as $package) {
                        $packageLockDetails[$package->name] = $package;
                    }
                }

                if (!empty($lockFile->{'packages-dev'}) && is_iterable($lockFile->{'packages-dev'})) {
                    foreach ($lockFile->{'packages-dev'} as $package) {
                        $packageLockDetails[$package->name] = $package;
                    }
                }
            }
        }

        $packages = [];
        if (!is_iterable($packagesArray)) {
            return $packages;
        }

        foreach ($packagesArray as $key => $value) {
            $packageFile = base_path("/vendor/{$key}/composer.json");

            if ($key !== 'php' && file_exists($packageFile)) {
                $json = @file_get_contents($packageFile);
                $dependenciesArray = is_string($json) ? json_decode($json, true) : null;

                $dependencies = is_array($dependenciesArray) && array_key_exists('require', $dependenciesArray)
                    ? $dependenciesArray['require']
                    : 'No dependencies';

                $devDependencies = is_array($dependenciesArray) && array_key_exists('require-dev', $dependenciesArray)
                    ? $dependenciesArray['require-dev']
                    : 'No dependencies';

                $packages[] = [
                    'name' => $key,
                    'version' => $value,
                    'dependencies' => $dependencies,
                    'dev-dependencies' => $devDependencies,
                    'version-installed' => isset($packageLockDetails[$key]->version) ? $packageLockDetails[$key]->version : '',
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
            'app_size' => self::sizeFormat(self::folderSize(base_path())),
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
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? '',
            'server_os' => php_uname(),
            'database_connection_name' => config('database.default'),
            'ssl_installed' => self::checkSslIsInstalled(),
            'cache_driver' => config('cache.default'),
            'session_driver' => config('session.driver'),
            'openssl' => extension_loaded('openssl'),
            'pdo' => extension_loaded('pdo'),
            'mbstring' => extension_loaded('mbstring'),
            'tokenizer' => extension_loaded('tokenizer'),
            'xml' => extension_loaded('xml'),
        ], self::getServerExtras());
    }

    /**
     * Get Installed packages & their version numbers as an associative array
     *
     * @param $composerRequireArray
     * @return array
     */
    private static function getPackagesArray($composerRequireArray)
    {
        $packagesArray = self::getPackagesAndDependencies($composerRequireArray);

        $packages = [];
        if (is_iterable($packagesArray)) {
            foreach ($packagesArray as $packageArray) {
                if (isset($packageArray['name'], $packageArray['version'])) {
                    $packages[$packageArray['name']] = $packageArray['version'];
                }
            }
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

        if (is_iterable($packages)) {
            foreach ($packages as $package) {
                if (isset($package['dependencies'][self::PACKAGE_NAME])) {
                    return $package['dependencies'][self::PACKAGE_NAME];
                }

                if (isset($package['dev-dependencies'][self::PACKAGE_NAME])) {
                    return $package['dev-dependencies'][self::PACKAGE_NAME];
                }
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
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
    }

    /**
     * Get the laravel app's size
     *
     * @param $dir
     * @return int
     */
    private static function folderSize($dir)
    {
        if (!is_dir($dir)) {
            return 0;
        }

        $size = 0;
        $excludedFolders = (array) config('decomposer.exclude_folders', [
            'vendor',
            'node_modules',
            'storage',
            'tests',
            '.git',
        ]);

        try {
            $directoryIterator = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
            $iterator = new RecursiveIteratorIterator($directoryIterator);

            foreach ($iterator as $file) {
                // Skip symlinks and check if file
                if (!$file->isFile() || $file->isLink()) {
                    continue;
                }

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
     * @return string
     */
    public static function svg($name, $class = '')
    {
        $path = __DIR__ . '/svg/' . $name . '.svg';
        if (!file_exists($path)) {
            return '';
        }

        $svg = file_get_contents($path);

        return $class !== ''
            ? str_replace('<svg', "<svg class=\"{$class}\"", $svg)
            : $svg;
    }
}
