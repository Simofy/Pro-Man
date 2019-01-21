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

/*
|--------------------------------------------------------------------------
| Frontend
|--------------------------------------------------------------------------
 */

// Home
Route::name('home')->get('/', 'Front\PostController@index');

Route::post('view/login', function () {
    return view('auth.login');
});

Route::post('view/register', function () {
    return view('auth.register');
});

// Contact
Route::resource('contacts', 'Front\ContactController', ['only' => ['create', 'store']]);

// Posts and comments
Route::prefix('posts')->namespace('Front')->group(function () {
    Route::name('posts.display')->get('{slug}', 'PostController@show');
    Route::name('posts.tag')->get('tag/{tag}', 'PostController@tag');
    Route::name('posts.search')->get('', 'PostController@search');
    Route::name('posts.comments.store')->post('{post}/comments', 'CommentController@store');
    Route::name('posts.comments.comments.store')->post('{post}/comments/{comment}/comments', 'CommentController@store');
    Route::name('posts.comments')->get('{post}/comments/{page}', 'CommentController@comments');
});

Route::resource('comments', 'Front\CommentController', [
    'only' => ['update', 'destroy'],
    'names' => ['destroy' => 'front.comments.destroy'],
]);

Route::name('category')->get('category/{category}', 'Front\PostController@category');

// Authentification
Auth::routes();

/*
|--------------------------------------------------------------------------
| Backend
|--------------------------------------------------------------------------
 */

Route::prefix('admin')->namespace('Back')->group(function () {

    Route::middleware('redac')->group(function () {

        Route::name('admin')->get('/', 'AdminController@index');
        Route::name('register')->get('register', 'AdminController@register');
        Route::post('register',  'RegisterControl@register');

        Route::get('{id}/reset',  function(){
            return view('auth.reset');
        });
        Route::post('{id}/reset',  'AdminController@reset');
        // $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        // $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        // $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        // $this->post('password/reset', 'Auth\ResetPasswordController@reset');

        // Posts
        Route::name('posts.seen')->put('posts/seen/{post}', 'PostController@updateSeen')->middleware('can:manage,post');
        Route::name('posts.active')->put('posts/active/{post}/{status?}', 'PostController@updateActive')->middleware('can:manage,post');
        Route::resource('posts', 'PostController');

        // Notifications
        Route::name('notifications.index')->get('notifications/{user}', 'NotificationController@index');
        Route::name('notifications.update')->put('notifications/{notification}', 'NotificationController@update');

        // Medias
        Route::view('medias', 'back.medias')->name('medias.index');

    });

    Route::middleware('admin')->group(function () {

        // Users
        Route::name('users.seen')->put('users/seen/{user}', 'UserController@updateSeen');
        Route::name('users.valid')->put('users/valid/{user}', 'UserController@updateValid');
        Route::resource('users', 'UserController', ['only' => [
            'index', 'edit', 'update', 'destroy',
        ]]);

        // Categories
        Route::resource('categories', 'CategoryController', ['except' => 'show']);

        // Contacts
        Route::name('contacts.seen')->put('contacts/seen/{contact}', 'ContactController@updateSeen');
        Route::resource('contacts', 'ContactController', ['only' => [
            'index', 'destroy',
        ]]);

        // Comments
        Route::name('comments.seen')->put('comments/seen/{comment}', 'CommentController@updateSeen');
        Route::resource('comments', 'CommentController', ['only' => [
            'index', 'destroy',
        ]]);

        // Settings
        Route::name('settings.edit')->get('settings', 'AdminController@settingsEdit');
        Route::name('settings.update')->put('settings', 'AdminController@settingsUpdate');

    });

});
/*
|--------------------------------------------------------------------------
| Pro-man system
|--------------------------------------------------------------------------
 */
//Route::get('/', 'Pro\\ProController@index');
Route::prefix('app')->namespace('Pro')->group(function () {
    Route::middleware('redacpro')->group(function () {
        Route::name('pro.display')->get('/', 'ProController@index');
        Route::name('pro.project')->get('project/{project}', 'ProController@project');
        Route::name('pro.project')->post('project/{project}/{any}', 'ProController@file')->where('any', '.*');
        Route::name('pro.save')->post('save/{project}/{any}', 'ProController@save')->where('any', '.*');
        Route::name('pro.rename')->post('rename/{project}/{any}', 'ProController@rename')->where('any', '.*');
        Route::name('pro.delete')->post('delete/{project}/{any}', 'ProController@delete')->where('any', '.*');
        Route::name('pro.new')->post('new/{project}', 'ProController@new');
    });
});
