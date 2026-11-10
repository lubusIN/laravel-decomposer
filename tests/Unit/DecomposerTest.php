<?php

use Lubusin\Decomposer\Decomposer;

beforeEach(function () {
    Decomposer::$extraStats = [];
    Decomposer::$laravelExtras = [];
    Decomposer::$serverExtras = [];
});

it('renders existing svg icons with given css classes', function () {
    $svg = Decomposer::svg('composer', 'h-5 w-5');

    expect($svg)
        ->toBeString()
        ->toContain('<svg class="h-5 w-5"')
        ->toContain('</svg>');
});

it('renders existing svg icons without class when omitted', function () {
    $svg = Decomposer::svg('composer');

    expect($svg)
        ->toBeString()
        ->toContain('<svg')
        ->not->toContain('class=""');
});

it('returns empty string for non-existent svg', function () {
    $svg = Decomposer::svg('non_existent_icon');

    expect($svg)->toBe('');
});

it('can register and retrieve extra stats', function () {
    expect(Decomposer::getExtraStats())->toBeEmpty();

    Decomposer::addExtraStats(['custom_key' => 'custom_value']);

    expect(Decomposer::getExtraStats())
        ->toHaveKey('custom_key', 'custom_value');
});

it('can register and retrieve laravel stats', function () {
    expect(Decomposer::getLaravelExtras())->toBeEmpty();

    Decomposer::addLaravelStats(['laravel_stat' => 'active']);

    expect(Decomposer::getLaravelExtras())
        ->toHaveKey('laravel_stat', 'active');
});

it('can register and retrieve server stats', function () {
    expect(Decomposer::getServerExtras())->toBeEmpty();

    Decomposer::addServerStats(['server_stat' => 'ok']);

    expect(Decomposer::getServerExtras())
        ->toHaveKey('server_stat', 'ok');
});

it('returns server environment details', function () {
    $serverEnv = Decomposer::getServerEnv();

    expect($serverEnv)->toBeArray()
        ->toHaveKeys([
            'version',
            'server_software',
            'server_os',
            'database_connection_name',
            'ssl_installed',
            'cache_driver',
            'session_driver',
            'openssl',
            'pdo',
            'mbstring',
            'tokenizer',
            'xml',
        ]);
});

it('returns laravel environment details', function () {
    $laravelEnv = Decomposer::getLaravelEnv('1.4.0');

    expect($laravelEnv)->toBeArray()
        ->toHaveKeys([
            'version',
            'timezone',
            'debug_mode',
            'storage_dir_writable',
            'cache_dir_writable',
            'decomposer_version',
            'app_size',
        ])
        ->and($laravelEnv['decomposer_version'])->toBe('1.4.0');
});

it('generates report array and json', function () {
    $reportArray = Decomposer::getReportArray();

    expect($reportArray)->toBeArray()
        ->toHaveKeys([
            'Server Environment',
            'Laravel Environment',
            'Installed Packages',
        ]);

    $reportJson = Decomposer::getReportJson();
    expect($reportJson)->toBeJson();

    $decoded = json_decode($reportJson, true);
    expect($decoded)->toHaveKeys([
        'Server Environment',
        'Laravel Environment',
        'Installed Packages',
    ]);
});

it('includes extra stats in report when provided', function () {
    Decomposer::addExtraStats(['Cache Hit Rate' => '98%']);

    $report = Decomposer::getReportArray();

    expect($report)->toHaveKey('Extra Stats')
        ->and($report['Extra Stats'])->toHaveKey('Cache Hit Rate', '98%');
});

it('safely handles empty packages and dependencies', function () {
    $packages = Decomposer::getPackagesAndDependencies([]);
    expect($packages)->toBeArray()->toBeEmpty();

    $packagesWithPhp = Decomposer::getPackagesAndDependencies(['php' => '^8.3']);
    expect($packagesWithPhp)->toBeArray()->toBeEmpty();
});

it('returns unknown when decomposer version cannot be detected', function () {
    $version = Decomposer::getDecomposerVersion([], []);
    expect($version)->toBe('unknown');
});
