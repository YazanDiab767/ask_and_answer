@extends('layouts.header')

@section('title','Control Panel - Users')

@section('style')
@parent
    <link rel="stylesheet" href="{{ asset('css/control_panel/all.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@endsection


@section('body')
<div class="theme-layout">
	<section>
		<div class="gap gray-bg">
			<div class="container-fluid">
				<div class="row justify-content-center">
					<div class="col-lg-12">
						<div class="row justify-content-center" id="page-contents">
							<div class="col-lg-11">
								<div class="central-meta text-center">
                                    <h2 class="f-title" style="font-size: 25px"><i class="fa-solid fa-users text-black" style="font-size: 25px"></i> Users ( {{ \App\Models\User::count() }} ) </h2>

                                    <div class="card-body">

                                        <div class="text-left mt-5">
                                            <div class="row">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text bg-white"><i class="fas fa-search text-primary"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="inputSearch" placeholder="Please enter username or university ID" aria-label="Username" aria-describedby="basic-addon1">
                                            </div>
                                            
                                        </div>
                                  
                                        <div class="table-responsive mt-5">
                                            <table class="table table-striped text-center" id="cs">
                                                <thead>
                                                    <tr>
                                                        <th>  </th>
                                                        <th> <b> Name </b> </th>
                                                        <th> <b> Email </b>  </th>
                                                        <th> <b> County </b>  </th>
                                                        <th> <b> Role </b>  </th>
                                                        <th> <b> Date created </b>  </th>
                                                        <th>  </th>
                                                        <th>  </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="users">
                                                    @include('control_panel.layouts.users')
                                                </tbody>
                                            </table>
                                        </div>

                                        @if (\App\Models\User::all()->count() > \App\Models\User::$paginate)
                                        <div class="row justify-content-center mt-3" id="formShowMoreUser">
                                            <button class="btn btn-success w-25" id="showMoreUsers"> <i class="fa-solid fa-caret-down"></i>  Show more </button>
                                        </div>
                                    @endif
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
<div class="modal modalSupervisor" id="modalSupervisor" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <i class="fa-solid fa-key"></i> Permissions </h5>
                <div class="float-left">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
 
            <div class="modal-body">
                <form action="" id="formSetPermissions" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="">
                        <label style="display: flex;align-items: center;"><input type="checkbox" name="colleges" id="check_colleges" class="mr-1" style="flex: none; height: 25px; width: 25px;"  /> Colleges </label>
                    </div>
                    <div class="mt-4">
                        <label style="display: flex;align-items: center;"><input type="checkbox"  name="questions_complaints" id="check_questions_complaints"  class="mr-1" style="flex: none; height: 25px; width: 25px;"  /> Questions And Complaints </label>
                    </div>
                    <div class="mt-4">
                        <label style="display: flex;align-items: center;"><input type="checkbox" name="course" id="check_course" class="mr-1" style="flex: none; height: 25px; width: 25px;"  /> Course </label>
                        <div>
                            <select class="form-control" id="course_id" name="course_id">
                                <option>Select Course</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }} / {{ $course->college->name }}</option>
                                @endforeach
                            </select> 
                            {{-- <select class="mt-2" id="course_id" name="course_id">
                                <option> Select course </option>
                            </select>  --}}
                        </div>
                    </div>
                </form>
            </div>
            <br/>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-primary" id="btnSetPermissions"> <i class="fas fa-save"></i>  Save  </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fa-solid fa-xmark"></i>  Close </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
@parent
	<script src="{{ asset('js/control_panel/all.js') }}"></script>
    <script src="{{ asset('js/control_panel/users.js') }}"></script>
    <script>
        var colleges_count = 0;
    </script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src=" https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
@endsection
