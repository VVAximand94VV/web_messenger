<?php

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


Route::group(['prefix' => 'client'], function(){

    Route::group(['middleware' => 'auth:sanctum'], function(){

        Route::group(['prefix' => 'profile/{user}'], function(){
            Route::post('/profile-update', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'update']);
            Route::post('/edit-avatar', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'editAvatar']);
            Route::get('/info', [\App\Http\Controllers\Api\Profile\ProfileController::class, 'userInfo']);
        });


        Route::group(['prefix' => 'chat/{user}'], function () {
            Route::get('/', [\App\Http\Controllers\Api\Chat\ChatController::class, 'index']);
            Route::get('/{chat}', [\App\Http\Controllers\Api\Chat\ChatController::class, 'show']);
            Route::post('/store', [\App\Http\Controllers\Api\Chat\ChatController::class, 'store']);
        });

        Route::group(['prefix' => 'contacts/{user}'], function () {
            Route::get('/', [\App\Http\Controllers\Api\Contact\ContactController::class, 'index']);
            Route::post('/search', [\App\Http\Controllers\Api\Contact\ContactController::class, 'search']);
        });

        Route::group(['prefix' => 'message/{chat}'], function () {
            Route::post('/store', [\App\Http\Controllers\Api\Message\MessageController::class, 'store']);
            Route::post('/{user}/read', [\App\Http\Controllers\Api\Message\MessageController::class, 'readMessages']);
            Route::post('/{user}/types', [\App\Http\Controllers\Api\Message\MessageController::class, 'userTypes']);
        });

    });

});

Route::group(['prefix' => 'auth'], function(){

    Route::post('/register', [\App\Http\Controllers\Api\Auth\RegisterController::class, 'index']);
    Route::post('/login', [\App\Http\Controllers\Api\Auth\LoginController::class, 'index']);
    Route::post('/forgot-password', [\App\Http\Controllers\Api\Auth\ForgotPasswordController::class, 'index']);
    Route::post('/reset-password', [\App\Http\Controllers\Api\Auth\ResetPasswordController::class, 'index']);
    Route::get('/resend-verify-mail', [\App\Http\Controllers\Api\Auth\VerificationController::class, 'sendVerificationEmail']);
    Route::get('/verify-mail/{id}/{hash}', [\App\Http\Controllers\Api\Auth\VerificationController::class, 'verify'])->name('verify.mail');

    Route::group(['middleware'=>'auth:sanctum'], function(){
        Route::post('/logout', [\App\Http\Controllers\Api\Auth\LogoutController::class, 'index']);
    });

});






