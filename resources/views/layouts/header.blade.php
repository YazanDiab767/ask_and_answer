@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/color.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
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
                <span> <a href="#" title=""><i class="fa-solid fa-user"></i> My Profile</a> </span>
            </li>
            <hr>
            <li>
                <span> <a href="#" title=""><i class="fa-solid fa-building"></i> Colleges</a> </span>
            </li> 
            <hr>
            <li>
                <span> <a href="#" title=""><i class="fa-solid fa-circle-question"></i> My questions</a> </span>
            </li>
            <hr>
            <li>
                <span> <a href="#" title=""><i class="fa-solid fa-chart-line"></i> Activity log </a> </span>
            </li>
            <hr>
            <li>
                <span> <a href="#" title=""><i class="fa-solid fa-gear"></i> Settings </a> </span>
            </li>
            <hr>
            <li>
                <span> <a href="#" title=""><i class="fa-solid fa-right-from-bracket"></i> Logout</a> </span>
            </li>
            {{-- <a href="#" title=""><span class="status f-online"></span> online</a> --}}
        </ul>
    </nav>
    <nav id="shoppingbag">
        <div>
            <div class="">
                <form method="post">
                    <div class="setting-row">
                        <span>use night mode</span>
                        <input type="checkbox" id="nightmode"/> 
                        <label for="nightmode" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                    <div class="setting-row">
                        <span>Notifications</span>
                        <input type="checkbox" id="switch2"/> 
                        <label for="switch2" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                    <div class="setting-row">
                        <span>Notification sound</span>
                        <input type="checkbox" id="switch3"/> 
                        <label for="switch3" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                    <div class="setting-row">
                        <span>My profile</span>
                        <input type="checkbox" id="switch4"/> 
                        <label for="switch4" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                    <div class="setting-row">
                        <span>Show profile</span>
                        <input type="checkbox" id="switch5"/> 
                        <label for="switch5" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                </form>
                <h4 class="panel-title">Account Setting</h4>
                <form method="post">
                    <div class="setting-row">
                        <span>Sub users</span>
                        <input type="checkbox" id="switch6" /> 
                        <label for="switch6" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                    <div class="setting-row">
                        <span>personal account</span>
                        <input type="checkbox" id="switch7" /> 
                        <label for="switch7" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                    <div class="setting-row">
                        <span>Business account</span>
                        <input type="checkbox" id="switch8" /> 
                        <label for="switch8" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                    <div class="setting-row">
                        <span>Show me online</span>
                        <input type="checkbox" id="switch9" /> 
                        <label for="switch9" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                    <div class="setting-row">
                        <span>Delete history</span>
                        <input type="checkbox" id="switch10" /> 
                        <label for="switch10" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                    <div class="setting-row">
                        <span>Expose author name</span>
                        <input type="checkbox" id="switch11" /> 
                        <label for="switch11" data-on-label="ON" data-off-label="OFF"></label>
                    </div>
                </form>
            </div>
        </div>
    </nav>
</div>

