<?php

use Illuminate\Http\Request;

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

Route::post('authenticate', 'JWTAuthenticateController@authenticate');
Route::post('register', 'JWTAuthenticateController@register');

Route::group(['middleware' => 'auth:api'], function() {
    Route::resource('items', 'ItemsController');
    Route::resource('purchases', 'PurchasesController');
    Route::resource('types', 'TypesController');

    Route::resource('items/{item}/purchases', 'ItemPurchasesController', ['as' => 'item']);
    Route::resource('purchases/{purchase}/items', 'PurchaseItemsController', ['as' => 'purchase']);

    Route::resource('items/{item}/types', 'ItemTypesController', ['as' => 'item']);
    Route::resource('types/{type}/items', 'TypeItemsController', ['as' => 'type']);
});
