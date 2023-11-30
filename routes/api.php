<?php

use App\Http\Controllers\API\VexCreatePdf;
use App\Http\Controllers\API\VexLogistica;
use App\Http\Controllers\API\VexWebHook;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/vextrans/{placa?}', [VexLogistica::class, 'index']);
Route::get('/webhook', [VexWebHook::class, 'importacao']);
Route::get('/createPDF', [VexCreatePdf::class, 'getPDF']);
