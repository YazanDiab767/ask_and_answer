@extends('layouts.header')

@section('title','CampusLink - Colleges')

@section('style')
@parent
    <link rel="stylesheet" href="{{ asset('css/colleges.css') }}">
@endsection

@section('body')
@php
    //get supervisor of this course:
    $supervisor_name = "There is no supervisor";
    foreach (\App\Models\User::all() as $user)
    {
        if ( isset( $user->permissions ) )
        {
            $permissions =  json_decode($user->permissions);
            if ( isset( $permissions->course ) && in_array( $course->id ,  $permissions->course  )  )
                $supervisor_name = $user->name;
        }
    }
@endphp

<div class="theme-layout">

    <div class="gap gray-bg" style="padding: 20px !important;">
        <div class="container-fluid">
            <div class="row" id="page-contents">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <div class="central-meta">
                        <div class="messages" >
                            @if ( isset( $student ) )
                                <h5 class="f-title"><i class="fa-solid fa-comments"></i> Chat with student - <b> <i class="fa-solid fa-user"></i> {{ $student->name }} </b> </h5>
                            @else
                                <h5 class="f-title"><i class="fa-solid fa-comments"></i> Chat with supervisor of {{ $course->name }} - <b> <i class="fa-solid fa-user-gear"></i> {{ $supervisor_name }} </b> </h5>
                            @endif
                            <div class="message-box pb-2">
                            
                                <div class="row justify-content-center">
                                    <a href="#" id="btnGetMoreMessages" class="showmore underline btnGetMoreMessages"> <i class="fa-solid fa-circle-chevron-down fa-flip-vertical"></i> more messages</a>
                                </div>

                                <div class="peoples-mesg-box w-100" >
                                    <ul class="chatting-area p-5" style="min-height: 450px;" >
                            
                                      
                                    </ul>

                                    <div class="message-text-container" >
                                        <hr>
                                        <form id="formSendMessage" method="post">
                                            <input type="text" name="text" id="text" placeholder="Please write your message ..." class="form-control" style="width: 95%; border-radius: 20px">
                                            <button title="send" class="ml-5" ><i class="fa fa-paper-plane"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>	
                </div><!-- centerl meta -->
            </div>	
        </div>
    </div>	

</div>

@endsection

@section('script')
@parent
<script src="{{ asset('js/chatWithSupervisor.js') }}"></script>
<script>
    var course_id = {{ $course->id }};
    var user_image = "{{ auth()->user()->image }}";
    var type = "@if(isset( $student ))supervisor @endif"; // user => student or supervisor
    var user = "@if(isset( $student )){{$student->id}}@else{{auth()->user()->id}}@endif"; 
</script>
@endsection