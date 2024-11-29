<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WhoisController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/v1/api/whois', [WhoisController::class, 'query']);