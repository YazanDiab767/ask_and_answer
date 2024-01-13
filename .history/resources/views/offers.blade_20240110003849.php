@extends('layouts.header')

@section('title','CampusLink - Colleges')

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
                                    <h2 class="text-black" style="font-size: 28px;">  <i class="fa-solid fa-building-columns" style="font-size: 28px"></i> <u> Colleges </u> </h2>

                                    <div class="input-group mb-3 mt-4">
                                        <div class="input-group-prepend">
                                          <span class="input-group-text bg-white"><i class="fas fa-search text-primary"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="searchInput" placeholder="Please enter collge name" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                    <hr>
                                    <div id="body" class="text-center ml-5">
                                        @php
                                            $count_rows = 0; // each 4 in row
                                        @endphp
                                        @foreach ($colleges as $college)
                                            @php
                                                if ( $count_rows == 0 )
                                                    echo '<div class="row justify-content-left ml-4">';
                                            @endphp
                                            <div class="card h-100 mr-5 mt-2">
                                                <img src="/storage/{{ $college->image }}" class="card-img-top" >
                                                <div class="card-body">
                                                    <h5 class="card-title text-black"> {{ $college->name }} </h5>
                                                    <p class="card-text">
                                                        <label class="text-info">
                                                            - Date created : <b> {{ date('d-m-Y', strtotime($college->created_at)) }} </b> <br>
                                                            - Number of courses : <b> {{ count( $college->courses ) }} </b>
                                                        </label>
                                                        <hr>
                                                        <a href="{{ route('colleges.college' , $college->id) }}" class="btn btn-sm btn-primary text-white w-100"> <i class="fa-solid fa-arrow-up-right-from-square"></i> Enter </a>
                                                    </p>
                                                </div>
                                            </div>
                                            @php
                                                if ( $count_rows >= 4 )
                                                {
                                                    $count_rows = 0;
                                                    echo '</div>';
                                                }
                                                $count_rows++;
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