<?php

namespace Lubusin\Decomposer;

use App;

class Decomposer
{
    const PACKAGE_NAME = 'lubusin/laravel-decomposer';

    /**
     * Get the Decomposer system report as an array
     * @return array
     */

    public static function getReportArray()
    {
        $composerArray = self::getComposerArray();
        $packages = self::getPackagesAndDependencies($composerArray['require']);
        $version = self::getDecomposerVersion($composerArray, $packages);

        return [
            'Server Environment' => self::getServerEnv(),
            'Laravel Environment' => self::getLaravelEnv($version),
            'Installed Packages' => self::getPackagesArray($composerArray['require'])
        ];
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
        return [
            'version' => App::version(),
            'timezone' => config('app.timezone'),
            'debug_mode' => config('app.debug'),
            'storage_dir_writable' => is_writable(base_path('storage')),
            'cache_dir_writable' => is_writable(base_path('bootstrap/cache')),
            'decomposer_version' => $decomposerVersion,
            'app_size' => self::sizeFormat(self::folderSize(base_path()))
        ];
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
     * Get PHP/Server environment details
     * @return array
     */

    public static function getServerEnv()
    {
        return [
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
        ];
    }

    /**
     * Get Installed packages & their version numbers as an associative array
     *
     * @param $packagesArray
     * @return array
     */

    private static function getPackagesArray($packagesArray)
    {
        foreach ($packagesArray as $packageArray) {
            $packages[$packageArray['name']] = $packageArray['version'];
        }

        return $packages;
    }

    /**
     * Check if SSL is installed or not
     * @return boolean
     */

    private static function checkSslIsInstalled()
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? true : false;
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
        foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
            $size += is_file($each) ? filesize($each) : self::folderSize($each);
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
