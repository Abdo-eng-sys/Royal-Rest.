<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to Savory Haven API',
        'version' => '1.0.0',
        'status' => 'running'
    ]);
});
