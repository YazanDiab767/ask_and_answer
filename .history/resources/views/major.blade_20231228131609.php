@extends('layouts.header')

@section('title','CampusLink - ' . $major->name )

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
							<div class="col-lg-11 " >
								<div class="central-meta text-center header_major" style="padding-bottom: 90px">
                                    <div class="text-left">
                                        <a href="#" onclick="history.back()" class="btn btn-success mt-2" style="width: 15%"> <i class="fa-solid fa-circle-left"></i> Back </a><br/>                                       
                                    </div>
                                    <h1 class="text-black" style="font-size: 50px; margin-top: -40px;"><u class="text-white"><i class="fa-solid fa-cog mr-2"></i>{{ $major->name }} - Major</u></h1>
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
                                                                <b><i class="fa-solid fa-book"></i> Major : {{ $major->name }} </b>
                                                            </li>
                                                            <li>
                                                                <b><i class="fa-solid fa-building-columns"></i> College : {{ $major->college->name }} </b>
                                                            </li>
                                                            <li>
                                                                <b><i class="fa-solid fa-circle-question"></i> Questions count : {{ $major->questions->count() }} </b>
                                                            </li>
                                                            <li>
                                                                <b><i class="fa-solid fa-calendar-days"></i> Date created :  {{ date('d-m-Y', strtotime($major->created_at)) }} </b>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </aside>
                                            </div>

                                            <div class="col-sm-9">
                                                <div class="central-meta">
                                                    <div class="new-postbox">
                                                        <figure>
                                                            <img src="/storage/{{  auth()->user()->image }}" style="min-width: 100px; min-height: 100px; max-width: 100px; max-height: 100px;">
                                                        </figure>
                                                        {{-- form post --}}
                                                        <div class="newpst-input">
                                                            <form action="{{ route('questions.store') }}" method="POST" id="form_new_question" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="course" value="{{ $major->id }}">
                                                                <textarea rows="2" placeholder="Write a text of question" name="text" required></textarea>

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
                                                                                <input type="file" name="image" id="image">
                                                                            </label>
                                                                        </li>
                                                                        <li>
                                                                            <button type="submit">Post</button>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                                <div id="result_form_question" class="text-left">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="posts" class="loadMore">
                                                                                  
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
		</div>	
	</section>
</div>

@endsection



@section('script')
@parent
    {{-- <script src=" {{ asset('js/colleges.js') }} "></script>
    {{-- <script src=" {{ asset('js/questions.js') }} "></script> --}}
    <script src=" {{ asset('js/comments.js') }} "></script>
    {{-- <script>
        // var course = {{ $major->id }};
        var user_id = {{ auth()->user()->id  }};
        var savedQuestions = '{{ auth()->user()->savedQuestions }}';
        var count_comments = 0;
    </script>  --}}
@endsection