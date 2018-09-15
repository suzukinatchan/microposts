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

Route::get('/', 'MicropostsController@index');

//ユーザ登録機能
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')
->name('signup.get');

Route::post('signup', 'Auth\RegisterController@register')
->name('signup.post');


// ログイン認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

Route::group(['middleware' => 'auth'], function () {
    //リソースのうちのユーザーの一覧表示と詳細表示だけできるようにする
    //ユーザーの削除、編集・更新・新規作成後の保存動作はできない。
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
    //フォロー・アンフォローについての条件
    //ユーザーの詳細画面以下、というURLを定義して、後ろに続くものを
    //以下のgroupの中で定義している。
    Route::group(['prefix' => 'users/{id}'], function () {
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
    });
    
    Route::resource('microposts', 'MicropostsController', ['only' => ['store', 'destroy']]);
    
});