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
                                                        <th> <b> University ID </b>  </th>
                                                        <th> <b> Class Number </b>  </th>
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
