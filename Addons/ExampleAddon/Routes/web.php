<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')
    ->prefix('addons/example-addon')
    ->group(function () {
        // Example addon routes go here.
    });
