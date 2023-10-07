<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CollegesController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\ComplaintsController;
use App\Http\Controllers\UsersController;

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

    Route::get('/main', function () { return view('main'); })->name('main');

    //colleges
    Route::get('/colleges' , [CollegesController::class, 'showAll'])->name('colleges.showAll');

    //courses
    Route::get('/colleges/show/{college}' , [CollegesController::class, 'showAll'])->name('colleges.show');
    Route::get('/courses/show/{course}' , [CoursesController::class, 'showAll'])->name('courses.show');


    //Control Panel / Dashbaord
    Route::middleware('CheckSupervisor')->group(function () {
        Route::prefix('control_panel')->group(function () {

            //Questions
            Route::get('/questions' , [QuestionsController::class, 'index'])->name('control_panel.questions');
            Route::get('/questions/{question}/get' ,  [QuestionsController::class, 'getQuestion'])->name('control_panel.getQuestion');
            Route::post('/questions/{question}/retrunQuestion' ,  [QuestionsController::class, 'retrunQuestion'])->name('control_panel.retrunQuestion');
            Route::post('/questions/{question}/stop' ,  [QuestionsController::class, 'stopQuestion'])->name('control_panel.stopQuestion');

            //Complaints
            Route::get('/complaints', function () {return view('control_panel.complaints');})->name('control_panel.complaints');

            //Colleges
            Route::resource('/colleges', CollegesController::class)->except(['create', 'edit']);

            //Courses
            Route::resource('/courses', CoursesController::class)->except(['create', 'edit']);
            Route::get('/courses/getCoursesCollege/{college_id}' , [CoursesController::class, 'getCoursesCollege'])->name('courses.getCoursesCollege');
            Route::post('/courses/setResource/{course}' , [CoursesController::class, 'setResource'])->name('courses.setResource');
            Route::delete('/courses/deleteResource/{resource}' , [CoursesController::class, 'deleteResource'])->name('courses.deleteResource');
            Route::get('/courses/getResources/{college_id}' , [CoursesController::class, 'getResources'])->name('courses.getResources');

            //Complaints
            Route::get('/complaints', [ComplaintsController::class , 'index'])->name('control_panel.complaints');
            Route::get('/complaints/getMoreComplaints', [ComplaintsController::class , 'getMoreComplaints'])->name('dashboard.complaints.getMoreComplaints');
            Route::post('/complaints/doneBy/{complaint}', [ComplaintsController::class , 'doneBy'])->name('complaints.doneBy');

            Route::middleware('CheckAdmin')->group(function () {
                //Users
                Route::resource('/users', UsersController::class)->except(['create', 'edit']);
                Route::get('/getMoreUsers',[UsersController::class,'getMoreUsers'] )->name('dashboard.user.getMoreUsers');

                Route::post('stopUser/{user}',[UsersController::class,'stop'])->name('dashboard.user.stop');
                Route::post('restore/{user}', [UsersController::class,'restore'])->name('dashboard.user.restore');
                Route::post('destroy/{user}', [UsersController::class,'destroy'])->name('dashboard.user.destroy');
                Route::get('/filter/users',[UsersController::class,'filter'])->name('dashboard.users.filter');
                Route::put('/users/changeRole/user/{user}/{type}',[UsersController::class,'changeRole'])->name('users.changeRole');
                
                //operations log
                Route::get('operationsLog',[UsersController::class,'operationsLog'])->name('dashboard.operationsLog');
                Route::get('operationsLog/getMore',[UsersController::class,'getMoreOperations'])->name('dashboard.getMoreOperations');
                Route::get('filter/operationsLog', [UsersController::class,'filerLog'])->name('dashboard.filterOperations');
                Route::post('operationsLog/delete/{operation}' , [UsersController::class,'deleteOperation'])->name('dashboard.operationsLog.delete');

                //statistics
                Route::get('/statistics', function () {return view('control_panel.statistics');})->name('control_panel.statistics');
            });

        });
    });

});




