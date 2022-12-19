<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CallController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\LicenceController;
use \App\Http\Controllers\HotelController;
use \App\Http\Controllers\GeneralSettingsController;
use \App\Http\Controllers\OptionController;
use \App\Http\Controllers\RoomController;
use \App\Http\Controllers\ProlongationController;
use \App\Http\Controllers\ChoiceController;
use App\Http\Controllers\CommandOfferController;
use \App\Http\Controllers\DefaultLicenceController;
use \App\Http\Controllers\NotificationController;
use \App\Http\Controllers\OfferController;
use \App\Http\Controllers\TypeController;
use \App\Http\Controllers\CommissionController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\DemmandController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\DemmandUserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RequestHotelController;
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

Route::group(['middleware' => ['web']], function () {
    Route::get('google', [AuthController::class, 'google'])->name('google');
    Route::get('google/callback', [AuthController::class, 'googleCallBack']);
});

Route::get('facebook/callback', [AuthController::class, 'facebookCallback']);
Route::get('github/callback', [AuthController::class, 'githubCallBack']);
Route::get('twitter/callback', [AuthController::class, 'twitterCallBack']);


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('loginStandar', [AuthController::class, 'loginStandar']);
Route::post('payment',  [PaymentController::class, 'payment'])->name('payment');
Route::post('registerHotel',  [UserController::class, 'registerHotel'])->name('registerHotel');
Route::delete('users/{id}',  [UserController::class, 'destroy']);
// Reset Password
Route::get('/reset-password', [BaseController::class, 'sendLink'])->name('sendLink');
Route::get('/edit-password/{id}', [BaseController::class, 'editPassword'])->name('editPassword');
Route::post('/updatePassword', [BaseController::class, 'updatePassword'])->name('updatePassword');

/*Route::post('login', [\Laravel\Passport\Http\Controllers\AccessTokenController::class, 'issueToken'])
->middleware(['api-login', 'throttle']);*/

Route::group(['middleware' => ['auth:api']], function () {


    Route::post('/logoutStandar', [AuthController::class, 'logoutStandar'])->name('logout-standar');
    Route::get('qrCode', [BaseController::class, 'getRoomsByQrCode']);
    Route::get('hotelDetails',[BaseController::class, 'getHotelDetailsByQrCode']);
    Route::get('scanQrCode', [RoomController::class, 'scanQrCode']);
    Route::get('commandsList',[CommandController::class, 'commandsList']);
    Route::get('nbrActiveUser', [UserController::class, 'nbrActiveUser']);
    Route::get('topArticles', [CommandController::class, 'topArticles']);
    Route::get('topApiArticles', [CommandController::class, 'topApiArticles']);
    Route::get('topClients', [CommandController::class, 'topClients']);
    Route::get('getActiveOffers', [OfferController::class, 'getActiveOffers']);
    Route::get('getStatistiques', [BaseController::class, 'getStatistiques']);
    Route::get('salesChart', [CommandController::class, 'salesChart']);
    Route::get('salesChartLastWeek', [CommandController::class, 'salesChartLastWeek']);
    Route::get('getRoomsByHotel/{id}', [RoomController::class, 'getRoomsByHotel']);
    Route::get('getLicenseByHotel', [LicenceController::class, 'getLicenseByHotel']);
    Route::get('commands/getData/{id}', [CommandController::class, 'getAllCommandeData']);
    Route::get('getArticlesByCat/{id}', [ArticleController::class, 'getArticlesByCategory']);
    Route::get('commandOffersByClient', [CommandOfferController::class, 'getCommandOffersByClient']);
    Route::get('commandOffers/getData/{id}', [CommandOfferController::class, 'getCommandeOfferData']);
    Route::get('getApiSettings', [GeneralSettingsController::class, 'getApiSettings']);
    Route::get('messages/byConversation/{conversation_id}', [MessageController::class, 'getMessagesByConversation']);
    Route::get('getActiveHotelUsers/{role}', [UserController::class, 'getActiveHotelUsers']);

    Route::post('staff/add', [UserController::class, 'addStaff']);
    Route::put('staff/update', [UserController::class, 'updateStaff']);
    Route::put('users/resetPassword', [UserController::class, 'resetPassStaff']);
    Route::get('users/managers', [UserController::class, 'getHotellomManagers']);
    Route::post('manager/add', [UserController::class, 'addManager']);
    Route::delete('users/{id}',[UserController::class,'destroy']);


    Route::put('linkUserWithHotel', [UserController::class , 'linkUserWithHotel']);

    Route::put('update/profile', [UserController::class, 'updateProfile']);

    Route::apiResource('roles', RoleController::class);
    Route::apiResource('licences', LicenceController::class);
    Route::apiResource('options', OptionController::class);
    Route::apiResource('choices', ChoiceController::class);
    Route::apiResource('defaultLicences', DefaultLicenceController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('rooms', RoomController::class);
    Route::apiResource('prolongations', ProlongationController::class);
    Route::apiResource('hotels', HotelController::class);
    Route::apiResource('shops', ShopController::class);
    Route::apiResource('settings', GeneralSettingsController::class);
    Route::apiResource('types', TypeController::class);
    Route::apiResource('articles', ArticleController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('offers', OfferController::class);
    Route::apiResource('commandOffers', CommandOfferController::class);
    Route::apiResource('ratings', RatingController::class);
    Route::apiResource('notifications',NotificationController::class);
    Route::apiResource('commands', CommandController::class);
    Route::apiResource('commissions', CommissionController::class);
    Route::apiResource('demmands', DemmandController::class);
    Route::apiResource('request_hotel', RequestHotelController::class);
    Route::apiResource('demmandUsers', DemmandUserController::class);
    Route::apiResource('messages', MessageController::class);
    Route::apiResource('conversations', ConversationController::class);
    Route::apiResource('calls', CallController::class);

    Route::post('block',[BlockController::class, 'checkblock']);
});

