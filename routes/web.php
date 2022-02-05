<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Admin\ProfileController;
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

Auth::routes(['register' => false]);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix('admin')->group(function(){

    Route::get('/profile/create',[App\Http\Controllers\Admin\ProfileController::class, 'create']);
    Route::post('/profile/create',[App\Http\Controllers\Admin\ProfileController::class, 'POST_create']);

    Route::get('/profile/display/{id}',[App\Http\Controllers\Admin\ProfileController::class, 'display']);
    Route::get('/profile/preview/{id}',[App\Http\Controllers\Admin\ProfileController::class, 'preview']);


    Route::get('/profile/update/{id}',[App\Http\Controllers\Admin\ProfileController::class, 'update']);
    Route::post('/profile/update/{id}',[App\Http\Controllers\Admin\ProfileController::class, 'POST_update']);

    Route::get('/profile/list',[App\Http\Controllers\Admin\ProfileController::class, 'list']);
    Route::post('/profile/list',[App\Http\Controllers\Admin\ProfileController::class, 'POST_list']);

    Route::post('/profile/delete',[App\Http\Controllers\Admin\ProfileController::class, 'POST_remove']);
});


Route::get('/profiles',[App\Http\Controllers\ProfileController::class, 'list']);
Route::post('/profiles',[App\Http\Controllers\ProfileController::class, 'POST_list']);   
Route::get('/profile/{id}',[App\Http\Controllers\ProfileController::class, 'display']);
   


Route::get('/cropperjs/cropper.min.js',function(){
    
   
    $response = Response::make(File::get(base_path() . '/node_modules/cropperjs/dist/cropper.min.js'));
    return $response->header('Content-Type', 'text/javascript');

}); 


Route::get('/cropperjs/cropper.min.css',function(){

    $response = Response::make(File::get(base_path() . '/node_modules/cropperjs/dist/cropper.min.css'));
    return $response->header('Content-Type', 'text/css');
    
});


Route::get('/adarna.js',function(){

    $response = Response::make(File::get(base_path() . '/node_modules/adarna/dist/adarna.js'));
    return $response->header('Content-Type', 'text/javascript');
    
});

Route::get('photos/{filename}', function ($filename)
{
    $path = storage_path('app/photos/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::get('homepage/{filename}', function ($filename)
{
    $path = storage_path('app/homepage/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});



Route::get('js/{filename}', function ($filename)
{
    $path = resource_path() ."/js/" . $filename;

    
    if (!File::exists($path)) {
        return abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});