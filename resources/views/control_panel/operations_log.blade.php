@extends('layouts.header')

@section('title','Control Panel - Operations Log')

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
                                    <h2 class="f-title" style="font-size: 25px"><i class="fa-solid fa-clock-rotate-left" style="font-size: 25px"></i> Operations Log ( {{ \App\Models\Operation::count() }} ) </h2>

                                    <div class="card-body">
                                        <form action="{{ route('dashboard.filterOperations') }}" method="GET" id="formFilter">
                                            <div class="text-left mt-5">
                                                <div class="row">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text bg-white"><i class="fas fa-search text-primary"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="inputSearch" placeholder="Please enter superviosr name or university id or operation type ..." aria-label="Username" aria-describedby="basic-addon1">
                                                </div>
                                            </div>
                                        </form>
                                  
                                        <div class="table-responsive mt-5">
                                            <table class="table table-striped text-center" id="cs">
                                                <thead>
                                                    <tr>
                                                        <th>  </th>
                                                        <th> <b> Date And Time </b> </th>
                                                        <th> <b> Supervisor name </b>  </th>
                                                        <th> <b> Operation Type </b>  </th>
                                                        <th class="w-25"> <b> Details </b>  </th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="operations_body">
                                                    @if (count($operations) > 0)                   
                                                        @include('control_panel.layouts.operation')
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>

                                        @if( \App\Models\Operation::all()->count() > \App\Models\Operation::$paginate )
                                            <div>
                                                <button id="showMore" class="btn btn-info text-white"><i class="fa-solid fa-caret-down"></i> Show more </button>
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
    <script src="{{ asset('js/control_panel/operations.js') }}"></script>
    <script>
    </script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src=" https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
@endsection
