<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/links', [App\Http\Controllers\LinksController::class, 'list']);
Route::post('/links', [App\Http\Controllers\LinksController::class, 'store']);

Route::get('/links/{id}', [App\Http\Controllers\LinksController::class, 'link']);

Route::patch('/links/{id}', [App\Http\Controllers\LinksController::class, 'patch']);

Route::delete('/links/{id}', [App\Http\Controllers\LinksController::class, 'delete']);
