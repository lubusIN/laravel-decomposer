<?php

use Illuminate\Support\Facades\Route;
use Lubusin\Decomposer\Controllers\DecomposerController;

beforeEach(function () {
    Route::get('decompose', [DecomposerController::class, 'index']);
});

it('renders the decomposer dashboard view', function () {
    $response = $this->get('decompose');

    $response->assertOk();
    $response->assertViewIs('Decomposer::app');
    $response->assertViewHasAll([
        'packages',
        'laravelEnv',
        'serverEnv',
        'extraStats',
        'serverExtras',
        'laravelExtras',
        'formattedPackages',
        'svgIcons',
    ]);
});
