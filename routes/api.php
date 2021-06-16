<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Subscription\SubscriptionController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', LoginController::class);
Route::group(['middleware'=>'auth:api'], function () {
    Route::post('/topics/users/list', [SubscriptionController::class, 'showSubscriptionsFromUser']);
    Route::get('/topics/{topic}/users/list', [SubscriptionController::class, 'showUsersBySubscription']);
});
Route::post('topics/{topic}/subscribe', [SubscriptionController::class, 'subscribeByEmail']);
Route::delete('topics/{topic}/unsubscribe', [SubscriptionController::class, 'unsubscribeFromTopic']);
Route::delete('topics/unsubscribe', [SubscriptionController::class, 'unsubscribeFromAllTopic']);

