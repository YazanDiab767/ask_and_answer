<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/API/user/login',
        '/API/user/pusher',
        '/register',
        'courses/*',
        '/courses/addUserCourses/a/b',
        '/questions',
        '/complaints/add/*',
        '/question/enableDisableComments/*',
        '/question/delete/*',
        '/question/*',
        '/notifications/get',
        '/notifications/getCount',
        '/colleges/*',
        '/profile/updateImage',
        '/workspace/add',
        '/workspace/delete/*',
        '/workspace/leave/*/*',
        '/control_panel/courses/setResource/*',
        '/setChatWithSupervisor/*/*',
        '/workspace/addTask/*',
        '/workspace/toggleTaskCompletion/*',
        '/workspace/deleteTask/*',
        '/workspace/updateTask/*',
        '/workspace/addEvent/*',
        '/workspace/accept/*',
        '/workspace/sendMessageToAll/*',
        '/settings/update/*',
        '/workspace/invite/*'
    ];
}
