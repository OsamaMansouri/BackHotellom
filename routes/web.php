<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\ClientController;
use App\Models\Client;

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


Route::get('/', function () {
    return view('welcome');
});

/*testdddfdfdft*/

Route::get('/portailCaptive', function () {
    return view("portail_captive");
});

Route::get('/portail', function () {

    /* $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://172.16.255.254:8002/index.php?zone=vgc');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);

    $dom = new DOMDocument();
    @ $dom->loadHTML($result);

    $h6s = $dom->getElementsByTagName('h6');
    $hotel = 0;
    foreach($h6s as $h6){
        $hotel = intval($h6->textContent);
    } */

    return view("portail", compact('hotel'));
});

Route::get('/hotellom/form', function () {
    return view("hotellom");
})->name('addHotellom');

Route::get('/hotellom/list', function () {
    $clients = Client::where('type', 'hotellom')->orderBy('id', 'DESC')->get();
    return view("listHotellom", compact('clients'));
})->name('listHotellom');

Route::get('/vigon/form', function () {
    return view("vigon");
})->name('addVigon');

Route::get('/vigon/list', function () {
    $clients = Client::where('type', 'vigon')->orderBy('id', 'DESC')->get();
    return view("listVigon", compact('clients'));
})->name('listVigon');

Route::get('/hotellom/{id}/edit', function ($id) {
    $client = Client::where('id', $id)->first();
    return view("hotellom", compact('client'));
})->name('editHotellom');

Route::get('/hotellom/{id}/show', function ($id) {
    $client = Client::where('id', $id)->first();
    return view("hotellomItem", compact('client'));
});

Route::get('/hotellom/{id}/delete', function ($id) {
    Client::destroy($id);
    $clients = Client::where('type', 'hotellom')->orderBy('id', 'DESC')->get();
    return view("listHotellom", compact('clients'));
});

Route::get('/vigon/{id}/show', function ($id) {
    $client = Client::where('id', $id)->first();
    return view("vigonItem", compact('client'));
});

Route::get('/vigon/{id}/delete', function ($id) {
    Client::destroy($id);
    $clients = Client::where('type', 'vigon')->orderBy('id', 'DESC')->get();
    return view("listVigon", compact('clients'));
});
Route::post('/hotellom/form/update/{id}', [ClientController::class, 'update'])->name('updateHotellom');
Route::post('/hotellom/form', [ClientController::class, 'store'])->name('hotellom');

Route::get('qrCode', [BaseController::class, 'getRoomByQrCode']);
Route::get('apkQrCode', [BaseController::class, 'getApkURL']);
Route::get('hotelDetails', [BaseController::class, 'getHotelDetailsByQrCode']);
