@extends('layouts.header')

@section('title','CampusLink - Settings')

@section('style')
@parent
@endsection

@section('body')

<div class="theme-layout">
	<section>
		<div class="gap gray-bg">
			<div class="container-fluid">
				<div class="row justify-content-center">
					<div class="col-lg-12">
						<div class="row justify-content-center" id="page-contents">
							<div class="col-lg-11">
								<div class="central-meta text-center">
                                    <h2 class="text-black" style="font-size: 28px;"> <i class="fa-solid fa-gears"></i> Settings </h2>
                                    <ul class="nav nav-pills mt-5">
                                        <li class="nav-item w-25">
                                            <a class="nav-link active" data-toggle="pill" href="#username"><i class="fa-solid fa-user"></i> Username</a>
                                        </li>
                                        <li class="nav-item w-25">
                                            <a class="nav-link" data-toggle="pill" href="#email"><i class="fa-solid fa-at"></i> Email</a>
                                        </li>
                                        <li class="nav-item w-25">
                                            <a class="nav-link" data-toggle="pill" href="#password"><i class="fa-solid fa-lock"></i> Password</a>
                                        </li>
                                        <li class="nav-item w-25">
                                            <a class="nav-link" data-toggle="pill" href="#savedQuestions"><i class="fa-solid fa-bookmark"></i> Saved questions</a>
                                        </li>
                                        
                                    </ul>
                                    <hr>
                                    
                                    <div class="tab-content p-5">
                                        <div class="tab-pane container active" id="username">
                                            <form action="{{ route('users.settings.update', 'name') }}" method="POST" id="formUpdateName" class="mt-4">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-sm-2 my-auto text-center">
                                                        <span>New username : </span>
                                                    </div>
                                                    <div class="col-sm-10 my-auto text-left">
                                                        <input type="text" name="name" class="form-control" placeholder="Please enter new name" />
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-sm-2 my-auto text-center">
                                                        <span>Password : </span>
                                                    </div>
                                                    <div class="col-sm-10 my-auto text-left">
                                                        <input type="password" name="password" class="form-control" placeholder="Please enter your password" />
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center mt-1">
                                                    <div id="resultNameForm" class="col-sm-6 my-auto text-center">
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-sm-12 my-auto text-center">
                                                        <button id="saveName" class="btn btn-success w-25"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane container fade" id="email">
                                            <form action="{{ route('users.settings.update', 'email') }}" method="POST"  id="formUpdateEmail" class="mt-4">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-sm-2 my-auto text-center">
                                                        <span>New email : </span>
                                                    </div>
                                                    <div class="col-sm-10 my-auto text-left">
                                                        <input type="email" name="email" class="form-control" placeholder="Please enter new email" />
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-sm-2 my-auto text-center">
                                                        <span>Password : </span>
                                                    </div>
                                                    <div class="col-sm-10 my-auto text-left">
                                                        <input type="password" name="password" class="form-control" placeholder="Please enter your password" />
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center mt-1">
                                                    <div id="resultEmailForm" class="col-sm-6 my-auto text-center">
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-sm-12 my-auto text-center">
                                                        <button id="saveEmail" class="btn btn-success w-25"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane container fade" id="password">
                                            <form action="{{ route('users.settings.update', 'password') }}" id="formUpdatePassword" class="mt-4">
                                                <div class="row">
                                                    <div class="col-sm-2 my-auto text-center">
                                                        <span>New password : </span>
                                                    </div>
                                                    <div class="col-sm-10 my-auto text-left">
                                                        <input type="password" name="newPassword" class="form-control" placeholder="Please enter new password" />
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-sm-2 my-auto text-center">
                                                        <span>Current password : </span>
                                                    </div>
                                                    <div class="col-sm-10 my-auto text-left">
                                                        <input type="password" name="password" class="form-control" placeholder="Please enter your password" />
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center mt-1">
                                                    <div id="resultPasswordForm" class="col-sm-6 my-auto text-center">
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-sm-12 my-auto text-center">
                                                        <button id="savePassword" class="btn btn-success w-25"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane container fade" id="savedQuestions">
                                            <div id="posts">
                                                
                                            </div>
                                            <div class="row justify-content-center pb-3">
                                                <a class="btn btn-primary btnGetMoreQuestion text-white"> <i class="fa-brands fa-get-pocket"></i> Show More </a>
                                            </div>
                                        </div>
                                    </div>
                
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</section>
</div>

@endsection

@section('script')
@parent
    <script>
        var page_name = "settings";
        var savedQuestions = '{{ auth()->user()->savedQuestions }}';
        var user_id = {{ auth()->user()->id  }};
    </script>
    <script src=" {{ asset('js/select2.min.js') }} "></script>
    <script src=" {{ asset('js/colleges.js') }} "></script>
    <script src=" {{ asset('js/comments.js') }} "></script>
	<script src=" {{ asset('js/courses.js') }} "></script>
    <script src=" {{ asset('js/settings.js') }} "></script>
@endsection