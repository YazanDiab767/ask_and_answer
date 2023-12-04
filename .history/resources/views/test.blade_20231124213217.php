@extends('layouts.header')

@section('title','C')

@section('style')
	@parent
	<style>
		.topbar,.stick
        {
			display: none !important;
		}
	</style>
@endsection

@section('body')

<div class="theme-layout">
    <div class="w-50">
        <form class="mt-5">
            <input type="text" placeholder="Enter a text" class="form-control" /><br/>
            <button class="btn btn-success">Send Text</button>
        </form>
    </div>
</div>
@endsection

@section('script')
@parent
@endsection