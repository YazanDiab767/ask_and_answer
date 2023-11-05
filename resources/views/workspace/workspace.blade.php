@extends('../layouts.header')

@section('title','CampusLink - Workspace - Name')

@section('style')
@parent
<link href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.css" rel="stylesheet"/>
<link rel="stylesheet" href="{{ asset('css/workspace.css') }}">
@endsection

@section('body')

@php
    $g = 0;
    $first = 0;
    $accepted = "-";

    //check if user in this workspace
    $user = auth()->user();

    $members = json_decode( $workspace->members , JSON_FORCE_OBJECT );

    
    if ( $user->id != $workspace->user_id ) // if user not creator this workspace
    {
        if ( $members )
        {
            foreach ($members as $key => $value) 
            {
                $email = $value["email"];

                if ( $user->email == $email )
                {
                    if ( $value["accept"] == "no" || $value["accept"] == "reject"  )
                        $accepted = "no";
                    else
                        $accepted = "yes";
                }
            }

            if ( $accepted == '-' )
                echo "<script> window.location.href = '/workspace'  </script>";

        }
        else
        {
            echo "<script> window.location.href = '/workspace'  </script>";
        }
    }
    else {
        $accepted = "yes";
    }

    $all_members = array();


    if ( $members )
    {
        foreach ($members as $key => $value) 
        {
            $email = $value["email"];
            if ( $value["accept"] == "accept" )
            {
                array_push( $all_members , \App\Models\User::where('email',$email)->first() );
            }
        } 
    }


@endphp

@if ( $accepted == "yes" )

