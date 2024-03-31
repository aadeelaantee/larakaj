<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\Admin\StoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\LdManagerController;
use App\Http\Controllers\Admin\LangCodeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('before.boot')->group(function () {

    /*
    |---------------------------------------------------------------------------
    | Home routes
    |---------------------------------------------------------------------------
    |
    | '/'                => homepage without language code
    | '/{language_code}' => homepage with language code.
    |
    */

    Route::get('/', [IndexController::class, 'index'])->name('root');
    Route::get('/{langCode:name?}', [IndexController::class, 'index'])->name('home');

    Route::prefix('/{langCode:name}')->group(function () {

        /*
        |-----------------------------------------------------------------------
        | Guest Routes
        |-----------------------------------------------------------------------
        |
        | This routes are protected with 'guest' middleware. 
        | For access to this routes user MUST NOT BE AUTHENTICATED.
        |
        */

        Route::middleware(['guest'])->group(function () {
            Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])
                ->name('login');

            Route::match(['get', 'post'], '/register', [AuthController::class, 'register'])
                ->name('register');

            Route::match(['get', 'post'], '/password/forget', [PasswordController::class, 'forget'])
                ->name('password.forget');

            Route::match(['get', 'post'], '/password/reset/{token}/{email}', [PasswordController::class, 'reset'])
                ->name('password.reset');
        });

        /*
        |-----------------------------------------------------------------------
        | Front routes
        |-----------------------------------------------------------------------
        |
        | These routes are available for every request and are not protected with 'auth'
        | or 'guest' middlewares.
        |
        */

        Route::match(['get', 'post'], '/post/{post:slug}', [IndexController::class, 'post'])
            ->name('post');

        Route::get('/profile/{user:username}', [IndexController::class, 'profile'])
            ->name('profile')
            ->withoutScopedBindings();

        Route::get('/tag/{tag:name}', [IndexController::class, 'tag'])
            ->name('tag')
            ->withoutScopedBindings();

        Route::get('/author/{user:username}', [IndexController::class, 'author'])
            ->name('author')
            ->withoutScopedBindings();

        /*
        |-----------------------------------------------------------------------
        | Protected Roues
        |-----------------------------------------------------------------------
        |
        | This routes are protected with 'auth' middleware.
        |
        */

        Route::middleware(['auth'])->group(function () {
            Route::get('/logout', [AuthController::class, 'logout'])
                ->name('logout');

            Route::get('/verification/notice', [VerificationController::class, 'notice'])
                ->name('verification.notice');

            Route::post('/verification/resend', [VerificationController::class, 'resend'])
                ->middleware(['throttle:6,1'])
                ->name('verification.resend');

            Route::get('verification/verify/{id}/{hash}', [VerificationController::class, 'verify'])
                ->middleware(['signed'])
                ->name('verification.verify');

            /*
            |-------------------------------------------------------------------
            | Protected Routes with Prefixed URL and Name
            |-------------------------------------------------------------------
            |
            | These routes are prefixed with 'admin/' in url and 'admin.'
            | in route names.
            |
            */

            Route::prefix('admin')->name('admin.')->group(function () {
            	Route::get('/stories', [StoryController::class, 'index'])
                    ->name('stories.index');

                Route::post('/stories', [StoryController::class, 'store'])
                    ->name('stories.store');

            	Route::get('/stories/{story:id}/edit', [StoryController::class, 'edit'])
                    ->name('stories.edit');

                Route::patch('/stories/{story}', [StoryController::class, 'update'])
                    ->name('stories.update');

            	Route::get('/posts', [PostController::class, 'index'])
                    ->name('posts.index');

            	Route::get('/posts/{post:id}/edit', [PostController::class, 'edit'])
                    ->name('posts.edit');

                Route::patch('/posts/{post:id}/update', [PostController::class, 'update'])
                    ->name('posts.update');

                Route::get('/comments', [CommentController::class, 'index'])
                    ->name('comments.index');

                Route::get('comments/{comment:id}/activate', [CommentController::class, 'activate'])
                    ->name('comments.activate');

                Route::get('comments/{comment:id}/delete', [CommentController::class, 'delete'])
                    ->name('comments.delete');

            	Route::get('/ldmanager', [LdManagerController::class, 'index'])
                    ->name('ldmanager.index');

                Route::post('/ldmanager/store-category', [LdManagerController::class, 'storeCategory'])
                    ->name('ldmanager.store_category');

                Route::get('/ldmanager/{ldCategory:id}', [LdManagerController::class, 'category'])
                    ->name('ldmanager.category');

                Route::get('/ldmanager/{ldCategory:id}/edit-category', [LdManagerController::class, 'editCategory'])
                    ->name('ldmanager.edit_category');

                Route::post('/ldmanager/{ldCategory:id}/store-link', [LdManagerController::class, 'storeLink'])
                    ->name('ldmanager.store_link');

                Route::get('/ldmanager/{ldLink:id}/destroy-link/', [LdManagerController::class, 'destroyLink'])
                    ->name('ldmanager.destroy_link');

                Route::get('/ldmanager/{ldLink:id}/edit-link', [LdManagerController::class, 'editLink'])
                    ->name('ldmanager.edit_link');

                Route::patch('/ldmanager/{ldLink:id}/update-link', [LdManagerController::class, 'updateLink'])
                    ->name('ldmanager.update_link');

                Route::patch('/ldmanager/update-category/{ldCategory:id}', [LdManagerController::class, 'updateCategory'])
                    ->name('ldmanager.update_category');

            	Route::get('/users', [UserController::class, 'index'])
                    ->name('users.index');

                /*
                |---------------------------------------------------------------
                | ↓ Implicitly ->withoutScopedBindings();
                |---------------------------------------------------------------
                */
                
            	Route::get('/users/{user}/edit', [UserController::class, 'edit'])
                    ->name('users.edit');

                Route::patch('/users/{user}', [UserController::class, 'update'])
                    ->name('users.update');

                Route::get('/users/{user}/password', [UserController::class, 'password'])
                    ->name('users.password');

                Route::patch('/users/{user}/update-password', [UserController::class, 'updatePassword'])
                    ->name('users.update_password');

                /*
                |---------------------------------------------------------------
                | ꜛ End
                |---------------------------------------------------------------
                */

                Route::get('/lang-codes', [LangCodeController::class, 'index'])
                    ->name('lang_codes.index');

                Route::post('/lang-codes', [LangCodeController::class, 'store'])
                    ->name('lang_codes.store');

                Route::get('/lang-codes/{lc}/edit', [LangCodeController::class, 'edit'])
                    ->name('lang_codes.edit');

                Route::patch('/lang-codes/{lc}', [LangCodeController::class, 'update'])
                    ->name('lang_codes.update');
            });
        });
    });
});
