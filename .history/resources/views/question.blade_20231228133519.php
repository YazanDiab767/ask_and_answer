@extends('layouts.header')

@section('title','Question' )

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
								<div class="central-meta text-center p-5">
                                    <div class="text-left">
                                        <a href="#" onclick="history.back()" class="btn btn-success" style="width: 15%"> <i class="fa-solid fa-circle-left"></i> Back </a><br/>
                                    </div>
                                    <h1 class="text-black" style="font-size: 35px; margin-top: -65px;">
                                        <u>
                                            <i class="fa-solid fa-circle-question"></i>
                                            
                                            @if ( isset( $course ) )
                                                {{$course->college->name}}/{{$course->name}}
                                            @else
                                                {{$major->college->name}}/{{$major->name}} MAJOR
                                            @endif
                                        </u>
                                    </h1>
								</div>
							</div>

                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col-sm-11">
                                        <div class="row" id="page-contents">
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-8">
                                                <div id="" class="loadMore">
                                                    <div class="central-meta item">
                                                        <div class="user-post">
                                                            <div class="friend-info">
                                                                <figure>
                                                                    <img src="/storage/{{$question->user->image}}" alt="">
                                                                </figure>
                                                                <div class="dropdown float-right">
                                                                    <a href="#" class="" data-toggle="dropdown"><i class="fa-solid fa-ellipsis-vertical text-primary"></i></a>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                        @php
                                                                            $savedQuestions = explode(',', auth()->user()->savedQuestions);
                                                                        @endphp
                                                                        @if (in_array($question->id,$savedQuestions))
                                                                            <a class="dropdown-item text-success unsaveQuestion" href="{{ $question->id }}"> <i class="fa-regular fa-bookmark"></i> Unsave </a>
                                                                        @else
                                                                            <a class="dropdown-item text-success saveQuestion" href="{{ $question->id }}"> <i class="fa-solid fa-bookmark"></i> Save </a>
                                                                        @endif
                                                                        <a class="dropdown-item text-warning" href="#" data-toggle="modal" data-target=".modalReport"><i class="fa-solid fa-bug"></i> Report</a>
                                                                        @if ( auth()->user()->id == $question->user->id )
                                                                            @if ( $question->stop_comments == 0)
                                                                                <a class="dropdown-item text-primary btnToggleComments" href="{{ $question->id }}"><i class="fa-solid fa-stop"></i> Stop comments</a>
                                                                            @else
                                                                                <a class="dropdown-item text-primary btnToggleComments" href="{{ $question->id }}"><i class="fa-solid fa-play"></i> Run comments</a>
                                                                            @endif
                                                                            <a class="dropdown-item text-danger btnDeleteQuestion" href="{{ $question->id }}"><i class="fa-solid fa-trash-can"></i> Delete </a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            
                                                                
                                                                <div class="friend-name">
                                                                    <ins><a href="time-line.html" title="">{{$question->user->name}}</a></ins>
                                                                    <span><i class="fa-solid fa-calendar-days"></i> published: {{ $question->created_at }}</span>
                                                                </div>
                                                                <div class="post-meta">
                                                                    <div class="description">
                                                                        <p>
                                                                            {{ $question->text}}
                                                                        </p>
                                                                        @if ($question->image != "--")
                                                                        <img src = "/storage/{{$question->image}}" class="mt-2" style="max-width: 250px; max-height: 250px;" />
                                                                        @endif
                                                                    </div>
                                                                    <div class="we-video-info">
                                                                        <ul>
                                                                            <li>
                                                                                <span class="views" data-toggle="tooltip" title="views">
                                                                                    <i class="fa fa-eye"></i>
                                                                                    <ins>1</ins>
                                                                                </span>
                                                                            </li>
                                                                            <li>
                                                                                <span class="comment" data-toggle="tooltip" title="Comments">
                                                                                    <i class="fa-solid fa-comments"></i>
                                                                                    <ins id="count_comments"></ins>
                                                                                </span>
                                                                            </li>
                                                                            @php
                                                                                $likes = 0;
                                                                                $dislikes = 0;
                                                                                if ( count($question->likes) > 0 )
                                                                                {
                                                                                    for ( $i = 0; $i < count($question->likes); $i++ )
                                                                                    {
                                                                                        if ( $question->likes[$i]->type == 'like' )
                                                                                            $likes++;
                                                                                        else
                                                                                            $dislikes++;
                                                                                    }
                                                                                }
                                                                            @endphp
                                                                            <li>
                                                                                <span class="like" data-toggle="tooltip" title="like">
                                                                                    <i class="fa-solid fa-thumbs-up"></i>
                                                                                    <ins>{{$likes}}</ins>
                                                                                </span>
                                                                            </li>
                                                                            <li>
                                                                                <span class="dislike" data-toggle="tooltip" title="dislike">
                                                                                    <i class="fa-solid fa-thumbs-down"></i>
                                                                                    <ins>{{$dislikes}}</ins>
                                                                                </span>
                                                                            </li>
                                                                        
                                                                        </ul>
                                                                    </div>
                                            

                                                                
                                                                </div>
                                                            </div>

                                                            <hr>

                                                            <div class="coment-area">
                                                                <ul class="we-comet" id="comments">
                                                                    
                                                                </ul>
                                                                <ul class="we-comet">
                                                                    <li>
                                                                        <a href="#" id="btnGetMoreComment" class="showmore underline btnGetMoreComment">more comments</a>
                                                                    </li>
                                                                    @if ( $question->stop_comments == 0 )
                                                                        <li class="post-comment">
                                                                            <div class="">
                                                                                <form id="formAddComment" action="{{ route('question.addComment' , $question->id ) }}" method="post">
                                                                                    <div id="divReplyUser">
                                                                                        <label class="text-info"> <b><i class="fa-solid fa-at"></i> Reply to: <span id="reply_username"></span> </b> </label>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-sm-1 float-right">
                                                                                            <img src="/storage/{{  auth()->user()->image }}" style="min-width: 50px; min-height: 50px; max-width: 50px; max-height: 50px; border-radius: 30px;">
                                                                                        </div>
                                                                                        <div class="col-sm-11 float-left">
                                                                                            <textarea class="form-control w-100" id="text" name="text" placeholder="Write your comment"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="float-right mt-1">
                                                                                        <a id="btnAddImageToComment" style="cursor: pointer;" class="mr-3" >
                                                                                            <i class="fa fa-image"></i>
                                                                                        </a>
                                                                                        <a id="btnSendComment" style="cursor: pointer;">
                                                                                            <i class="fa-solid fa-share"></i>
                                                                                        </a>
                                                                                    
                                                                                    </div>
                                                                                    <input type="file" class="d-none" name="image" id="image">
                                                                                </form>	
                                                                                <div id="result_form_question" class="text-left">
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    @else
                                                                        <div class="alert alert-warning">
                                                                            <i class="fa-solid fa-lock"></i> The author of the question has closed comments on this question
                                                                        </div>
                                                                    @endif
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
	</section>
</div>

@endsection

@section('modal')
<div class="modal fade modalReport" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content p-4">
        <h4> <i class="fa-solid fa-triangle-exclamation"></i> Report to this question : </h4>
        <hr>
        <form action="{{ route('complaints.add', $question->id) }}" class="mt-1" id="formSendComplaint" method="POST">
            <div class="">
                <span>Type:</span>
                <select name="type" class="form-control">
                    @foreach (\App\Models\Complaint::$types as $item)
                        <option value="{{$item}}">{{$item}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-3">
                <span>Text:</span>
                <textarea class="form-control" name="text"></textarea>
            </div>
            <div class="float-right mt-3">
                <button class="btn btn-danger w-100">Send</button>
            </div>
        </form>
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
        var question = {{ $question->id }};
        var user_id = {{ auth()->user()->id }};
        var count_comments = {{count($question->comments)}};
        var savedQuestions = '{{ auth()->user()->savedQuestions }}';
        var page_name = "question";
        @if( isset( $course ) )
              var course = {{ $course->id }};

        @else
        var majorQ = true;
        @endif
    </script>

@endsection