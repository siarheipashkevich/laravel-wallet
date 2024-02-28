<?php

use Illuminate\Support\Facades\Route;
use Pashkevich\Wallet\Http\Controllers\Apple\AppleController;

Route::group(['as' => 'wallet.apple.'], function () {
    Route::post('v1/log', [AppleController::class, 'log'])->name('recordLog');

    Route::get(
        'v1/devices/{deviceLibraryIdentifier}/registrations/{passTypeIdentifier}',
        [AppleController::class, 'getUpdatablePasses'],
    )->name('getUpdatablePasses');

    Route::get('v1/passes/{passTypeIdentifier}/{serialNumber}', [AppleController::class, 'getUpdatedPass'])
        ->name('getUpdatedPass');

    Route::post(
        'v1/devices/{deviceLibraryIdentifier}/registrations/{passTypeIdentifier}/{serialNumber}',
        [AppleController::class, 'registerPass'],
    )->name('registerPass');

    Route::delete(
        'v1/devices/{deviceLibraryIdentifier}/registrations/{passTypeIdentifier}/{serialNumber}',
        [AppleController::class, 'unregisterPass'],
    )->name('unregisterPass');
});
