<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ScheduleController;

Route::get('/', [ScheduleController::class , 'index'])->name('schedule.index');
Route::get('/book', [ScheduleController::class , 'create'])->name('schedule.create');
Route::post('/book/confirm', [ScheduleController::class , 'confirm'])->name('schedule.confirm');
Route::post('/book', [ScheduleController::class , 'store'])->name('schedule.store');
