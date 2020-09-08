<?php

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
Auth::routes();

// HTTP Gets
    Route::get('lang/{locale}', 'LocalizationController@index');

    Route::get('/', 'HomeController@index')->name('home')->middleware('auth');
    Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
    Route::get('/getAccounts', 'BankAccountController@getAccounts')->middleware('auth');
    Route::get('/bankaccounts', 'BankAccountController@index')->middleware('auth');
    Route::get('/bankaccounts/add', 'BankAccountController@addAccount')->middleware('auth');

// HTTP Posts
    Route::post('/tikko/add', 'SentjesController@addTikko')->middleware('auth')->name('tikko.add');
    Route::post('/tikko/delete', 'SentjesController@destroy')->middleware('auth')->name('tikko.delete');
    Route::get('/tikko/overview', 'SentjesController@showTikkos')->middleware('auth')->name('tikko.showTikkos');

    Route::get('/tikko/scheduled', 'EventController@index')->middleware('auth')->name('calender.index');


    Route::get('/tikko/store', 'SentjesController@store')->name('tikko.store');
    Route::post('/tikko/groupStore', 'SentjesController@groupStore')->name('tikko.groupStore');


    Route::post('/payment', 'PaymentController@prepare')->name('prepare');
    Route::post('/preparePayment', 'PaymentController@preparePayment')->name('preparePayment');


    Route::post('/webhook', 'PaymentController@MollieHook')->name('payment.webhook');

// HTTP Resources
    Route::resource('bankaccounts', 'BankAccountController')->middleware('auth');

    Route::resource('tikko', 'SentjesController')->middleware('auth');

    Route::resource('pay', 'PayController')->middleware('auth');

    Route::resource('groups', 'GroupController')->middleware('auth');
    Route::post('groups/delete', 'GroupController@destroy')->middleware('auth')->name('groups.derstroy');

Route::resource('members', 'GroupMemberController')->middleware('auth');
    Route::post('/members/delete', 'SentjesController@addTikko')->middleware('auth')->name('members.delete');

