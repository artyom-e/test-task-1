<?php

use App\Http\Controllers\Api\SubmissionController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::post('/submit', [SubmissionController::class, 'store'])->name('submit');
});