{{-- header --}}
<div class="topbar stick">
    <div class="logo">
        <a class="text-white" href="{{ route('main') }}">
            <img src="{{ asset('images/question.png') }}" width="50" height="50" alt="">
            <b> Ask And Answer </b>
        </a>
    </div>
    
    <div class="top-area">
        <ul class="main-menu">
            <li>
                <a href="{{ route('main') }}" class="text-white" ><i class="fa-solid fa-house"></i> Home</a>
            </li>
            <li>
                <a href="#" class="text-white"><i class="fa-solid fa-user"></i> My Profile</a>
            </li>
            <li>
                <a href="#" class="text-white"><i class="fa-solid fa-building"></i> Colleges</a>
            </li>
            <li>
                <a href="#" class="text-white"><i class="fa-solid fa-circle-question"></i> My questions</a>
            </li>
        </ul>
        <ul class="setting-area">
            <li>
                <a href="#" class="text-white" data-ripple=""><i class="fa-solid fa-magnifying-glass"></i></a>

                <div class="searched">
                    <form method="post" class="form-search">
                        <input type="text" placeholder="Search Friend">
                        <button data-ripple><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>
            </li>
            <li><a href="{{ route('main') }}" class="text-white" data-ripple=""><i class="fa-solid fa-house"></i></a></li>
            <li>
                <a href="#" class="text-white" data-ripple="">
                    <i class="fa-solid fa-bell"></i><span>20</span>
                </a>
                <div class="dropdowns">
                    <span>4 New Notifications</span>
                    <ul class="drops-menu">
                        <li>
                            <a href="notifications.html" title="">
                                <img src="{{ asset('images/user.png') }}" alt="">
                                <div class="mesg-meta">
                                    <h6>sarah Loren</h6>
                                    <span>Hi, how r u dear ...?</span>
                                    <i>2 min ago</i>
                                </div>
                            </a>
                            <span class="tag green">New</span>
                        </li>
                        <li>
                            <a href="notifications.html" title="">
                                <img src="{{ asset('images/user.png') }}" alt="">
                                <div class="mesg-meta">
                                    <h6>Jhon doe</h6>
                                    <span>Hi, how r u dear ...?</span>
                                    <i>2 min ago</i>
                                </div>
                            </a>
                            <span class="tag red">Reply</span>
                        </li>
                        <li>
                            <a href="notifications.html" title="">
                                <img src="{{ asset('images/user.png') }}" alt="">
                                <div class="mesg-meta">
                                    <h6>Andrew</h6>
                                    <span>Hi, how r u dear ...?</span>
                                    <i>2 min ago</i>
                                </div>
                            </a>
                            <span class="tag blue">Unseen</span>
                        </li>
                        <li>
                            <a href="notifications.html" title="">
                                <img src="{{ asset('images/user.png') }}" alt="">
                                <div class="mesg-meta">
                                    <h6>Tom cruse</h6>
                                    <span>Hi, how r u dear ...?</span>
                                    <i>2 min ago</i>
                                </div>
                            </a>
                            <span class="tag">New</span>
                        </li>
                        <li>
                            <a href="notifications.html" title="">
                                <img src="{{ asset('images/user.png') }}" alt="">
                                <div class="mesg-meta">
                                    <h6>Amy</h6>
                                    <span>Hi, how r u dear ...?</span>
                                    <i>2 min ago</i>
                                </div>
                            </a>
                            <span class="tag">New</span>
                        </li>
                    </ul>
                    <a href="notifications.html" class="more-mesg">view more</a>
                </div>
            </li>
            <li><a href="#" class="text-white"><i class="fa fa-globe"></i></a>
                <div class="dropdowns languages">
                    <a href="#" title=""><i class="fa-solid fa-check"></i> English</a>
                    <a href="#" title="">Arabic</a>
                </div>
            </li>
            <li>
                {{-- main-menu --}}
                <span class="btnControlSide text-white" style="cursor:pointer"><i class="fa-solid fa-solar-panel"></i> </span>
            </li>
        </ul>
        <div class="user-img">
            <img src="{{ asset('images/user.png') }}" width="50" height="50" alt="">
            <span class="status f-online"></span>
            <div class="user-setting">
                <a href="#" title=""><span class="status f-online"></span> online </a>
                <a href="#" title=""><i class="fa-solid fa-user"></i> view profile </a>
                <a href="#" title=""><i class="fa-solid fa-chart-line"></i> activity log </a>
                <a href="#" title=""><i class="fa-solid fa-gear"></i> settings </a>
                <a href="#" title=""><i class="fa-solid fa-right-from-bracket"></i> log out </a>
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
	<div class="setting-row text-center p-3 mt-3">
        <a href="{{ route('control_panel.colleges') }}">
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

	<div class="setting-row p-3">
		<a href="{{ route('control_panel.courses') }}">
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

	<div class="setting-row p-3">
        <a href="{{ route('control_panel.complaints') }}">
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
        <a href="{{ route('control_panel.complaints') }}">
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
        <a href="{{ route('control_panel.complaints') }}">
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
</div>

@endsection

@section('script')
@parent
	<script src="{{ asset('js/main.min.js') }}"></script>
    <script src="{{ asset('js/map-init.js') }}"></script>
    <script src="{{ asset('js/all.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8c55_YHLvDHGACkQscgbGLtLRdxBDCfI"></script>
@endsection