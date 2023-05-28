<?php

use PhpMqtt\Client\Facades\MQTT;
use PhpMqtt\Client\Message;
use App\Events\HelloEvent;
use App\Events\PlaygroundEvent;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthOtpController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FirebaseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MqttController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdmin;
use App\Models\User;
use App\Websockets\SocketHandler\UpdatePostSocketHandler;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('home');
    Route::get('/logs-list', [HomeController::class, 'logs_list'])->name('log.index');
    Route::resource('/karyawan', KaryawanController::class);
    Route::get('/api-test', [ApiController::class, 'index'])->name('api.index');

    Route::controller(MapController::class)->group(function() {
        Route::get('/map', 'index')->name('map.index');
        Route::post('/map', 'storeCoordinate')->name('map.coordinateStore');
        Route::get('/coordinates/json', 'json')->name('map.json');
    });

    Route::controller(ChatController::class)->group(function() {
        Route::get('/chat', 'index')->name('chat.index');
        Route::post('/chat-message', 'store')->name('chat.store');
    });

    Route::get('/posts/get', [PostController::class, 'ajax'])->name('posts.ajax');
    Route::resource('/posts', PostController::class);
});

Route::get('/send-event', function () {
    $text = 'Hallo ini event';
    // \event(new PlaygroundEvent());
    broadcast(new HelloEvent($text));
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/users/grid', [UserController::class, 'grid'])->name('users.grid');
    Route::resource('/users', UserController::class);
    Route::get('/users/get', [UserController::class, 'ajax'])->name('users.ajax');
});

require __DIR__ . '/auth.php';

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/loker/{loker}', [HomeController::class, 'show_loker'])->name('loker.detail');
// Route::get('/message', [MessageController::class, 'index'])->name('message.index'); 
Route::resource('/message', MessageController::class);
Route::get('/otp-phone', [FirebaseController::class, 'index'])->name('firebase.index');

Route::controller(AuthOtpController::class)->group(function () {
    Route::get('/otp/login', 'login')->name('otp.login');
});

Route::get('/redis', function () {
    $p = Redis::incr('p');
    return $p;
});

Route::get('/ws', function () {
    return 'websocket';
});

Route::get('/rd', function () {
    // Cache::set('users', ['user', 'ronaldo']);
    // Cache::clear('users');

    // $users = Cache::get('users');
    // dd($users);
});

// WebSocketsRouter::webSocket('/socket/update-post', UpdatePostSocketHandler::class);

// Route::get('/publish', function () {
//     $message = 'Hi';
//     MQTT::publish('chatapp', 'Hllo');
//     return "Pesan MQTT dipublikasikan.";
// });

// Route::post('/subscribe', [MqttController::class, 'subscribe']);
// Route::post('/publish', [MqttController::class, 'publish']);