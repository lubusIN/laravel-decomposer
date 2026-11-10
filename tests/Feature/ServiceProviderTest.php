<?php

use Illuminate\Support\ServiceProvider;
use Lubusin\Decomposer\DecomposerServiceProvider;

it('merges default decomposer configuration', function () {
    expect(config('decomposer.exclude_folders'))->toBeArray()
        ->toContain('vendor', 'node_modules', 'storage', 'tests', '.git');
});

it('registers decomposer view namespace', function () {
    expect(view()->exists('Decomposer::app'))->toBeTrue()
        ->and(view()->exists('Decomposer::index'))->toBeTrue();
});

it('registers publishable groups', function () {
    $publishableGroups = ServiceProvider::$publishGroups;

    expect($publishableGroups)->toHaveKeys(['DecomposerConfig', 'DecomposerAssets']);
});
