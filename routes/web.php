<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    Log::channel('sentry')->info('wlecome page');
    Log::warning('Welcome');
    return view('welcome');
});