<div class="theme-layout">
	<section>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="central-meta text-center">
                        <div class="">
                            <a href="/workspace" class="float-left btn btn-info"><i class="fa-solid fa-circle-left"></i> Back</a>
                            <h2 class="text-black pb-2" style="font-size: 40px;"> <i class="fa-solid fa-network-wired" style="font-size: 28px"></i> <u> Workspace - {{ $workspace->name }} </u> </h2>
                        </div>
                        <div class="row">
                            <div class=""></div>
                            <div class="col-sm-2">
                                <a class="btn btn-warning text-white w-100" data-target=".new_work" data-toggle="modal"> <i class="fa-solid fa-upload"></i> Upload My Work  </a>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-primary text-white w-100 btnShowWorks"  data-target=".all_works" data-toggle="modal"> <i class="fa-solid fa-table"></i> All Submitted Works </a>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-danger text-white w-100" data-target=".invite" data-toggle="modal"> <i class="fa-solid fa-bullhorn"></i> Invite Someone New </a>
                            </div>
                        </div>
                        <hr style="border-bottom: 1px solid white;">
                        <div class="row mt-5">
                            <div class="col-sm-3 info">
                                <br/>
                                <div class="row justify-content-left ml-5">
                                    <h3 class="float-left"> <i class="fa-solid fa-circle-info"></i> Info </h3>
                                </div>

                                <div class="row justify-content-center mt-3">
                                    <div class="col-sm-1"><i class="fa-solid fa-network-wired"></i></div>
                                    <div class="col-sm-10 text-left"><b> name : {{ $workspace->name }}</b></div>
                                </div>
                                <div class="row justify-content-center mt-3">
                                    <div class="col-sm-1"><i class="fa-solid fa-user-pen"></i></div>
                                    <div class="col-sm-10 text-left"><b> Creator : {{ $workspace->user->name }}</b></div>
                                </div>
                                <div class="row justify-content-center mt-3">
                                    <div class="col-sm-1"><i class="fa-solid fa-calendar-days"></i> </div>
                                    <div class="col-sm-10 text-left"><b> Date Created : {{ $workspace->created_at->format('Y-m-d') }} </b></div>
                                </div>
                                <div class="row justify-content-center mt-3">
                                    <div class="col-sm-1"><i class="fa-solid fa-users"></i> </div>
                                    <div class="col-sm-10 text-left"><b> Members : {{ count($all_members) }} </b></div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-sm-10 members">
                                        @foreach ($all_members as $u)
                                            <div class="row mt-3">
                                                <div class="col-sm-3">
                                                    <img src="{{ asset('/storage/' . $u->image) }}" />
                                                </div>
                                                <div class="col-sm-9 text-left">
                                                    {{ $u->name }}
                                                    @if ( $workspace->user_id == auth()->user()->id )
                                                        <a href="{{ $u->id }}" class="btn btn-sm ml-3 btn-danger btnLeaveMember"> <i class="fa-solid fa-right-from-bracket"></i> Out </a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <br/>
                            </div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-8 news text-center">
                                <div class="messages">
                                    <div class="text-center">
                                        <h3 style="font-size: 30px;" class="f-title text-white mt-3"><i style="font-size: 30px;" class="fa-solid fa-comments text-white"></i> Chat Workspace </b> </h3>
                                        

                                        <ul class="nav nav-pills w-100">
                                            <li class="nav-item w-50">
                                              <a class="nav-link active linkChatWithAll" data-toggle="pill" href="#chatWitAll"><i class="fa-solid fa-comments"></i> Chat With All</a>
                                            </li>
                                            <li class="nav-item w-50">
                                                <a class="nav-link linkChatWithPrivate" data-toggle="pill" href="#chatWithAdmin">
                                                    <i class="fa-solid fa-comments"></i>
                                                    Chat With
                                                    @if(auth()->user()->id == $workspace->user_id)
                                                        Members
                                                    @else
                                                        Admin
                                                    @endif
                                                </a>
                                            </li>
                                        </ul>

                                    </div>
                                    <hr style="border-bottom: 1px solid white;">
                                    <div class="message-box pb-2">
                                    
                                        <div class="tab-content">
                                            <div class="tab-pane container active" id="chatWitAll">
                                                <div class="row justify-content-center">
                                                    <a href="#" id="btnGetMoreMessages" class="showmore underline btnGetMoreMessages"> <i class="fa-solid fa-circle-chevron-down fa-flip-vertical"></i> more messages</a>
                                                </div>
                                                <div class="peoples-mesg-box w-100" >
                                                    <ul class="chatting-area chatWithAll p-5" style="min-height: 450px;" >
                                                    </ul>
                                                </div>

                                                <div class="message-text-container" >
                                                    <hr>
                                                    <form id="formSendMessageToAll" action="{{ route('workspace.sendMessageToAll' , $workspace->id) }}" method="post">
                                                        @csrf
                                                        <textarea type="text" name="text" id="text" placeholder="Please write your message ..." class="form-control" style="width: 95%; border-radius: 20px"></textarea>
                                                        <button class="btn" ><i class="fa fa-paper-plane"></i></button>
                                                    </form>
                                                </div>

                                            </div>
                                            <div class="tab-pane container fade" id="chatWithAdmin">
                                                @if( auth()->user()->id == $workspace->user_id )
                                                    <div>
                                                        <select class="form-control w-100" id="selectUser">
                                                            @foreach ($all_members as $key => $value) 
                                                                @php
                                                                    if ( $g == 0 )
                                                                    {
                                                                        $first = $value->id ;
                                                                        $g++;
                                                                    }
                                                                @endphp
                                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif
                                                <div class="row justify-content-center mt-4">
                                                    <a href="#" id="" class="showmore underline"> <i class="fa-solid fa-circle-chevron-down fa-flip-vertical"></i> more messages</a>
                                                </div>
                                                <div class="peoples-mesg-box w-100" >
                                                    <ul class="chatting-area chatWithAdmin p-5" style="min-height: 450px;" >
                                                    </ul>
                                                </div>

                                                <div class="message-text-container" >
                                                    <hr>
                                                    <form id="formSendPrivateMessage" action="" method="post">
                                                        <textarea type="text" name="text" id="text" placeholder="Please write your message ..." class="form-control" style="width: 95%; border-radius: 20px"></textarea>
                                                        <button class="btn" ><i class="fa fa-paper-plane"></i></button>
                                                    </form>
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

