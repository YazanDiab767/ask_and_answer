@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/color.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}" />
@endsection

@section('content')

{{-- mobile header --}}
<div class="responsive-header">
    <div class="mh-head first Sticky">
        <span class="mh-btns-left">
            <a class="" href="#menu"><i class="fa fa-align-justify"></i></a>
        </span>
        <span class="mh-text">
            <a href="newsfeed.html" title="">
                <img src="{{ asset('images/question.png') }}" width="50" height="50">
                <span> And Answer </span>
            </a>
        </span>
        <span class="mh-btns-right">
            <a class="fa fa-sliders" href="#shoppingbag"></a>
        </span>
    </div>
    <div class="mh-head second">
        <form class="mh-form">
            <input placeholder="search" />
        </form>
    </div>
    <nav id="menu" class="res-menu">
        <ul>
            <li>
                <span> <a href="{{ route('main') }}" ><i class="fa-solid fa-house"></i> Home</a> </span>
            </li>
            <hr>
            <li>
                <span> <a href="{{ route('users.profile' , auth()->user()->id) }}" title=""><i class="fa-solid fa-user"></i> My Profile</a> </span>
            </li>
            <hr>
            <li>
                <span> <a href="#" title=""><i class="fa-solid fa-building"></i> Colleges</a> </span>
            </li> 
            <hr>
            <li>
                <span> <a href="{{ route('users.settings') }}" title=""><i class="fa fa-cogs"></i>Settings</a> </span>
            </li>
            <hr>
            <li>
                <span> <a href="#" title=""><i class="fa-solid fa-chart-line"></i> Activity log </a> </span>
            </li>
            <hr>
            <li>
                <span> <a href="{{ route('users.settings') }}" title=""><i class="fa-solid fa-gear"></i> Settings </a> </span>
            </li>
            <hr>
            <li>
                <form class="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <span> <a href="#" title=""><i class="fa-solid fa-right-from-bracket"></i> Logout</a> </span>
                </form>
            </li>
            {{-- <a href="#" title=""><span class="status f-online"></span> online</a> --}}
        </ul>
    </nav>

</div>

{{-- header --}}
<div class="topbar stick">
    <div class="logo">
        <a class="text-white" href="{{ route('main') }}">
            <img src="{{ asset('images/question.png') }}" width="50" height="50" alt="">
            <b> CampusLink </b>
        </a>
    </div>
    
    <div class="top-area">
        <ul class="main-menu">
            <li>
                <a href="{{ route('main') }}" class="text-white" ><i class="fa-solid fa-house"></i> Home</a>
            </li>
            <li>
                <a href="{{ route('users.profile' , auth()->user()->id) }}" class="text-white"><i class="fa-solid fa-user"></i> My Profile</a>
            </li>
            <li>
                <a href="{{ route('colleges.showAll') }}" class="text-white"><i class="fa-solid fa-building"></i> Colleges</a>
            </li>
            <li>
                <a href="{{ route('workspace.index') }}" class="text-white"><i class="fa-solid fa-network-wired"></i> Workspace</a>
            </li>
            <li>
                <a href="{{ route('users.settings') }}" class="text-white"><i class="fa fa-cogs"></i> Settings</a>
            </li>
        </ul>
        <ul class="setting-area">
            <li>
                <a href="#" class="text-white" data-ripple=""><i class="fa-solid fa-magnifying-glass"></i></a>

                <div class="searched">
                    <form method="post" class="form-search">
                        <select class="selectCourseSearch js-states form-control w-100 p-5" name="course">
                            <option value="-1"></option>
                            ...
                            @foreach (\App\Models\Course::all() as $course)
                                <option value="{{ $course->id }}"> {{ $course->name }} / {{ $course->college->name }} </option>
                                ...
                            @endforeach
                        </select>                        
                        {{-- <button data-ripple><i class="fa-solid fa-magnifying-glass"></i></button> --}}
                    </form>
                </div>
            </li>
            {{-- <li><a href="{{ route('main') }}" onclick="window.location.assign(`/main`)" class="text-white" data-ripple=""><i class="fa-solid fa-house"></i></a></li> --}}
            <li>
                <a href="#" class="text-white btnMessages">
                    <i class="fa-solid fa-message"></i><span class="text-white count_messages">0</span>
                </a>
                <div class="dropdowns">
                    <span>
                        <span style="font-size: 18px;"><i class="fa-solid fa-message"></i> New Messages: <b class="count_messages"></b> </span> <br/>
                    </span>
                    <br/>
                    <ul class="drops-menu " id="messages">
                    </ul>
                </div>
            </li>
            <li>
                <a href="#" class="text-white btnShowNotifications" data-ripple="">
                    <i class="fa-solid fa-bell"></i><span class="text-white currentNotification">{{ \App\Models\Notification::getNumberNewNotifications() }}</span>
                </a>
                <div class="dropdowns">
                    <span>
                        <span style="font-size: 18px;"><i class="fa-solid fa-bell"></i>  New Notifications: <b class="currentNotification">{{ \App\Models\Notification::getNumberNewNotifications() }} </b> </span> <br/>
                        <a href="/notifications" onclick="window.location.assign(`/notifications`)" class="text-primary">Show all notifications</a>
                    </span>
                    <br/>
                    <ul class="drops-menu notifications notifications_menu" id="">
                    </ul>
                    <a href="" onclick="window.location.assign(`/notifications`)" class="more-mesg">view more</a>
                </div>
            </li>
            <li><a href="#" class="text-white"><i class="fa fa-globe"></i></a>
                <div class="dropdowns languages">
                    <a href="#" title=""><i class="fa-solid fa-check"></i> English</a>
                    <a href="#" title="">Arabic</a>
                </div>
            </li>
            @if ( auth()->user()->role == 'admin' || auth()->user()->role == 'supervisor' )
                <li>
                    {{-- main-menu --}}
                    <span class="btnControlSide text-white" style="cursor:pointer"><i class="fa-solid fa-solar-panel"></i> </span>
                </li>
            @endif
        </ul>
        <div class="user-img">
            <img src="/storage/{{  auth()->user()->image }}" style="min-width: 60px; min-height: 60px; max-width: 60px; max-height: 60px; border: 2px solid white;">
            <span class="status f-online"></span>
            <div class="user-setting">
                <a href="#" title=""><span class="status f-online"></span> online </a>
                <a href="" onclick="window.location.assign(`/profile/${user_id}`)"><i class="fa-solid fa-user"></i> view profile </a>
                <a href="#" title=""><i class="fa-solid fa-chart-line"></i> activity log </a>
                <a href="" onclick="window.location.assign('/settings')" title=""><i class="fa-solid fa-gear"></i> settings </a>
                <a href="#" class="btnLogout"><i class="fa-solid fa-right-from-bracket"></i> Logout </a>
            </div>
        </div>
        <span class="text-white"> {{ auth()->user()->name }} </span>
    </div>
