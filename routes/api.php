<?php

use App\Helpers\SiteConstants;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Auth\ApiLoginController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => SiteConstants::URL_PREFIX_USER_API], function () {
    Route::post('login', [ApiLoginController::class, 'login']);
    Route::post('signup', [ApiLoginController::class, 'signup']);

    Route::get('about-us', [HomeController::class, 'aboutUs']);
    Route::get('contact-us', [HomeController::class, 'contactUs']);
    Route::get('trams-condition', [HomeController::class, 'tramsCondition']);
    Route::get('trams-policy', [HomeController::class, 'tramsPolicy']);
    Route::get('faqs', [HomeController::class, 'faqs']);

    Route::post('contact-us', [HomeController::class, 'contact_us']);
    Route::post('newsletter', [HomeController::class, 'newsletter']);

    // location api
    Route::get('country', [HomeController::class, 'country']);
    Route::get('state/{country_id}', [HomeController::class, 'state']);
    Route::get('cities/{country_id}/{state_id}', [HomeController::class, 'cities']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::match(['get', 'post'], 'profile', [HomeController::class, 'profile']);
    });
});
