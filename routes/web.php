<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Jobs\ConvertCelsius;
use App\Jobs\FindMaxPrime;
use App\Jobs\MakeDiv;
use App\Jobs\MakeSum;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/signin', [AuthController::class, 'signin'])->name('signin');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

Route::get('/primo/{limit}', function ($limit){
    FindMaxPrime::dispatch($limit, auth()->id());
    return 'O cálculo será realizado em fila.';
});

Route::get('/notifications', function(){
    $user = auth()->user();
    foreach($user->unreadNotifications as $notif){
        echo '<h3>' . $notif->data['description'] .  '</h3>';
    }
});

Route::get('/sum/{num1}/{num2}', function ($num1, $num2){
    MakeSum::dispatch($num1, $num2);
    return 'A soma será realizado em fila.';
});

Route::get('/celsius/{farenheit}', function ($farenheit){
    ConvertCelsius::dispatch($farenheit);
    return 'A conversão será realizado em fila.';
});

Route::get('/div/{num1}/{num2}', function ($num1, $num2){
    MakeDiv::dispatch($num1, $num2, auth()->id());
    return 'A divisão será realizado em fila.';
});