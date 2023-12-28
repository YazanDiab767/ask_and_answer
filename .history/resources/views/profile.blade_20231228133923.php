@extends('layouts.header')

@section('title','CampusLink - My Profile')

@section('style')
	@parent
	<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}" />
	<style>
		.select2-search__field, .select2-container{
			width: 100% !important;
		}
	</style>
@endsection

@section('body')


<div class="theme-layout">
	
	<section>
		<div class="feature-photo">
			<figure><img src="{{ asset('images/background.webp') }}" style="height: 450px;"></figure>
		
			<form class="edit-phto">
				<i class="fa fa-camera-retro"></i>
				<label class="fileContainer">
					Edit Cover Photo
				<input type="file"/>
				</label>
			</form>
			<div class="container-fluid">
				<div class="row merged">
					<div class="col-lg-2 col-sm-3">
						<div class="user-avatar">
							<figure>
								<img src="/storage/{{ $user->image }}" alt="">
								<form id="form_edit_photo"  class="edit-phto">
									<i class="fa fa-camera-retro"></i>
									<label class="fileContainer">
										Edit Display Photo
										<input type="file" name="image" id="profile_photo" />
									</label>
								</form>
							</figure>
						</div>
					</div>
					<div class="col-lg-10 col-sm-9">
						<div class="timeline-info">
							<ul>
								<li class="admin-name">
								  <h5>{{ $user->name }}</h5>
								  <span>{{ $user->role }}</span>
								</li>
								<li>
									<a class="active btnTaps" href="" id="btn_posts" data-ripple="">@if ( auth()->user()->id == $user->id )My @endif Questions</a>
									@if ( auth()->user()->id == $user->id )
										<a class="btnTaps" href="" id="btn_info" data-ripple="">Personal information</a>
										<a class="btnTaps" href="" id="btn_activities" data-ripple="">Activites</a>
									@endif
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
		
	<section>
		<div class="gap gray-bg">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="row" id="page-contents">
							<div class="col-lg-3">
								<aside class="sidebar static">
									<div class="widget">
											<h4 class="widget-title">Socials</h4>
											<ul class="socials">
												<li class="facebook">
													<a title="" href="#"><i class="fa fa-facebook"></i> <span>facebook</span> <ins>45 likes</ins></a>
												</li>
												<li class="twitter">
													<a title="" href="#"><i class="fa fa-twitter"></i> <span>twitter</span><ins>25 likes</ins></a>
												</li>
												<li class="google">
													<a title="" href="#"><i class="fa fa-google"></i> <span>google</span><ins>35 likes</ins></a>
												</li>
											</ul>
										</div>
								</aside>
							</div>
							<div class="col-lg-8">
								<div class="loadMore">
									<div class="central-meta item tab" id="tap_posts">
										<h3>@if ( auth()->user()->id == $user->id )My @endif Questions ( {{ $user->questions()->count() }} ) </h3>
										<div id="posts">
											
										</div>
										<div class="row justify-content-center pb-3">
											<a class="btn btn-primary btnGetMoreQuestion text-white"> <i class="fa-brands fa-get-pocket"></i> Show More </a>
										</div>
									</div>
									@if ( auth()->user()->id == $user->id )
										<div class="central-meta item tab p-5" id="tap_info">
											<h3><i class="fa-solid fa-address-card"></i> Your Information</h3>
											<hr>
											<div>
												<div class="mt-4">
													<b> <i class="fa-solid fa-user"></i> Username : </b> {{ $user->name }}
												</div>
												<div class="mt-4">
													<b> <i class="fa-solid fa-at"></i> Email : </b> {{ $user->email }}
												</div>
												<div class="mt-4">
													<b> <i class="fa-solid fa-bars"></i> Role : </b> {{ $user->role }}
												</div>
												<div class="mt-4">
													<b> <i class="fa-solid fa-earth-americas"></i> Country : </b> {{ $user->country }}
												</div>
												<div class="mt-4">
													<b> <i class="fa-solid fa-calendar-days"></i> Date Create Account : </b> {{ $user->created_at }}
												</div>
												
											</div>
										</div>
										<div class="central-meta item tab" id="tap_activity">
											<h3><i class="fa-solid fa-chart-line"></i> Your Activites</h3>
											<hr>
											<div>
												<ul class="nav nav-pills w-100 text-center">
													<li class="nav-item w-50">
													<a class="nav-link active" data-toggle="pill" href="#likes"><i class="fa-solid fa-thumbs-up"></i> / <i class="fa-solid fa-thumbs-down"></i> Like and Dislikes</a>
													</li>
													<li class="nav-item w-50">
													<a class="nav-link" data-toggle="pill" href="#comments"><i class="fa-solid fa-comments"></i> Comments</a>
													</li>
												</ul>
											
												<div class="tab-content">
													<div class="tab-pane container active pt-4" id="likes">

														@foreach( $user->likes as $like )
															<label>
																-You
																@if ( $like->type == "like" )
																	<span class="text-success">liked</span>
																@else
																	<span class="text-danger">disliked</span>
																@endif
																this question of
																<u>{{ $like->question->user->name }}</u>
																<a href="/questions/{{ $like->question->id }}" class="text-primary ml-3"><i class="fa-regular fa-paper-plane"></i> Go to Question</a>
																<span class="ml-5"><i class="fa-solid fa-calendar-days"></i> {{ $like->created_at }} </span>
															</label>
															<hr>
														@endforeach
													</div>
													<div class="tab-pane container fade" id="comments">
														@foreach( $user->comments as $comment )
															<label class="mt-4">
																-You commented on question of <u>{{ $comment->question->user->name }}</u>
																<a href="/questions/{{ $comment->question->id }}" class="text-primary ml-3"><i class="fa-regular fa-paper-plane"></i> Go to Question</a>
																<span class="ml-5"><i class="fa-solid fa-calendar-days"></i> {{ $comment->created_at }} </span>
															</label>
															<hr>
														@endforeach
													</div>
												</div>
											</div>
										</div>
									@endif
								</div>
							</div>
							<div class="col-lg-1">
								<aside class="sidebar static">
								</aside>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>	
	</section>