@else

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-sm-6 accept_div text-center">
            <h3> <i class="fa-solid fa-check-double"></i> Do you agree to join this workspace? </h3>
            <div class="mt-4">
                <div class=" mt-3">
                    <b> <i class="fa-solid fa-network-wired"></i> name : {{ $workspace->name }}</b>
                </div>
                <div class="mt-3">
                    <b> <i class="fa-solid fa-user-pen"></i> Creator : {{ $workspace->user->name }}</b>
                </div>
                <div class="mt-3">
                    <b> <i class="fa-solid fa-calendar-days"></i> Date Created : {{ $workspace->created_at->format('Y-m-d') }} </b>
                </div>
                <div class="mt-3">
                    <b> <i class="fa-solid fa-users"></i>  Members : {{ count($all_members) }} </b>
                </div>
            </div>
            <div class="mt-4">
                <form action="{{ route('workspace.accept', $workspace->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-success w-25" name="submit" value="accept"><i class="fa-solid fa-circle-check"></i> Accept</button>
                    <button class="btn btn-danger w-25" name="submit" value="reject"><i class="fa-solid fa-circle-xmark"></i> Reject</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endif

@endsection

@section('modal')

<div class="modal fade new_work" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content p-3" style="margin-top: 60px;">
        <h2> <i class="fa-solid fa-upload"></i> Upload new work </h2>
        <hr style="border-bottom: 1px solid black;">
        <form action="{{ route('workspace.uploadWork' , $workspace->id) }}" method="POST" id="formUploadWork">
            <div class = "">
                <label for = "work_file">File: </label>
                <input type = "file" name="file" class = "form-control" id = "work_file">
             </div> 
             <div class = "mt-3">
                <label for = "work_file">Comment: </label>
               <textarea class="form-control" name="comment" placeholder="You can write any comment on your work"></textarea>
             </div> 
             <div class = "mt-3 float-right">
                <button class="btn btn-success"><i class="fa-solid fa-upload"></i> Upload </button>
             </div> 
        </form>
    </div>
    </div>
</div>

<div class="modal fade all_works" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content p-3" style="margin-top: 60px;">
        <h2> <i class="fa-solid fa-upload"></i> All Works </h2>
        <hr style="border-bottom: 1px solid black;">
        <div>
            <table class="table table-hover">
                <thead>
                    <th></th>
                    <th>Student name</th>
                    <th>File</th>
                    <th>Comment</th>
                    <th>Date</th>
                    <th>
                </thead>
                <tbody id="works">

                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>

<div class="modal fade invite" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content p-3" style="margin-top: 60px;">
        <h2> <i class="fa-solid fa-bullhorn"></i> Invite </h2>
        <hr style="border-bottom: 1px solid black;">
        <form method="POST" action="{{ route('workspace.invite' , $workspace->id ) }}" id="formInvite" >
            <div class = "">
                <label for = "work_file">Email(s): </label>
                <input id="emails" name="emails" type="text" class="text-black w-100" data-role="tagsinput" class="form-control" />
             </div> 
             <div class = "mt-3 float-right">
                <button class="btn btn-success"><i class="fa-solid fa-bullhorn"></i> Invite </button>
             </div> 
             <div id="result_invite"></div>
        </form>
    </div>
    </div>
</div>

@endsection

@section('script')
@parent
<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<script src=" {{ asset('js/workspace/index.js') }} "></script>
<script src=" {{ asset('js/workspace/chat.js') }} "></script>
<script>
    var count = {{ \App\Models\Workspace::where('user_id',auth()->user()->id)->count() }};
    var workspace = {{ $workspace->id }};
    var user = {{ $user->id }};
    var user_image = "{{ $user->image }}";
    var admin_workspace = {{ $workspace->user_id }};
    var sendTo = {{ $first }};
</script>
@endsection