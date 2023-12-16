@extends('layouts.header')

@section('title','Control Panel - Universities')

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
                                    <h2 class="f-title" style="font-size: 25px"><i class="fa-solid fa-building-columns text-black" style="font-size: 25px"></i> Universities ( <span id="universitiesCount"></span> ) </h2>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-4 text-left">
                                                <button class="btn btn-primary" id="btnAddNewUniversity" data-toggle="modal" data-target=".newUniversity"> <i class="fa-solid fa-plus"></i> Add new university </button>
                                            </div>
                                        </div>

                                        <div class="text-left mt-5">
                                            <div class="row">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text bg-white"><i class="fas fa-search text-primary"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="searchInput" placeholder="Please enter university name" aria-label="Username" aria-describedby="basic-addon1">
                                            </div>
                                            
                                        </div>
                                  
                                        <div class="table-responsive mt-5">
                                            <table class="table table-striped text-center" id="cs">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th> <b> Created at </b> </th>
                                                        <th> <b> Name </b>  </th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="universities">
                                                    @php
                                                        $c = 1;
                                                    @endphp
                                                    @foreach ($universities as $university)
                                                        <tr class="university bg-warning">
                                                            <td class="align-middle"> {{ $c }} </td>
                                                            <td class="align-middle"> {{ $university->created_at }} </td>
                                                            <td class="align-middle"> {{ $university->name }} </td>
                                                            <td class="align-middle text-right" style="width: 15%;">
                                                                <a href="{{$university->id}}/{{$university->name}}/{{ $c++ }}" class="btn btn-success btnEditUniversity w-50" data-toggle="modal" data-target=".editUniversity" > <i class="fas fa-edit"></i> Edit  </a>
                                                            <td class="align-middle text-left" style="width: 15%;">
                                                                <form action="{{ route('universities.destroy',$university->id) }}" class="formDeleteUniversity" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="btn btn-danger text-white delete_university w-50"> <i class="fas fa-trash"></i> Delete  </button>
                                                                </form>
                                                            </td>
                                                            @if ( $university->add_by == "student" )
                                                            <td  class="align-middle text-left" style="width: 20%;">
                                                                <form action="{{ route('universities.approve',$university->id) }}" class="formApproveUniversity" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="btn btn-warning text-white approve_university w-50"> <i class="fa-solid fa-check-double"></i> Approve  </button>
                                                                </form>
                                                            </td>
                                                            @endif
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
{{-- Form Add New University --}}
<div class="modal newUniversity" id="newUniversity" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> <i class="fa-solid fa-plus"></i> Add new university </h5>
                <div class="float-left">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <form action="{{ route('universities.store') }}" id="formAddUniversity" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label> University name : </label>
                        <input type="text" class="form-control name" name="name" placeholder="university name"/>
                    </div>
                </form>
            </div>
            <br/>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-primary" id="addUniversity"> <i class="fas fa-save"></i>  Add  </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fa-solid fa-xmark"></i>  Close </button>
            </div>
        </div>
    </div>
</div>

{{-- Form Edit University --}}
<div class="modal fade editUniversity" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" >
                <h5 class="modal-title"> <i class="fa-solid fa-pen-to-square"></i> University Edit </h5>
                <div class="float-left">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <form action="" id="formUpdateUniversity" method="POST" class="text-right" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="text-left">
                        <label> University name : </label>
                        <input type="text" class="form-control u_name" id="universityName" name="name" placeholder="University name"/>
                    </div>
                </form>
            </div>
            <br/>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fa-solid fa-circle-xmark"></i> Close</button>
                <button type="button" class="btn btn-success" id="updateUniversity">  <i class="fas fa-save"></i> Save  </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@parent
	<script src="{{ asset('js/control_panel/all.js') }}"></script>
    <script src="{{ asset('js/control_panel/universities.js') }}"></script>
    <script>
        var universities_count = {{ count($universities) }};
    </script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src=" https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
@endsection
