<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::post('/orders/store-external', [OrderController::class, 'storeExternal']);


Route::group(['middleware' => 'auth:sanctum'], function () {
  Route::get('/user', [LoginController::class, 'userInfo']);
  Route::get('/user/reports', [LoginController::class, 'userReports']);

  Route::get('/users', [UserController::class, 'index']);
  Route::post('/users', [UserController::class, 'store']);
  Route::post('/users/{user}', [UserController::class, 'update']);
  Route::delete('/users/{user}', [UserController::class, 'destroy']);

  Route::get('/orders', [OrderController::class, 'index']);
  Route::post('/orders', [OrderController::class, 'storeOrUpdate']);
  Route::post('/orders/bulk-update', [OrderController::class, 'bulkUpdate']);
  Route::post('/orders/bulk-delete', [OrderController::class, 'bulkDelete']);
  Route::post('/orders/{order}', [OrderController::class, 'storeOrUpdate']);
  Route::delete('/orders/{order}', [OrderController::class, 'destroy']);
  Route::get('/orders/report/{report}/', [OrderController::class, 'reportOrders']);

  Route::get('/stores', [StoreController::class, 'index']);
  Route::post('/stores', [StoreController::class, 'storeOrUpdate']);
  Route::post('/stores/{store}', [StoreController::class, 'storeOrUpdate']);
  Route::delete('/stores/{store}', [StoreController::class, 'destroy']);

  Route::get('/reports', [ReportController::class, 'index']);
  Route::post('/reports', [ReportController::class, 'storeOrUpdate']);
  Route::post('/reports/{report}', [ReportController::class, 'storeOrUpdate']);
  Route::delete('/reports/{report}', [ReportController::class, 'destroy']);
});