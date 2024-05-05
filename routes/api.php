<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/albums', [\App\Http\Controllers\ApiController::class, 'getAlbums']);
});
