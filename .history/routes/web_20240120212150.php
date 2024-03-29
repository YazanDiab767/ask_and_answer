<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CollegesController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\ComplaintsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\NotificationsController;
use \App\Http\Controllers\WorkspaceController;
use \App\Http\Controllers\UniversitiesController;


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

Route::get('/csrf', function(){
    return response()->json(['csrf'=> csrf_token() ], 200);

});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/college/getAllMajors', [CollegesController::class,'getAllMajors'])->name('colleges.getAllMajors');
Route::get('/college/getAllUniversities', [CollegesController::class,'getAllUniversities'])->name('colleges.getAllUniversities');


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/courses/addUserCourses/a/b', function(){
        return 123;
    });
    
    Route::get('/test' , [App\Http\Controllers\UsersController::class, 'test'])->name('test.index');


    Route::get('/user/getInfo', [App\Http\Controllers\UsersController::class, 'getInfo']);

    Route::get('/user/getOffers', [App\Http\Controllers\UsersController::class, 'getOffers']);
    Route::get('/offers', [App\Http\Controllers\UsersController::class, 'showOffers'])->name('offers');


    Route::get('/main', function () { return view('main'); })->name('main');
    Route::get('/getNewQuestions', [QuestionsController::class,'showLastQuestions']);

    //colleges
    Route::get('/colleges' , [CollegesController::class, 'showAll'])->name('colleges.showAll');
    Route::get('/colleges/getAll' , [CollegesController::class, 'getAllColleges'])->name('colleges.getAllColleges');
    Route::get('/college/getMajors/{college}', [CollegesController::class,'getMajors'])->name('colleges.getMajors');

    //majors
    Route::get('/major/{major}' , [CollegesController::class, 'major'])->name('colleges.major');

    //courses
    Route::get('/colleges/{college}' , [CollegesController::class, 'show'])->name('colleges.college');
    Route::get('/courses/{course}' , [CoursesController::class, 'show'])->name('courses.course');
    Route::post('/courses/addUserCourses',[CoursesController::class,'addUserCourses'])->name('courses.addUserCourses');
    Route::post('/control_panel/courses/setResource/{course}' , [CoursesController::class, 'setResource'])->name('courses.setResource');
    Route::get('/courses/getCourses/all' , [CoursesController::class, 'getAllCourses'])->name('courses.getAllCourses');
    Route::get('/course/{course}/getCourseResources' , [CoursesController::class, 'getCourseResources'])->name('courses.getCourseResources');
    Route::get('/course/getSupervisorOfCourse/{course}', [CoursesController::class , 'getSupervisorOfCourse'] );
    Route::get('/getMyCourses',[CoursesController::class, 'getMyCourses']);

    //questions
    Route::resource('/questions', QuestionsController::class)->except(['create', 'edit']);
    Route::get('/questions/get/{course}' , [QuestionsController::class, 'course'])->name('questions.course');
    Route::get('/questions/getMajor/{major}' , [QuestionsController::class, 'major'])->name('questions.major');
    Route::get('/questions/getQuestion/{question}' , [QuestionsController::class, 'get'])->name('questions.get');
    Route::get('/questions/getQuestionsForUser/{user}' , [QuestionsController::class, 'getQuestionsForUser'])->name('questions.getQuestionsForUser');
    Route::get('/questions/getSavedQuestion' , [QuestionsController::class, 'getSavedQuestion'])->name('questions.getSavedQuestion');
    Route::post('/question/delete/{question}' ,[QuestionsController::class,'delete'])->name('question.delete');
    Route::get('/question/getComments/{question}' ,[QuestionsController::class,'comments'])->name('question.comments');
    Route::get('/question/getSubComments/{comment}' ,[QuestionsController::class,'subComments'])->name('question.subComments');
    Route::post('/question/addComment/{question}' ,[QuestionsController::class,'addComment'])->name('question.addComment');
    Route::post('/question/enableDisableComments/{question}' ,[QuestionsController::class,'enableDisableComments'])->name('question.enableDisableComments');
    Route::post('/question/saveQuestion/{question}',[QuestionsController::class,'saveQuestion'])->name('question.saveQuestion');
    Route::post('/question/unsaveQuestion/{question}',[QuestionsController::class,'unsaveQuestion'])->name('question.unsaveQuestion');

    //notifications
    Route::get('/notifications', [NotificationsController::class,'showNotifications'])->name('notifications');
    Route::get('/notifications/getCount', [NotificationsController::class,'getCountUnreadNotifications'])->name('notifications.getCount');
    Route::get('/notifications/get', [NotificationsController::class,'get'])->name('notifications.get');
    Route::post('/notifications/setQuestion/{question}', [NotificationsController::class,'setQuestion'])->name('notifications.setQuestion');
    // Route::post('/notifications/delete/{notification}', 'NotificationsController@deleteNotification')->name('notifications.delete');
    // Route::get('/notifications/getMoreNotifications' ,'NotificationsController@getMoreNotifications')->name('notifications.getMoreNotifications');
    // Route::get('/notifications/getUnreadNotifications','NotificationsController@getUnreadNotifications')->name('notifications.getUnreadNotifications');

    //users
    Route::get('/profile/{user}',[UsersController::class,'profile'])->name('users.profile');
    Route::post('/profile/updateImage',[UsersController::class,'updateImage'])->name('profile.updateImage');
    Route::get('/getUserPosts/{user}',[QuestionsController::class,'user'])->name('questions.user');
    Route::get('/settings',[UsersController::class,'settings'])->name('users.settings');
    Route::post('/settings/update/{type}',[UsersController::class,'update'])->name('users.settings.update');
    Route::get('/getUserSavedPosts',[QuestionsController::class,'getSavedQuestions'])->name('questions.getSavedQuestions');
    Route::get('/getActivities',[UsersController::class,'getActivities'])->name('users.getActivities');

    //chats
    Route::get('/chatWithSupervisor/{course}',[UsersController::class,'chatWithSupervisor'])->name('users.chatWithSupervisor');
    Route::get('/chatWithSupervisor/{course}/{user}',[UsersController::class,'chatWithUser'])->name('users.chatWithUser');
    Route::get('/getChatWithSupervisor/{course}/{user}',[UsersController::class,'getChatWithSupervisor'])->name('users.getChatWithSupervisor');
    Route::post('/setChatWithSupervisor/{course}/{user}',[UsersController::class,'sendMessageToChatWithSupervisor'])->name('users.sendMessageToChatWithSupervisor');

    //complaints
    Route::post('/complaints/add/{question}' , [ComplaintsController::class,'add'])->name('complaints.add');

    //workspace
    Route::get('/workspace',[WorkspaceController::class,'index'])->name('workspace.index');
    Route::get('/workspace/{workspace}',[WorkspaceController::class,'workspace'])->name('workspace.workspace');
    Route::get('/workspace/getWorkspace/{workspace}',[WorkspaceController::class,'getWorkspace'])->name('workspace.getWorkspace');
    Route::get('/workspace/get/{id}',[WorkspaceController::class,'get'])->name('workspace.get');
    Route::get('/workspace/getWorks/{workspace}',[WorkspaceController::class,'getWorks'])->name('workspace.getWorks');
    Route::get('/workspace/getMembers/{workspace}',[WorkspaceController::class,'getMembers'])->name('workspace.getMembers');
    Route::post('/workspace/add',[WorkspaceController::class,'add'])->name('workspace.add');
    Route::post('/workspace/delete/{workspace}',[WorkspaceController::class,'delete'])->name('workspace.delete');
    Route::post('/workspace/invite/{workspace}',[WorkspaceController::class,'invite'])->name('workspace.invite');
    Route::post('/workspace/uploadWork/{workspace}',[WorkspaceController::class,'uploadWork'])->name('workspace.uploadWork');
    Route::post('/workspace/leave/{workspace}/{user}',[WorkspaceController::class,'leave'])->name('workspace.leave');
    Route::post('/workspace/accept/{workspace}',[WorkspaceController::class,'accept'])->name('workspace.accept');
    Route::get('/workspace/getMessagesToAll/{workspace}',[WorkspaceController::class,'getMessagesToAll'])->name('workspace.getMessagesToAll');
    Route::get('/workspace/getMessagesPrivate/{workspace}/{user}',[WorkspaceController::class,'getMessagesPrivate'])->name('workspace.getMessagesPrivate');
    Route::post('/workspace/sendMessageToAll/{workspace}',[WorkspaceController::class,'sendMessageToAll'])->name('workspace.sendMessageToAll');
    Route::post('/workspace/sendMessageToUser/{workspace}/{user}',[WorkspaceController::class,'sendMessageToUser'])->name('workspace.sendMessageToUser');
    
    Route::post('/workspace/addTask/{workspace}',[WorkspaceController::class,'addTask'])->name('workspace.addTask');
    Route::get('/workspace/getTasks/{workspace}',[WorkspaceController::class,'getTasks'])->name('workspace.getTasks');
    Route::post('/workspace/toggleTaskCompletion/{workspace}',[WorkspaceController::class,'toggleTaskCompletion'])->name('workspace.toggleTaskCompletion');
    Route::post('/workspace/deleteTask/{workspace}',[WorkspaceController::class,'deleteTask'])->name('workspace.deleteTask');
    Route::post('/workspace/updateTask/{workspace}',[WorkspaceController::class,'updateTask'])->name('workspace.updateTask');
    Route::post('/workspace/addEvent/{workspace}',[WorkspaceController::class,'addEvent'])->name('workspace.addEvent');

    
    Route::get('/calendar' , [UsersController::class, 'calendar'])->name('calendar');

    //Control Panel / Dashbaord
    Route::middleware('CheckSupervisor')->group(function () {
        Route::prefix('control_panel')->group(function () {

            //chats
            Route::get('/getChatsCourse/{course}',[UsersController::class,'getChatsCourse'])->name('users.getChatsCourse');

            //Questions
            Route::get('/questions' , [QuestionsController::class, 'index'])->name('control_panel.questions');
            Route::get('/questions/{question}/get' ,  [QuestionsController::class, 'getQuestion'])->name('control_panel.getQuestion');
            Route::post('/questions/{question}/retrunQuestion' ,  [QuestionsController::class, 'retrunQuestion'])->name('control_panel.retrunQuestion');
            Route::post('/questions/{question}/stop' ,  [QuestionsController::class, 'stopQuestion'])->name('control_panel.stopQuestion');

            //Complaints
            Route::get('/complaints', function () {return view('control_panel.complaints');})->name('control_panel.complaints');

            //Colleges
            Route::resource('/colleges', CollegesController::class)->except(['create', 'edit']);
            Route::post('/college/setMajor/{college}', [CollegesController::class,'setMajor'])->name('colleges.setMajor');
            Route::delete('/college/deleteMajor/{major}', [CollegesController::class,'deleteMajor'])->name('colleges.deleteMajor');

            //Universities
            Route::resource('/universities', UniversitiesController::class)->except(['create', 'edit']);
            Route::put('/university/approve/{university}', [UniversitiesController::class,'approve'])->name('universities.approve');

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


// *** A P I ***
Route::post('/API/user/login', [App\Http\Controllers\API\UsersController::class, 'login']);
Route::post('/API/user/pusher', [App\Http\Controllers\API\UsersController::class, 'auth']);
