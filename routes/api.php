<?php

use App\Http\Controllers\Api\CoordinateController;
use App\Http\Controllers\Api\KaryawanController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\MqttController;
use App\Http\Controllers\MqttSalmanController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
   return $request->user();
});

Route::resource('karyawan', KaryawanController::class);
Route::get('/users-redis', [UserController::class, 'indexredis'])->name('api.users.redis');
Route::resource('users', UserController::class);
Route::get('/coordinates-redis', [UserController::class, 'indexredis'])->name('api.coordinates.redis');
Route::resource('coordinates', CoordinateController::class);
Route::resource('posts', PostController::class);
Route::get('/posts-redis', [PostController::class, 'indexredis'])->name('api.posts.redis');

Route::post('/mqtt/subscribe', [MqttController::class, 'subscribe']);
Route::post('/mqtt/publish', [MqttController::class, 'publish']);


// Route::post('/mqtt/publish/', [MqttSalmanController::class, 'SendMsgViaMqtt']);
// Route::post('/mqtt/subscribe/', [MqttSalmanController::class, 'SubscribetoTopic']);
// Route::get('/mqtt/publish/{topic}/{message}', [MqttSalmanController::class, 'SendMsgViaMqtt']);
// Route::get('/mqtt/publish/{topic}', [MqttSalmanController::class, 'SubscribetoTopic']);