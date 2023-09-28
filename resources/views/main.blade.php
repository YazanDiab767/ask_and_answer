@extends('layouts.header')

@section('title','Ask and answer An-Najah University students')

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
												<a href="newsfeed.html" title="">News feed</a>
											</li>
											<li>
												<i class="fa-solid fa-address-card"></i>
												<a href="fav-page.html" title="">My profile</a>
											</li>
											<li>
												<i class="fa-solid fa-building"></i>
												<a href="timeline-friends.html" title="">Colleges</a>
											</li>
											<li>
												<i class="fa-solid fa-chart-line"></i>
												<a href="timeline-friends.html" title="">Activites</a>
											</li>
											<li>
												<form id="logout-form" action="{{ route('logout') }}" method="POST">
													@csrf
													<i class="fa-solid fa-right-from-bracket"></i>
													<a href="#" id="btnLogout"> Logout </a>
												</form>
											</li>
										</ul>
									</div>

									<div class="widget">
										<h4 class="widget-title">Recent Activity</h4>
										<ul class="activitiez">
											<li>
												<div class="activity-meta">
													<i>10 hours Ago</i>
													<span><a href="#" title="">Commented on Video posted </a></span>
													<h6>by <a href="time-line.html">black demon.</a></h6>
												</div>
											</li>
											<li>
												<div class="activity-meta">
													<i>30 Days Ago</i>
													<span><a href="#" title="">Posted your status. “Hello guys, how are you?”</a></span>
												</div>
											</li>
											<li>
												<div class="activity-meta">
													<i>2 Years Ago</i>
													<span><a href="#" title="">Share a video on her timeline.</a></span>
													<h6>"<a href="#">you are so funny mr.been.</a>"</h6>
												</div>
											</li>
										</ul>
									</div>

								</aside>
							</div>

							
							<div class="col-lg-6">
								<div class="central-meta">
									<div class="new-postbox">
										<figure>
											<img src="{{ asset('images/user.png') }}" alt="">
										</figure>
										<div class="newpst-input">
											<form method="post">
												<textarea rows="2" placeholder="write a new question"></textarea>

												<div class="attachments">
													<ul>
														<li>
															<i class="fa fa-music"></i>
															<label class="fileContainer">
																<input type="file">
															</label>
														</li>
														<li>
															<i class="fa fa-image"></i>
															<label class="fileContainer">
																<input type="file">
															</label>
														</li>
														<li>
															<i class="fa-solid fa-video"></i>
															<label class="fileContainer">
																<input type="file">
															</label>
														</li>
														<li>
															<i class="fa fa-camera"></i>
															<label class="fileContainer">
																<input type="file">
															</label>
														</li>
														<li>
															<button type="submit">Post</button>
														</li>
													</ul>
												</div>
											</form>
											<select class="form-control">
												<option>Course name</option>
											</select>
										</div>
									</div>
								</div>

								<div class="loadMore">
									<div class="central-meta item">
										<div class="user-post">
											<div class="friend-info">
												<figure>
													<img src="{{ asset('images/user.png') }}" alt="">
												</figure>
												<div class="friend-name">
													<ins><a href="time-line.html" title="">Yazan Diab</a></ins>
													<span>published: june,2 2033 19:PM</span>
												</div>
												<div class="post-meta">
													<div class="description">
														<p>
															this is a test post for my new website in 2023
														</p>
													</div>
													<div class="we-video-info">
														<ul>
															<li>
																<span class="views" data-toggle="tooltip" title="views">
																	<i class="fa fa-eye"></i>
																	<ins>1.2k</ins>
																</span>
															</li>
															<li>
																<span class="comment" data-toggle="tooltip" title="Comments">
																	<i class="fa-solid fa-comments"></i>
																	<ins>52</ins>
																</span>
															</li>
															<li>
																<span class="like" data-toggle="tooltip" title="like">
																	<i class="fa-solid fa-thumbs-up"></i>
																	<ins>2.2k</ins>
																</span>
															</li>
															<li>
																<span class="dislike" data-toggle="tooltip" title="dislike">
																	<i class="fa-solid fa-thumbs-down"></i>
																	<ins>200</ins>
																</span>
															</li>
														
														</ul>
													</div>
												
												</div>
											</div>
											<div class="coment-area">
												<ul class="we-comet">
													<li>
														<div class="comet-avatar">
															<img src="{{ asset('images/user.png') }}" width="60" alt="">
														</div>
														<div class="we-comment">
															<div class="coment-head">
																<h5><a href="time-line.html" title="">Jihad</a></h5>
																<span>1 year ago</span>
																<a class="we-reply" href="#" title="Reply"><i class="fa fa-reply"></i></a>
															</div>
															<p>test a new comment .... </p>
														</div>
														<ul>
															<li>
																<div class="comet-avatar">
																	<img src="{{ asset('images/user.png') }}" width="50">
																</div>
																<div class="we-comment">
																	<div class="coment-head">
																		<h5><a href="time-line.html" title="">Yazan Diab</a></h5>
																		<span>1 month ago</span>
																		<a class="we-reply" href="#" title="Reply"><i class="fa fa-reply"></i></a>
																	</div>
																	<p>welcome to our website</p>
																</div>
															</li>
														</ul>
													</li>
										
													<li>
														<a href="#" title="" class="showmore underline">more comments</a>
													</li>
													<li class="post-comment">
														<div class="comet-avatar">
															<img src="{{ asset('images/user.png') }}" width="60">
														</div>
														<div class="post-comt-box">
															<form method="post">
																<textarea placeholder="Post your comment"></textarea>
																<button type="submit"></button>
															</form>	
														</div>
													</li>
												</ul>
											</div>
										</div>
									</div>
									</div>
							</div>
							
							<div class="col-lg-3">
								<aside class="sidebar static">
									<div class="widget">
										<h4 class="widget-title">Info</h4>	
										<div class="your-page">
											<figure>
												<a href="#" title=""><img src="{{ asset('images/user.png') }}" alt=""></a>
											</figure>
											<div class="page-meta">
												<span><i class="fa-solid fa-circle-question"></i><a href="insight.html">Questions <em>9</em></a></span>
												<span><i class="fa-solid fa-envelope"></i><a href="insight.html">Notifications <em>2</em></a></span>
											</div>
											<div class="page-likes">
												<ul class="nav nav-tabs likes-btn">
													<li class="nav-item"><a class="active" href="#link1" data-toggle="tab">likes</a></li>
													 <li class="nav-item"><a class="" href="#link2" data-toggle="tab">comments</a></li>
												</ul>
												<!-- Tab panes -->
												<div class="tab-content">
												  <div class="tab-pane active fade show " id="link1" >
													<span>884</span>
												  </div>
												  <div class="tab-pane fade" id="link2" >
													  <span>440</span>
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
												<a data-ripple="" title="" href="#">Select</a>
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
