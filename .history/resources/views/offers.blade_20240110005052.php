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
                                    <h2 class="text-black" style="font-size: 28px;">  <i class="fa-solid fa-envelopes-bulk" style="font-size: 28px"></i> <u> Offers </u> </h2>
                                    <hr>
                                    <div id="body" class="text-center ml-5">

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
<script src=" {{ asset('js/offers.js') }} "></script>
@endsection