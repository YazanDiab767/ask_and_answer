<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CollegesController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\ComplaintsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\NotificationsController;


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
    Route::get('/getNewQuestions', [QuestionsController::class,'showLastQuestions']);

    //colleges
    Route::get('/colleges' , [CollegesController::class, 'showAll'])->name('colleges.showAll');

    //courses
    Route::get('/colleges/{college}' , [CollegesController::class, 'show'])->name('colleges.college');
    Route::get('/courses/{course}' , [CoursesController::class, 'show'])->name('courses.course');
    Route::post('/courses/addUserCourses',[CoursesController::class,'addUserCourses'])->name('courses.addUserCourses');
    Route::post('/control_panel/courses/setResource/{course}' , [CoursesController::class, 'setResource'])->name('courses.setResource');

    // Route::get('/courses/{course}' , [CoursesController::class, 'show'])->name('courses.course');


    //questions
    Route::resource('/questions', QuestionsController::class)->except(['create', 'edit']);
    Route::get('/questions/get/{course}' , [QuestionsController::class, 'course'])->name('questions.course');
    Route::get('/questions/getQuestion/{question}' , [QuestionsController::class, 'get'])->name('questions.get');
    Route::post('/question/delete/{question}' ,[QuestionsController::class,'delete'])->name('question.delete');
    Route::get('/question/getComments/{question}' ,[QuestionsController::class,'comments'])->name('question.comments');
    Route::get('/question/getSubComments/{comment}' ,[QuestionsController::class,'subComments'])->name('question.subComments');
    Route::post('/question/addComment/{question}' ,[QuestionsController::class,'addComment'])->name('question.addComment');
    Route::post('/question/enableDisableComments/{question}' ,[QuestionsController::class,'enableDisableComments'])->name('question.enableDisableComments');
    Route::post('/question/saveQuestion/{question}',[QuestionsController::class,'saveQuestion'])->name('question.saveQuestion');
    Route::post('/question/unsaveQuestion/{question}',[QuestionsController::class,'unsaveQuestion'])->name('question.unsaveQuestion');

    //notifications
    Route::get('/notifications', [NotificationsController::class,'showNotifications'])->name('notifications');
    Route::get('/notifications/get', [NotificationsController::class,'get'])->name('notifications.get');
    Route::post('/notifications/setQuestion/{question}', [NotificationsController::class,'setQuestion'])->name('notifications.setQuestion');
    // Route::post('/notifications/delete/{notification}', 'NotificationsController@deleteNotification')->name('notifications.delete');
    // Route::get('/notifications/getMoreNotifications' ,'NotificationsController@getMoreNotifications')->name('notifications.getMoreNotifications');
    // Route::get('/notifications/getUnreadNotifications','NotificationsController@getUnreadNotifications')->name('notifications.getUnreadNotifications');

    //users
    Route::get('/profile/{user}',[UsersController::class,'profile'])->name('users.profile');
    Route::post('/profile/updateImage',[UsersController::class,'updateImage'])->name('profile.updateImage');
    Route::get('/getUserPosts',[QuestionsController::class,'user'])->name('questions.user');
    Route::get('/settings',[UsersController::class,'settings'])->name('users.settings');
    Route::post('/settings/update/{type}',[UsersController::class,'update'])->name('users.settings.update');
    Route::get('/getUserSavedPosts',[QuestionsController::class,'getSavedQuestions'])->name('questions.getSavedQuestions');



    //complaints
    Route::post('/complaints/add/{question}' , [ComplaintsController::class,'add'])->name('complaints.add');

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
            Route::delete('/courses/deleteResource/{resource}' , [CoursesController::class, 'deleteResource'])->name('courses.deleteResource');
            Route::put('/courses/acceptResource/{resource}' , [CoursesController::class, 'acceptResource'])->name('courses.acceptResource');
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




