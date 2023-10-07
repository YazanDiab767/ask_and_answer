@extends('layouts.header')

@section('title','CampusLink - ' . $course->name )

@section('style')
@parent
    <link rel="stylesheet" href="{{ asset('css/colleges.css') }}">
@endsection

@section('body')

<div class="theme-layout">
	<section>
		<div class="gap gray-bg" style="padding: 1px">
			<div class="container-fluid">
				<div class="row justify-content-center">
					<div class="col-lg-12">
						<div class="row justify-content-center" id="page-contents">
							<div class="col-lg-11" >
								<div class="central-meta text-center">
                                    <div class="text-left">
                                        <a href="#" onclick="history.back()" class="btn btn-success" style="width: 15%"> <i class="fa-solid fa-circle-left"></i> Back </a><br/>
                                        <a href="#" class="btn btn-primary mt-2" style="width: 15%" data-toggle="modal" data-target=".resources"> <i class="fa-solid fa-table-cells"></i> Show resources </a>
                                    </div>
                                    <h1 class="text-black" style="font-size: 35px; margin-top: -65px;"><u><i class="fa-solid fa-book-open mr-2"></i>{{ $course->name }}</u></h1>
								</div>
							</div>

                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col-sm-11">
                                        <div class="row" id="page-contents">
                                            <div class="col-sm-3">
                                                <aside class="sidebar static w-100">
                                                    <div class="widget" > {{--style="background-color: #088dcd; color: white;"--}}
                                                        <h3 class="widget-title"><i class="fa-solid fa-circle-info"></i> Info</h3>
                                                        <ul class="naves">
                                                            <li>
                                                                <b>- Course : {{ $course->name }} </b>
                                                            </li>
                                                            <li>
                                                                <b>- College : {{ $course->college->name }} </b>
                                                            </li>
                                                            <li>
                                                                <b>- Questions count : {{ $course->questions->count() }} </b>
                                                            </li>
                                                            <li>
                                                                <b>- Date created :  {{ date('d-m-Y', strtotime($course->created_at)) }} </b>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </aside>
                                            </div>

                                            <div class="col-sm-9">
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
				</div>
			</div>
		</div>	
	</section>
</div>

@endsection

@section('modal')
<div class="modal fade resources" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content p-3" style="margin-top: 60px;">
        <h2> <i class="fa-solid fa-table-cells"></i> Resources </h2>
        <table class="table">
            <thead>
              <tr>
                <th scope="col"></th>
                <th scope="col">Title</th>
                <th scope="col">File</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>Exam 2019</td>
                <td><a href="#" class="text-primary"><i class="fa-solid fa-file"></i> Download </a></td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>Book of material</td>
                <td><a href="#" class="text-primary"><i class="fa-solid fa-file"></i> Download </a></td>
              </tr>
            </tbody>
          </table>
      </div>
    </div>
  </div>
@endsection

@section('script')
@parent
    <script src=" {{ asset('js/colleges.js') }} "></script>
@endsection