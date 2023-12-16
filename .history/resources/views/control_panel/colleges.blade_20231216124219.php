@extends('layouts.header')

@section('title','Control Panel - Colleges')

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
                                    <h2 class="f-title" style="font-size: 25px"><i class="fa-solid fa-building-columns text-black" style="font-size: 25px"></i> Colleges ( <span id="collegesCount"></span> ) </h2>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-4 text-left">
                                                <button class="btn btn-primary" id="btnAddNewCollege" data-toggle="modal" data-target=".newCollege"> <i class="fa-solid fa-plus"></i> Add new college </button>
                                            </div>
                                        </div>

                                        <div class="text-left mt-5">
                                            <div class="row">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text bg-white"><i class="fas fa-search text-primary"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="searchInput" placeholder="Please enter collge name" aria-label="Username" aria-describedby="basic-addon1">
                                            </div>
                                            
                                        </div>
                                  
                                        <div class="table-responsive mt-5">
                                            <table class="table table-striped text-center" id="cs">
                                                <thead>
                                                    <tr>
                                                        <th>  </th>
                                                        <th> <b> Name </b> </th>
                                                        <th> <b> Image </b>  </th>
                                                        <th> <b> Count of majors </b> </th>
                                                        <th>  </th>
                                                        <th>  </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="colleges">
                                                    @php
                                                        $c = 1;
                                                    @endphp
                                                    @foreach ($colleges as $college)
                                                        <tr class="college">
                                                            <td class="align-middle"> {{ $c }} </td>
                                                            <td class="align-middle"> {{ $college->name }} </td>
                                                            <td class="align-middle"> <img class="rounded" width="150" height="100" src="{{ asset('storage/'. $college->image ) }}" /> </td>
                                                            
                                                            <td class="align-middle"><span class="count_majors">{{ count($college->majors) }}</span></td>

                                                            <td class="align-middle text-center" style="width: 12%;">
                                                                <a href="" class="btn btn-info btnShowMajors w-100" data-toggle="modal" data-target=".showMajors" > <i class="fa-solid fa-subscript"></i> Majors  </a>
                                                            </td>

                                                            <td class="align-middle text-center" style="width: 12%;">
                                                                <a href="{{$college->id}}/{{$college->name}}/{{ $c++ }}" class="btn btn-success btnEditCollege w-100" data-toggle="modal" data-target=".editCollege" > <i class="fas fa-edit"></i> Edit  </a>
                                                            </td>
                                                         
                                                            <td class="align-middle text-center" style="width: 12%;">
                                                                <form action="{{ route('colleges.destroy',$college->id) }}" class="formDeleteCollege" method="POST">
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
{{-- Form Add New College --}}
<div class="modal newCollege" id="newCollege" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <i class="fa-solid fa-plus"></i> Add new college </h5>
                <div class="float-left">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <form action="{{ route('colleges.store') }}" id="formAddCollege" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label> College name : </label>
                        <input type="text" class="form-control name" name="name" placeholder="college name"/>
                    </div>
                    <div class="mt-4">
                        <label> College image : </label>
                        <input type="file" name="image" class="form-control image" />
                    </div>
                </form>
            </div>
            <br/>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-primary" id="addCollege"> <i class="fas fa-save"></i>  Add  </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fa-solid fa-xmark"></i>  Close </button>
            </div>
        </div>
    </div>
</div>

{{-- Form Edit College --}}
<div class="modal fade editCollege" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" >
                <h5 class="modal-title"> <i class="fa-solid fa-pen-to-square"></i> College Edit </h5>
                <div class="float-left">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <form action="" id="formUpdateCollege" method="POST" class="text-right" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="text-left">
                        <label> College name : </label>
                        <input type="text" class="form-control u_name" id="collegeName" name="name" placeholder="College name"/>
                    </div>
                    <div class="text-left mt-4">
                        <label> College image : </label>
                        <input type="file" name="image" class="form-control u_image" />
                    </div>
                </form>
            </div>
            <br/>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fa-solid fa-circle-xmark"></i> Close</button>
                <button type="button" class="btn btn-success" id="updateCollege">  <i class="fas fa-save"></i> Save  </button>
            </div>
        </div>
    </div>
</div>

{{-- Form Show Majors --}}
<div class="modal showMajors" id="showMajors" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <i class="fa-solid fa-subscript"></i> Majors - <b class="titleDiv"></b> College <span class="countMajors"></span> </h5>
                {{-- <div class="float-left">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> --}}
                <div>
                    <button class="btn btn-success btnAddNewMajor text-white" data-toggle="modal" data-target="#newMajor"> + Add New Major </button>
                </div>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text bg-white"><i class="fas fa-search text-primary"></i></span>
                </div>
                <input type="text" class="form-control" id="searchInput" placeholder="Please enter collge name" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="modal-body">
                <div class="table-responsive mt-5">
                    <table class="table table-striped text-center" id="cs">
                        <thead>
                            <tr>
                                <th>  </th>
                                <th> <b> Name </b> </th>
                                <th>  </th>
                            </tr>
                        </thead>
                        <tbody id="majors">
                        </tbody>
                    </table>
                </div>
            </div>
            <br/>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fa-solid fa-xmark"></i>  Close </button>
            </div>
        </div>
    </div>
</div>

{{-- Add New Major --}}
<div class="modal fade" id="newMajor"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" > Add New Major </h5>
        </div>
        <div class="modal-body">
        <form id="setMajor" method="POST" class="">
            @csrf
            <div class="">
                <label for="recipient-name" class=""> Name </label>
                <input type="text" id="name" name="name" class="form-control">
            </div>
            <div class="alert alert-danger" style="display: none;" id="errorsR">
            </div>
        </form>
        </div>
        <div class="modal-footer text-center" >
            <button type="button" class="btn btn-primary ml-4" id="btn_addMajor">Add</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>

@endsection

@section('script')
@parent
	<script src="{{ asset('js/control_panel/all.js') }}"></script>
    <script src="{{ asset('js/control_panel/colleges.js') }}"></script>
    <script>
        var colleges_count = {{ count($colleges) }};
    </script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src=" https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
@endsection
