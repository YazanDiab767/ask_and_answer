@extends('../layouts.header')

@section('title','CampusLink - Workspace')

@section('style')
@parent
<link rel="stylesheet" href="{{ asset('css/workspace.css') }}">
@endsection

@section('body')

<div class="theme-layout">
	<section>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="central-meta text-center">
                        <h2 class="text-black pb-2" style="font-size: 40px;"> <i class="fa-solid fa-network-wired" style="font-size: 28px"></i> <u> Workspace </u> </h2>
                        <hr style="border-bottom: 1px solid white;">
                        <div class="mt-5">
                            <h4><i class="fa-solid fa-code-fork"></i> Your workspaces ( <span id="count"></span> )</h4>
                            <a href="#" class="text-warning" data-target=".new_workspace" data-toggle="modal" > <i class="fa-solid fa-square-plus"></i> Create New Workspace </a>
                            <div>
                                <ul id="workspaces" class="nearby-contct" style="width: 65%;">
    
                                </ul>
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

<div class="modal fade new_workspace" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content p-3" style="margin-top: 60px;">
        <h2> <i class="fa-solid fa-plus"></i> Create new workspace </h2>
        <hr style="border-bottom: 1px solid black;">
        <form id="addNewWorkspace" action="{{ route('workspace.add') }}" method="POST">
            @csrf
            <div class = "">
                <label for = "workspaceName">Workspace name: </label>
                <input type = "text" name="name" class = "form-control" id = "workspaceName" placeholder = "Please enter workspace name">
             </div> 
             <div class = "mt-5 float-right">
                <button class="btn btn-success"><i class="fa-solid fa-plus"></i> Create</button>
             </div> 
             <div id="result"></div>
        </form>
    </div>
    </div>
</div>

@endsection

@section('script')
@parent
<script src=" {{ asset('js/workspace/index.js') }} "></script>
<script>
    var user_id = {{ auth()->user()->id }};
    var count = {{\App\Models\Workspace::where('user_id' , auth()->user()->id )->orWhere('members' , 'LIKE' , '%' . auth()->user()->email . '%')->count();}};
</script>
@endsection