@extends('layouts.header')

@section('title','Control Panel - Complaints')

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
                                    <h2 class="f-title" style="font-size: 25px"><i class="fa-solid fa-triangle-exclamation text-black" style="font-size: 25px"></i> Complaints ( {{ \App\Models\Complaint::where('handledBy','')->count() }} ) </h2>

                                    <div class="card-body">

                                  
                                        <div class="table-responsive mt-5">
                                            <table class="table table-striped text-center" id="cs">
                                                <thead>
                                                    <tr>
                                                        <th>  </th>
                                                        <th> <b> Date and time </b> </th>
                                                        <th> <b> Username </b> </th>
                                                        <th> <b> Question number </b> </th>
                                                        <th> <b> Complaint type </b> </th>
                                                        <th> </th>
                                                        <th>  </th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="complaints">
                                                    @php $c = 1; @endphp
                                                    @foreach ($complaints as $complaint)
                                                        <tr>
                                                            <td class="align-middle"> {{ $c++ }} </td>
                                                            <td class="align-middle"> {{ $complaint->created_at }} </td>
                                                            <td class="align-middle"> {{ $complaint->user->name }} </td>
                                                            <td class="align-middle"> {{ $complaint->question_id }} </td>
                                                            <td class="align-middle"> {{ $complaint->type }} </td>
                                                            <td class="align-middle "> <a href="{{ $complaint->text }}" class="btn btn-success showText" data-toggle="modal" data-target=".complaintText" > <i class="fa-solid fa-eye"></i> Show text  </a> </td>
                                                            <td class="align-middle ">
                                                                <td>
                                                                    @if ($complaint->handledBy)
                                                                       <label class="text-success">
                                                                           <i class="far fa-check-circle"></i> 
                                                                           Done by: {{ $complaint->handledBy }}
                                                                        </label> 
                                                                    @else
                                                                        <a href="{{ $complaint->id }}" class="btn btn-success btnDone"><i class="far fa-check-circle"></i>  Done  </a>
                                                                    @endif
                                                                </td>
                                                            </td>
                                                        </tr>  
                                                    @endforeach
                                                </tbody>
                                            </table>

                                           
                                     

                                        </div>

                                         @if (count( $complaints ) >= \App\Models\Complaint::$paginate)
                                            <div class="row justify-content-center mt-3">
                                                <button class="btn btn-primary w-25" id="showMore"> <i class="fa-solid fa-caret-down"></i> Show More </button>
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

{{-- text --}}
<div class="modal fade complaintText" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titleDiv"> Text of complaints </h5>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center mt-3">
                    <p class="font-weight-bold text-black text_complaint">
                        This is a text for complaint
                    </p>
                </div>
            </div>
            <div class="modal-footer text-center" >
                <div class="row w-100 justify-content-center">
                    <div class="col-sm-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> X Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
@parent
	<script src="{{ asset('js/control_panel/all.js') }}"></script>
	<script src="{{ asset('js/control_panel/complaints.js') }}"></script>
    <script>
        var name = "{{ auth()->user()->name }}";
        var count = {{ $c }};
    </script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src=" https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
@endsection
