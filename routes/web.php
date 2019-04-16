<?php

Route::resource('/home', 'IndexController',
                                      [
                                          'only'  => 'index',
                                          'names' => ['index' => 'home']
                                      ]);


Route::resource('portfolios', 'PortfolioController', ['parameters' => ['portfolios' => 'alias'] ]);

Route::resource('articles', 'ArticlesController', ['parameters' => ['articles' => 'alias']]);

Route::get('articles/cat/{cat_alias?}', ['uses' => 'ArticlesController@index', 'as' => 'articlesCat'])->where('cat_alias', '[\w-]+');

Route::resource('comment', 'CommentController', ['only' => ['store']]);

Route::match(['get', 'post'], '/contacts', ['uses' => 'ContactsController@index', 'as' => 'contacts']);





//*************AUTH***********//
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout');



//**********ADMIN**AREA********//
Route::group(['middleware' => 'web'], function () {

    //****ADMIN**GROUP****//
    Route::group(['as'=>'admin.', 'prefix' => 'admin', 'middleware' => 'auth'], function(){

    //****admin****//
    Route::get('/',['uses' => 'Admin\IndexController@index', 'as' => 'adminIndex']);

    //****admin-articles****//
    Route::resource('/articles', 'Admin\ArticlesController');

    Route::resource('/permissions', 'Admin\PermissionsController');

    Route::resource('/users', 'Admin\UsersController');

    Route::resource('/menus', 'Admin\MenusController');


    });
});


Auth::routes();

