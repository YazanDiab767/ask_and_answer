@extends('layouts.header')

@section('title','CampusLink - Courses / ' . $college->name )

@section('style')
@parent
    <link rel="stylesheet" href="{{ asset('css/colleges.css') }}">
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
                                    <div class="text-left"> <a href="#" onclick="history.back()" class="btn btn-success"> <i class="fa-solid fa-circle-left"></i> Back </a> </div>
                                    <h2 class="text-black" style="font-size: 28px;">  <u> {{ $college->name }} </u> </h2>
                                    {{-- <img src="/storage/{{ $college->image }}" class="title_image" /> --}}
                                    <div class="text-left">
                                        <label class="text-info mt-3">-Number of courses : <b> {{ count( $college->courses ) }} </b></label>
                                    </div>
                                    <div class="input-group mb-3 mt-4">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text bg-white"><i class="fas fa-search text-primary"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="searchInput" placeholder="Please enter course name" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                    <hr>
                                    <div id="body" class="text-center ">
                                        @php
                                            $count_rows = 0; // each 4 in row
                                        @endphp
                                            @if ( count( $college->courses ) == 0 )
                                                <div class="alert alert-danger">
                                                    <i class="fa-regular fa-folder-open"></i> There is no any course here !
                                                </div>
                                            @endif
                                        @foreach ($college->courses as $course)
                                            @php
                                                if ( $count_rows == 0 )
                                                    echo '<div class="row justify-content-center">';
                                            @endphp
                                            <div class="card border-primary mb-5 mr-5 w-25" style="max-width: 25rem;">
                                                <div class="card-header p-3">
                                                    <h4> <i class="fa-solid fa-book"></i> {{ $course->name }} </h4>
                                                </div>
                                                <div class="card-body text-primary">
                                                    <p class="card-text">
                                                        <b>-</b> Count of questions : <b> {{ count( $course->questions ) }} </b> 
                                                        <br/>
                                                        <b>-</b> Date created : <b> {{ date('d-m-Y', strtotime($course->created_at)) }}  </b> 
                                                    </p>
                                                    <hr>
                                                    <a href="{{ route('courses.course' , $course->id) }}" class="btn btn-primary w-100 text-white"> <i class="fa-solid fa-braille"></i> Visit </a>
                                                </div>
                                              </div>
                                            @php
                                               
                                                $count_rows++;
                                                if ( $count_rows >= 4 )
                                                {
                                                    $count_rows = 0;
                                                    echo '</div>';
                                                }
                                            @endphp
                                        @endforeach
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

@section('script')
@parent
    <script src=" {{ asset('js/colleges.js') }} "></script>
@endsection