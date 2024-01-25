@extends('layouts.header')

@section('title','CampusLink - Colleges')

@section('style')
@parent
    <link rel="stylesheet" href="{{ asset('css/colleges.css') }}">
	<style>
        .details {
            display: none;
        }
    </style>
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
                                    <br/>
									<a class="btn btn-info text-white"> <i class="fa-solid fa-arrow-up-wide-short"></i> Show offers only in my country </a>
									<hr>
                                    <div id="body" class="container text-center ml-5">

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
<script>
	document.addEventListener('DOMContentLoaded', function () {
		// Get references to all clickable elements
		var clickableElements = document.querySelectorAll('.clickable');

		clickableElements.forEach(function (element) {
			// Add a click event listener to each clickable element
			element.addEventListener('click', function () {
				// Get the target details element using the data-target attribute
				var targetId = element.getAttribute('data-target');
				var details = document.getElementById(targetId);

				// Toggle the visibility of the details div
				if (details.style.display === 'none') {
					details.style.display = 'block';
				} else {
					details.style.display = 'none';
				}
			});
		});
	});
</script>
@endsection