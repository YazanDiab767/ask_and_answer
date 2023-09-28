<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CollegesController;
use App\Models\College;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function () {
    return view('index');
})->name('index');

Route::middleware('auth')->group(function () {

    Route::get('/main', function () {
        return view('main');
    })->name('main');

    Route::prefix('control_panel')->group(function () {
        Route::get('/colleges', function () {
            return view('control_panel.colleges',[
                'colleges' => College::orderBy('id', 'DESC')->get()
            ]);
        })->name('control_panel.colleges');

        Route::get('/courses', function () {
            return view('control_panel.courses');
        })->name('control_panel.courses');

        Route::get('/questions', function () {
            return view('control_panel.questions');
        })->name('control_panel.questions');

        Route::get('/complaints', function () {
            return view('control_panel.complaints');
        })->name('control_panel.complaints');

        Route::resource('/colleges', CollegesController::class)->except([
            'index', 'create', 'edit'
        ]);
    });

});




