@extends('layouts.header')

@section('title','Control Panel - Courses')

@section('style')
@parent
    <link rel="stylesheet" href="{{ asset('css/control_panel/all.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@endsection


@section('body')
@php $count = 1; @endphp
<div class="theme-layout">
	<section>
		<div class="gap gray-bg">
			<div class="container-fluid">
				<div class="row justify-content-center">
					<div class="col-lg-12">
						<div class="row justify-content-center" id="page-contents">
							<div class="col-lg-11">
								<div class="central-meta text-center">
                                    <h2 class="f-title" style="font-size: 25px"><i class="fa-solid fa-book text-black" style="font-size: 25px"></i> Courses ( {{ \App\Models\Course::all()->count() }} ) </h2>

                                    <div class="card-body">
                                        @php
                                            $permissions = json_decode(auth()->user()->permissions , JSON_FORCE_OBJECT ) ;
                                            $id_course = 0;
                                            if ( isset( $permissions["course"] ) && auth()->user()->role == 'supervisor' )
                                            {
                                                $id_course = $permissions["course"];
                                            }
                                                
                                        @endphp
                                        @if ( $id_course == 0 )
                                            <div class="row">
                                                <div class="col-sm-4 text-left">
                                                    <button class="btn btn-primary" id="btnAddNewCourse" data-toggle="modal" data-target=".newCourse"> <i class="fa-solid fa-plus"></i> Add new course </button>
                                                </div>
                                            </div>
                                            
                                            <div class="text-left mt-4">
                                                <select class="form-control" id="college_id" name="college_id">
                                                    @foreach ($colleges as $college)
                                                        <option value="{{ $college->id }}">{{ $college->name }}</option>
                                                    @endforeach
                                                </select> 
                                                <div class="input-group mb-3 mt-3">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text bg-white"><i class="fas fa-search text-primary"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="searchInput" placeholder="Please enter course name" aria-label="Username" aria-describedby="basic-addon1">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="table-responsive mt-5">
                                            <table class="table table-striped text-center" id="cs">
                                                <thead>
                                                    <tr>
                                                        <th>  </th>
                                                        <th> <b> Course Name </b> </th>
                                                        <th>  </th>
                                                        <th>  </th>
                                                        <th>  </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="courses">
                                                    @if ( $id_course != 0 )
                                                        @php
                                                            $courses = [\App\Models\Course::find( $id_course )];
                                                        @endphp
                                                    @endif
                                                    @foreach ( $courses as $course )
                                                        <tr class="row_course">
                                                            <td class="align-middle"> {{ $count }} </td>
                                                            <td class="align-middle"> {{ $course->name }}  </td>
                                                            <td class="align-middle" style="width: 12%;"> <a href="#" class="btn btn-info btnShowresources w-100" data-toggle="modal" data-target=".divResources" > <i class="fa-solid fa-swatchbook"></i> Resources  </a> </td>
                                                            <td class="align-middle" style="width: 12%;"> <a href="{{$course->id}}/{{$course->name}}/{{ $count++ }}/{{$course->college->id}}" class="btn btn-success btnEditCourse w-100" data-toggle="modal" data-target=".editCourse" > <i class="fas fa-edit"></i> Edit  </a> </td>
                                                            <td class="align-middle" style="width: 12%;">
                                                                <form action="{{ route('courses.destroy',$course->id) }}" class="formDeleteCourse" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="btn btn-danger text-white delete_college w-100"> <i class="fas fa-trash"></i> Delete  </button>
                                                                </form>
                                                            </td>
                                                        </tr>  
                                                    @endforeach
                                                </tbody>
                                            </table>
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

{{-- Form Add New Course --}}
<div class="modal fade newCourse" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <i class="fa-solid fa-plus"></i> Add new course </h5>
                <div class="float-left">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <form action="{{ route('courses.store') }}" id="formAddCourse" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label> Course name : </label>
                        <input type="text" class="form-control name" name="name" placeholder="course name"/>
                    </div>
                    <div class="mt-4">
                        <label> College  : </label>
                        <select class="form-control" name="college_id">
                            @foreach ($colleges as $college)
                                <option value="{{ $college->id }}">{{ $college->name }}</option>
                            @endforeach
                        </select> 
                    </div>
                </form>
            </div>
            <br/>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-primary" id="addCourse"> <i class="fas fa-save"></i>  Add  </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fa-solid fa-xmark"></i>  Close </button>
            </div>
        </div>
    </div>
</div>

{{-- Form Edit Course --}}
<div class="modal fade editCourse" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <i class="fa-solid fa-edit"></i> Edit Course </h5>
                <div class="float-left">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <form action="" id="formUpdateCourse" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div>
                        <label> Course name : </label>
                        <input type="text" class="form-control name" id="course_name" name="name" placeholder="course name"/>
                    </div>
                    <div class="mt-4">
                        <label> College  : </label>
                        <select class="" id="edit_college_id" name="college_id" >
                            @foreach ($colleges as $college)
                                <option value="{{ $college->id }}">{{ $college->name }}</option>
                            @endforeach
                        </select> 
                    </div>
                </form>
            </div>
            <br/>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-success" id="updateCourse"> <i class="fas fa-save"></i>  Save  </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fa-solid fa-xmark"></i>  Close </button>
            </div>
        </div>
    </div>
</div>

{{-- Resources --}}
<div class="modal fade divResources" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titleDiv"> Resources - Course 1 </h5>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center mt-5">
                    <table class="table table-bordered w-100 text-center">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>File</th>
                                <th>Supervisor name</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="resources">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer text-center" >
                <div class="row w-100 justify-content-center">
                    <div class="col-sm-3">
                        <button class="btn btn-success btnAddNewResource text-white" data-toggle="modal" data-target="#newResource"> + Add New Resource </button>
                    </div>
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-secondary btnCloseResources" data-dismiss="modal"> X Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add New Resources --}}
<div class="modal fade" id="newResource"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" > Add New Resource </h5>
        </div>
        <div class="modal-body">
        <form id="setResource" method="POST" class="">
            @csrf
            <div class="">
                <label for="recipient-name" class=""> Title </label>
                <input type="text" id="title" name="title" class="form-control" id="recipient-name">
            </div>
            <div class="mt-3">
                <label for="message-text" class="">File</label>
                <input type="file" id="link" name="file" placeholder="http://www.test.com/file" class="form-control">
            </div>
            <div class="alert alert-danger" style="display: none;" id="errorsR">
            </div>
        </form>
        </div>
        <div class="modal-footer text-center" >
            <button type="button" class="btn btn-primary ml-4" id="btn_addResource">Add</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>


@endsection

@section('script')
@parent
	<script src="{{ asset('js/control_panel/all.js') }}"></script>
    <script src="{{ asset('js/control_panel/courses.js') }}"></script>
    <script>
        var courses_count = {{ $count }};
    </script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src=" https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
@endsection
