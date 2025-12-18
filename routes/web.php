<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MasterController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('layouts.dashboard');
// })->name('dashboard');


Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('dashboard',[AdminController::class ,'Dashboard'])->name('dashboard');
Route::get('customer',[AdminController::class ,'Customer'])->name('customer');
Route::get('followup',[AdminController::class ,'Followup'])->name('followup');
Route::get('/follow-up/{id}', [AdminController::class, 'FollowUp'])->name('followup.edit');
Route::get('building_stage',[AdminController::class ,'BuildingStage'])->name('building_stage');
Route::get('project_type',[AdminController::class ,'ProjectType'])->name('project_type');
Route::get('followup_list',[AdminController::class ,'FollowupList'])->name('followup_list');
Route::get('reminder_followup_list',[AdminController::class ,'ReminderFollowupList'])->name('reminder_followup_list');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('menu', [AdminController::class, 'MenuAccess'])->name('menu');

// web.php
Route::post('/common-store', [MasterController::class, 'store'])->name('common.store');
// web.php
Route::get('/project-type/datatable', [MasterController::class, 'datatable'])
    ->name('type.datatable');
Route::get('/building-satge/datatable', [MasterController::class, 'Stagedatatable'])
    ->name('stage.datatable');

Route::get('/common/edit/{type}/{id}', [MasterController::class, 'edit'])
    ->name('common.edit');

Route::post('/common/update/{type}/{id}', [MasterController::class, 'update'])
    ->name('common.update');
Route::delete('/common/delete/{type}/{id}', [MasterController::class, 'destroy'])
    ->name('common.delete');

Route::post('/customer/store', [MasterController::class, 'CustomerStore'])
    ->name('customer.store');
Route::get('customer/datatable', [MasterController::class, 'CustomerDatatable'])->name('customer.datatable');
Route::get('customer/edit/{id}', [MasterController::class, 'CustomerEdit']);
Route::delete('customer/delete/{id}', [MasterController::class, 'CustomerDestroy']);
Route::post('customer/update/{id}', [MasterController::class, 'CustomerUpdate'])->name('customer.update');

Route::any('/followup/store', [MasterController::class, 'FollowupStore'])->name('followup.store');
// web.php
Route::get('/customers/{id}/follow-ups', [MasterController::class, 'getFollowUps'])
     ->name('customers.followups');

Route::get('followup/datatable', [MasterController::class, 'FollowupDatatable'])->name('followup.datatable');
Route::get('reminder/datatable', [MasterController::class, 'ReminderFollowupDatatable'])->name('reminder.datatable');

Route::post('/role-access', [MasterController::class, 'saveRoleAccess'])->name('roleaccesssave');