</div>

@yield('body')

{{-- side for contorl panel --}}
<div class="side-panel">
	<div class="text-center">
        <h3 class="panel-title"> <i class="fa-solid fa-solar-panel"></i> Control Panel </h3>
        <hr style="border-bottom: 3px solid #00aeff;">
    </div>
    
    @php
        $permissions = json_decode(auth()->user()->permissions , JSON_FORCE_OBJECT ) ;
    @endphp

    @if ( auth()->user()->role == 'admin' )
  
        <div class="setting-row text-center p-3">
            <a href="{{ route('universities.index') }}">
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-1">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <div class="col-sm-2">
                        Universities 
                    </div>
            
                </div>
            </a>
        </div>

        <div class="setting-row text-center p-3">
            <a href="{{ route('colleges.index') }}">
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-1">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                    <div class="col-sm-2">
                        Colleges 
                    </div>
            
                </div>
            </a>
        </div>

    @endif

    @if ( isset( $permissions["course"] ) || auth()->user()->role == 'admin' )
        <div class="setting-row p-3">
            <a href="{{ route('courses.index') }}">
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-1">
                        <i class="fa-solid fa-book"></i> 
                    </div>
                    <div class="col-sm-2">
                        Courses 
                    </div>
                </div>
            </a>
        </div>
    @endif

    @if ( isset( $permissions["course"] ) || auth()->user()->role == 'admin' )

        <div class="setting-row p-3">
            <a href="{{ route('control_panel.questions') }}">
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-1">
                        <i class="fa-solid fa-circle-question"></i>
                    </div>
                    <div class="col-sm-2">
                        Questions 
                    </div>
                </div>
            </a>
        </div>

        <div class="setting-row p-3">
            <a href="{{ route('control_panel.complaints') }}">
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-1">
                        <i class="fa-solid fa-triangle-exclamation"></i> 
                    </div>
                    <div class="col-sm-2">
                        Complaints 
                    </div>
                </div>
            </a>
        </div>

    @endif

    @if ( auth()->user()->role == 'admin' )
        <div class="setting-row p-3">
            <a href="{{ route('users.index') }}">
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-1">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="col-sm-2">
                        Users 
                    </div>
                </div>
            </a>
        </div>

        <div class="setting-row p-3">
            <a href="{{ route('control_panel.statistics') }}">
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-1">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <div class="col-sm-2">
                        Statistics 
                    </div>
                </div>
            </a>
        </div>

        <div class="setting-row p-3">
            <a href="{{ route('dashboard.operationsLog') }}">
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-1">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <div class="col-sm-2">
                        Log 
                    </div>
                </div>
            </a>
        </div>
    @endif
</div>

@endsection

@section('script')
@parent
	{{-- <script src="{{ asset('js/main.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/map-init.js') }}"></script> --}}
    <script>
        var user_id = {{ auth()->user()->id  }};
        var count_notifications = {{ \App\Models\Notification::getNumberNewNotifications() }};
        var count_messages = {{ \App\Models\Notification::getNumberNotificationsForMessages() }};
    </script>
    <script src="{{ asset('js/placeholders.js') }}"></script>
    <script src=" {{ asset('js/select2.min.js') }} "></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
    <script src="{{ asset('js/all.js') }}"></script>
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8c55_YHLvDHGACkQscgbGLtLRdxBDCfI"></script> --}}
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
@endsection