</div>
	<div class="side-panel">
		<h4 class="panel-title">General Setting</h4>
		<form method="post">
			<div class="setting-row">
				<span>use night mode</span>
				<input type="checkbox" id="nightmode1"/> 
				<label for="nightmode1" data-on-label="ON" data-off-label="OFF"></label>
			</div>
			<div class="setting-row">
				<span>Notifications</span>
				<input type="checkbox" id="switch22" /> 
				<label for="switch22" data-on-label="ON" data-off-label="OFF"></label>
			</div>
			<div class="setting-row">
				<span>Notification sound</span>
				<input type="checkbox" id="switch33" /> 
				<label for="switch33" data-on-label="ON" data-off-label="OFF"></label>
			</div>
			<div class="setting-row">
				<span>My profile</span>
				<input type="checkbox" id="switch44" /> 
				<label for="switch44" data-on-label="ON" data-off-label="OFF"></label>
			</div>
			<div class="setting-row">
				<span>Show profile</span>
				<input type="checkbox" id="switch55" /> 
				<label for="switch55" data-on-label="ON" data-off-label="OFF"></label>
			</div>
		</form>
		<h4 class="panel-title">Account Setting</h4>
		<form method="post">
			<div class="setting-row">
				<span>Sub users</span>
				<input type="checkbox" id="switch66" /> 
				<label for="switch66" data-on-label="ON" data-off-label="OFF"></label>
			</div>
			<div class="setting-row">
				<span>personal account</span>
				<input type="checkbox" id="switch77" /> 
				<label for="switch77" data-on-label="ON" data-off-label="OFF"></label>
			</div>
			<div class="setting-row">
				<span>Business account</span>
				<input type="checkbox" id="switch88" /> 
				<label for="switch88" data-on-label="ON" data-off-label="OFF"></label>
			</div>
			<div class="setting-row">
				<span>Show me online</span>
				<input type="checkbox" id="switch99" /> 
				<label for="switch99" data-on-label="ON" data-off-label="OFF"></label>
			</div>
			<div class="setting-row">
				<span>Delete history</span>
				<input type="checkbox" id="switch101" /> 
				<label for="switch101" data-on-label="ON" data-off-label="OFF"></label>
			</div>
			<div class="setting-row">
				<span>Expose author name</span>
				<input type="checkbox" id="switch111" /> 
				<label for="switch111" data-on-label="ON" data-off-label="OFF"></label>
			</div>
		</form>
	</div><!-- side panel -->		
	


@endsection

@section('modal')

@endsection

@section('script')
@parent
	<script>
		var page_name = "profile";
		var savedQuestions = '{{ $user->savedQuestions }}';
		var user_id = {{ $user->id  }};
	</script>
    <script src=" {{ asset('js/select2.min.js') }} "></script>
	<script src=" {{ asset('js/comments.js') }} "></script>
	<script src=" {{ asset('js/courses.js') }} "></script>
	<script src="{{ asset('js/profile.js') }}"></script>
@endsection