@extends('layouts.header')

@section('title','Control Panel - Questions')

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
                                    <h2 class="f-title" style="font-size: 25px"><i class="fa-solid fa-circle-question text-black" style="font-size: 25px"></i> Questions </h2>

                                    <div class="card-body">
                                        
                                        <div class="input-group mb-3 mt-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white"><i class="fas fa-search text-primary"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="question_id" placeholder="Please enter number of question">
                                        </div>

                                        <div class="table-responsive mt-5">
                                            <table class="table table-bordered text-center " id="cs">
                                                    <tr>
                                                        <td class="font-weight-bold w-25"> Question number </td>
                                                        <td id="question_number">  </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="font-weight-bold"> Student name </td>
                                                        <td id="student_name">  </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="font-weight-bold">  Count of comments </td>
                                                        <td> 5 </td>
                                                    </tr>

                                                    
                                                    <tr>
                                                        <td class="font-weight-bold">  College - Course </td>
                                                        <td id="college_course">  </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="font-weight-bold">  Date and time of publication </td>
                                                        <td id="date_time">  </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="font-weight-bold">  Visit Question </td>
                                                        <td id="visit_question">  </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="font-weight-bold"> Status </td>
                                                        <td id="status_question">
          
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="font-weight-bold">  Comment from supervisor </td>
                                                        <td id="comments">  </td>
                                                    </tr>


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
<div class="modal fade newCourse" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="false">
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
                <form action="" id="formAddCollege" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label> Course name : </label>
                        <input type="text" class="form-control name" name="name" placeholder="course name"/>
                    </div>
                    <div class="mt-4">
                        <label> College  : </label>
                        <select class="form-control" id="college_id" name="college_id">
                            <option value = ""> College 1 </option>
                            <option value = ""> College 2 </option>
                        </select> 
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

@endsection

@section('script')
@parent
	<script src="{{ asset('js/control_panel/all.js') }}"></script>
    <script src="{{ asset('js/control_panel/questions.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src=" https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
@endsection
