<?php

use Illuminate\Support\Facades\Route;
use Pashkevich\Wallet\Http\Controllers\Apple\WebhookController;

Route::post(
    'v1/devices/{deviceLibraryIdentifier}/registrations/{passTypeIdentifier}/{serialNumber}',
    [WebhookController::class, 'registerPass'],
)->name('registerPass');

Route::delete(
    'v1/devices/{deviceLibraryIdentifier}/registrations/{passTypeIdentifier}/{serialNumber}',
    [WebhookController::class, 'unregisterPass'],
)->name('unregisterPass');

Route::get(
    'v1/devices/{deviceLibraryIdentifier}/registrations/{passTypeIdentifier}',
    [WebhookController::class, 'getUpdatablePasses'],
)->name('getUpdatablePasses');

Route::get('v1/passes/{passTypeIdentifier}/{serialNumber}', [WebhookController::class, 'getUpdatedPass'])
    ->name('getUpdatedPass');

Route::post('v1/log', [WebhookController::class, 'log'])->name('recordLog');
