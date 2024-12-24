<?php

use App\Http\Controllers\GalleryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => "galeri"], function () {
    Route::post('update', [GalleryController::class, 'update'])->name('admin.master.galeri.update');
});