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
								<div class="central-meta text-center header_course" style="padding-bottom: 90px">
                                    <div class="text-left">
                                        <a href="#" onclick="history.back()" class="btn btn-success mt-2" style="width: 15%"> <i class="fa-solid fa-circle-left"></i> Back </a><br/>
                                        <a href="#" class="btn btn-primary mt-2" style="width: 15%" data-toggle="modal" data-target=".resources"> <i class="fa-solid fa-table-cells"></i> Show resources </a><br/>
                                        <a href="#" class="btn btn-info mt-2" style="width: 15%" data-toggle="modal" data-target=".share_resource"> <i class="fa-solid fa-share-nodes"></i> Share a resource </a><br/>
                                        <a href="{{ route('users.chatWithSupervisor' , $course->id) }}" class="btn btn-warning text-white mt-2" style="width: 15%"> <i class="fa-regular fa-comment-dots"></i> Chat with supervisor </a><br/>
                                       
                                    </div>
                                    <h1 class="text-black" style="font-size: 50px; margin-top: -110px;"><u><i class="fa-solid fa-book-open mr-2"></i>{{ $course->name }}</u></h1>
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
                                                                <b><i class="fa-solid fa-book"></i> Course : {{ $course->name }} </b>
                                                            </li>
                                                            <li>
                                                                <b><i class="fa-solid fa-building-columns"></i> College : {{ $course->college->name }} </b>
                                                            </li>
                                                            <li>
                                                                <b><i class="fa-solid fa-circle-question"></i> Questions count : {{ $course->questions->count() }} </b>
                                                            </li>
                                                            <li>
                                                                <b><i class="fa-solid fa-calendar-days"></i> Date created :  {{ date('d-m-Y', strtotime($course->created_at)) }} </b>
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
                                                                <input type="hidden" name="course" value="{{ $course->id }}">
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

@section('modal')

<div class="modal fade resources" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content p-3" style="margin-top: 60px;">
        <h2> <i class="fa-solid fa-table-cells"></i> Resources </h2>
        <table class="table text-center">
            <thead>
              <tr>
                <th scope="col"></th>
                <th class="w-50" scope="col">Title</th>
                <th scope="col">File</th>
              </tr>
            </thead>
            <tbody>
            @php
                $resources = \App\Models\Resource::where('course_id',$course->id)->get();
                $i = 0;
            @endphp
            @foreach ($resources as $resource)
                @php
                    $data = json_decode( $resource->sharedFrom );
                @endphp
                @if ( isset($data) && $data->accepted == 0 )
                    @continue
                @endif

                <tr>
                    <th scope="row">{{ ++$i }}</th>
                    <td>{{ $resource->title }}</td>
                    <td>
                        <a href="/storage/{{ $resource->file }}" target="_blank" class="text-info mr-3"><i class="fa-solid fa-eye"></i> Preview </a>
                        <a href="/storage/{{ $resource->file }}" target="_blank" download="file" class="text-primary"><i class="fa-solid fa-file"></i> Download </a>
                    </td>
                </tr> 
            @endforeach
          

            </tbody>
          </table>
      </div>
    </div>
</div>

  
<div class="modal fade share_resource" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content p-3" style="margin-top: 60px;">
        <h2> <i class="fa-solid fa-share-nodes"></i> Share a resource </h2>
        <hr>
        <div class="mt-1">
            <form id="setResource" action="{{ route('courses.setResource', $course->id) }}" method="POST">
                @csrf
                <div class="">
                    <label for="recipient-name" class=""> Title </label>
                    <input type="text" id="title" name="title" class="form-control" id="recipient-name">
                </div>
                <div class="mt-3">
                    <label for="message-text" class="">File</label>
                    <input type="file" id="link" name="file" placeholder="http://www.test.com/file" class="form-control">
                </div>
                <div class="mt-4 float-right w-100">
                    <button class="btn btn-success w-100"><i class="fa-solid fa-arrow-up-from-bracket"></i> Send</button>
                </div>
                <div class="mt-5">
                    <b>When you send this file, it will reach the supervisor for this course, and after approval, it will appear to everyone.</b>
                </div>
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}

                <div class="alert alert-danger" style="display: none;" id="errorsR">
                </div>
            </form>
        </div>
      </div>
    </div>
</div>

@endsection


@section('script')
@parent
    <script src=" {{ asset('js/colleges.js') }} "></script>
    <script src=" {{ asset('js/questions.js') }} "></script>
    <script src=" {{ asset('js/comments.js') }} "></script>
    <script>
        var course = {{ $course->id }};
        var user_id = {{ auth()->user()->id  }};
        var savedQuestions = '{{ auth()->user()->savedQuestions }}';
        var count_comments = 0;
    </script>
@endsection