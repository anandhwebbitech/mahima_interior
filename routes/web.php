<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MasterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.dashboard');
})->name('dashboard');


Route::get('customer',[AdminController::class ,'BuildingStage'])->name('customer');
Route::get('building_stage',[AdminController::class ,'BuildingStage'])->name('building_stage');
Route::get('project_type',[AdminController::class ,'ProjectType'])->name('project_type');

// web.php
Route::post('/common-store', [MasterController::class, 'store'])->name('common.store');
