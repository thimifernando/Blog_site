<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MyBlogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\SenterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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



Route::get('/', [SenterController::class, 'senter'])->name('senter');
Route::get('/home', [HomeController::class, 'home'])->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('user/add', [AuthController::class, 'create'])->name('user.create'); 

Route::post('/user/store', [AuthController::class, 'store'])->name('user.store');


Route::post('/like', [LikeController::class, 'store'])->name('likes.store');
Route::delete('/like/{id}', [LikeController::class, 'destroy'])->name('likes.destroy');



Route::group(['middleware'=>['auth']],function(){
  
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');    
   Route::get('profile',[ProfileController::class,'index'])->name('profile');
   Route::post('user/update',[AuthController::class,'update'])->name('user.update');
   Route::get('user/edit',[AuthController::class,'edit'])->name('user.edit');
   
   Route::post('/comments/store', [CommentController::class, 'store'])->name('comments.store');
   Route::post('/replies', [ReplyController::class, 'store'])->name('replies.store');



    // Route::get('like/add', [LikeController::class, 'create'])->name('like.create');
    // Route::post('like/store', [LikeController::class, 'store'])->name('like.store');

    Route::get('myblog/', [MyBlogController::class, 'index'])->name('myblog.index');
    Route::get('myblog/add', [MyBlogController::class, 'create'])->name('myblog.create');
    Route::post('myblog/store', [MyBlogController::class, 'store'])->name('myblog.store');
    Route::get('myblog/view', [MyBlogController::class, 'show'])->name('myblog.show');
    Route::get('myblog/edit', [MyBlogController::class, 'edit'])->name('myblog.edit');
    Route::post('myblog/{id}', [MyBlogController::class, 'update'])->name('myblog.update');
    // Route::post('myblog/update', [MyBlogController::class, 'update'])->name('myblog.update');
    Route::get('/myblog/update-status/{id}/{status}', [MyBlogController::class, 'updateStatus'])->name('myblog.updateStatus');

    Route::get('follow', [FollowController::class, 'index'])->name('follow.index');
    Route::get('follow/add', [FollowController::class, 'create'])->name('follow.create');
    Route::post('follow/store', [FollowController::class, 'store'])->name('follow.store');
    Route::delete('/follow/{user}', [FollowController::class, 'destroy'])->name('follow.destroy');
 
    Route::get('myblog/destroy', [MyBlogController::class, 'destroy'])->name('myblog.destroy');

    Route::group(['middleware' => ['auth', 'auth.role:ADMIN']], function () {
        
        Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
        Route::get('blog/add', [BlogController::class, 'create'])->name('blog.create');
        Route::post('blog/store', [BlogController::class, 'store'])->name('blog.store');
        Route::get('blog/view', [BlogController::class, 'show'])->name('blog.show');
        Route::get('blog/edit', [BlogController::class, 'edit'])->name('blog.edit');
        Route::post('blog/status', [BlogController::class, 'status'])->name('blog.status');
        Route::post('blog/update', [BlogController::class, 'update'])->name('blog.update'); 
        Route::get('blog/destroy', [BlogController::class, 'destroy'])->name('blog.destroy');

        Route::get('user', [UserController::class, 'index'])->name('user.index');

       


        // Route::post('/follow/{author}', [FollowController::class, 'followAuthor'])->name('follow.author');


    });

});





