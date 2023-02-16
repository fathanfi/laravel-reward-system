<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RewardsController;

Route::get('/users/{user}/rewards', RewardsController::class)->name('users.rewards.index');
