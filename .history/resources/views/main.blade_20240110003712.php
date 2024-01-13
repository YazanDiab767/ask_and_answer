@extends('layouts.header')

@section('title','CampusLink - Main')

@section('style')
	@parent
	<style>
		.select2-search__field, .select2-container{
			width: 100% !important;
		}
	</style>
@endsection

@section('body')

<div class="theme-layout">
	<section>
		<div class="gap gray-bg">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="row" id="page-contents">
							<div class="col-lg-3">
								<aside class="sidebar static">
									<div class="widget">
										<h4 class="widget-title">Shortcuts</h4>
										<ul class="naves">
											<li>
												<i class="fa-solid fa-newspaper"></i>
												<a href="" title="">News feed</a>
											</li>
											<li>
												<i class="fa-solid fa-address-card"></i>
												<a href="{{ route('users.profile' , auth()->user()->id) }}" title="">My profile</a>
											</li>
											<li>
												<i class="fa-solid fa-building"></i>
												<a href="timeline-friends.html" title="">Colleges</a>
											</li>
											<li>
												<i class="fa-solid fa-envelopes-bulk"></i>
												<a href="timeline-friends.html" title="">Offers</a>
											</li>
											<li>
												<form class="logout-form" action="{{ route('logout') }}" method="POST">
													@csrf
													<i class="fa-solid fa-right-from-bracket"></i>
													<a href="#" class="btnLogout"> Logout </a>
												</form>
											</li>
										</ul>
									</div>

									<div class="widget">
										<h4 class="widget-title">My Workspaces ( <b id="count"></b> )</h4>
										<ul class="activitiez" id="workspaces">
										</ul>
									</div>

								</aside>
							</div>

							
							<div class="col-lg-6">
								<div class="central-meta">
									<div class="new-postbox">
										{{-- <figure>
											<img src="/storage/{{  auth()->user()->image }}" style="min-width: 80px; min-height: 80px; max-width: 80px; max-height: 80px;">
										</figure> --}}
										<div class="newpst-input w-100">
											<form action="{{ route('questions.store') }}" method="POST" id="form_new_question" enctype="multipart/form-data">
												@csrf
												<input type="hidden" name="course" value="">
												<textarea rows="2" placeholder="Write a text of question" name="text" required></textarea>

												<div class="attachments">
													<ul>
														<li>
															<i class="fa fa-music"></i>
															<label class="fileContainer">
																<input type="file" class="image">
															</label>
														</li>
														<li>
															<i class="fa fa-image"></i>
															<label class="fileContainer">
																<input type="file" class="image">
															</label>
														</li>
														<li>
															<i class="fa-solid fa-video"></i>
															<label class="fileContainer">
																<input type="file" class="image">
															</label>
														</li>
														<li>
															<i class="fa fa-camera"></i>
															<label class="fileContainer">
																<input type="file" name="image" class="image">
															</label>
														</li>
														<li>
															<button type="submit">Post</button>
														</li>
													</ul>
												</div>

												<div class="mt-1">
													<select class="selectCourse form-control w-100" name="course">
														@foreach (\App\Models\Course::all() as $course)
															<option value="{{ $course->id }}" selected> {{ $course->name }} / {{ $course->college->name }} </option>
															...
														@endforeach
													</select>
												</div>

												<div id="result_form_question" class="text-left">
												</div>
											</form>
		
										</div>
									</div>
								</div>

								<div class="loadMore">
									<div id="posts" class="central-meta item">

									</div>
									<div class="row justify-content-center pb-3">
										<a class="btn btn-primary btnGetMoreQuestion text-white"> <i class="fa-brands fa-get-pocket"></i> Show More </a>
									</div>
								</div>
							</div>
							
							<div class="col-lg-3">
								<aside class="sidebar static">
									<div class="widget">
										<h4 class="widget-title">{{ auth()->user()->name }}</h4>	
										<div class="your-page">
											<figure>
												<a href="#" title=""> <img src="/storage/{{  auth()->user()->image }}" style="min-width: 70px; min-height: 70px; max-width: 70px; max-height: 70px;"> </a>
											</figure>
											<div class="page-meta p-3">
												<span><i class="fa-solid fa-circle-question"></i><a href="">Questions <em> {{ auth()->user()->questions()->count() }}</em></a></span>
												<span><i class="fa-solid fa-bell"></i><a href="/notifications">Notifications <em class="currentNotification"> {{ \App\Models\Notification::getNumberNewNotifications() }} </em></a></span>
												<span><i class="fa-solid fa-message"></i><a>Messages <em class="count_messages"> 0 </em></a></span>

											</div>
											<div class="page-likes">
												<ul class="nav nav-tabs likes-btn">
													<li class="nav-item"><a class="active" href="#link1" data-toggle="tab">likes</a></li>
													 <li class="nav-item"><a class="" href="#link2" data-toggle="tab">comments</a></li>
												</ul>
												<!-- Tab panes -->
												<div class="tab-content">
												  <div class="tab-pane active fade show " id="link1" >
													<span>{{ \App\Models\Like::where('user_id',auth()->user()->id)->count() }}</span>
												  </div>
												  <div class="tab-pane fade" id="link2" >
													  <span>{{ \App\Models\Comment::where('user_id',auth()->user()->id)->count() }}</span>
												  </div>
												</div>
											</div>
										</div>
									</div>

									<div class="widget">
										<div class="banner medium-opacity bluesh">
											
											<div class="baner-top">
												<i class="fa fa-ellipsis-h"></i>
											</div>
											<div class="banermeta">
												<p>
													Select your courses
												</p>
												<span>to get notifications for any updates on them</span>
												<a  href="#" data-toggle="modal" data-target=".modalSelectCourses">Select</a>
											</div>
										</div>											
									</div>

								</aside>
							</div><!-- sidebar -->
						</div>	
					</div>
				</div>
			</div>
		</div>	
	</section>
</div>

@endsection

@section('modal')
<div class="modal fade modalSelectCourses" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content p-4">
		<h4> <i class="fa-solid fa-swatchbook"></i> Select Your Courses </h4>
		<hr>
		<form action="{{ route('courses.addUserCourses') }}" class="w-100" method="POST" id="formSelectCourses">
			@csrf
			<div class="form-group w-100">
				<label>Your courses:</label>
				<select class="multiple-select selectCourses form-control w-100" name="courses[]" multiple="multiple">
					@php
						$userCourses = explode(',' , auth()->user()->courses);	
					@endphp
					@foreach (\App\Models\Course::all() as $course)
						@if ( in_array( $course->id , $userCourses) )
							<option value="{{ $course->id }}" selected> {{ $course->name }} / {{ $course->college->name }} </option>
							...
						@else
							<option value="{{ $course->id }}"> {{ $course->name }} / {{ $course->college->name }} </option>
							...
						@endif
					@endforeach
				</select>
			</div>
			<div class="float-right">
				<button class="btn btn-success w-100"> <i class="fa-solid fa-floppy-disk"></i> Save </button>
			</div>
		</form>
	  </div>
	</div>
  </div>
@endsection

@section('script')
@parent
	<script src=" {{ asset('js/comments.js') }} "></script>
	<script src=" {{ asset('js/courses.js') }} "></script>
	<script src=" {{ asset('js/workspace/index.js') }} "></script>
	<script>
        var user_id = {{ auth()->user()->id  }};
        var savedQuestions = '{{ auth()->user()->savedQuestions }}';
        var count_comments = 0;
		var count = {{ \App\Models\Workspace::where('user_id' , auth()->user()->id )->orWhere('members' , 'LIKE' , '%' . auth()->user()->email . '%')->count() }};
    </script>
@endsection