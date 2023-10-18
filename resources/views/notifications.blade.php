@extends('layouts.header')

@section('title','CampusLink - Notifications')

@section('style')
@parent
<style>
    ul li{
        display: block;
        cursor: pointer;
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
                                    <h2 class="text-black" style="font-size: 28px;"> <i class="fa-solid fa-bell"></i> Notifications </h2>
                                    <hr>
                                    <div class="row jutstifiy-content-center">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-8">
                                            <ul class="notifications">
                                                
                                                {{-- <li>
                                                    <div class="text-left notification">
                                                        <div class="coment-head">
                                                            <img src="/storage/{{ auth()->user()->image }}" style="min-width: 50px; min-height: 50px; max-width: 50px; max-height: 50px;">

                                                            <h5 class="text-black"><a> <b> Yazan </b> <label>reply to your question in c++ programming course </label> </a></h5>
                                                            <p class="">
                                                                how are you ...
                                                            </p>
                                                        </div>
                                                        
                                                        <small class="text-black"><i class="fa-solid fa-clock"></i> 17/10/2023 3:46</small>
                                                    </div>
                                                </li> --}}
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center pb-3">
                                        <a class="btn btn-primary btnGetMoreNotifications text-white"> <i class="fa-brands fa-get-pocket"></i> Show More </a>
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
    <script>
        var savedQuestions = '{{ auth()->user()->savedQuestions }}';
        var user_id = {{ auth()->user()->id  }};
    </script>
    <script src=" {{ asset('js/select2.min.js') }} "></script>
    {{-- <script src=" {{ asset('js/notifications.js') }} "></script> --}}
@endsection