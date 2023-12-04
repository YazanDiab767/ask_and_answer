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
        <form class="mt-5" style="border: 1px solid black; padding: 10px;">
            <h1>Form Text</h1>
            <hr>
            <input type="text" placeholder="Enter a text" class="form-control" /><br/>
            <button class="btn btn-success">Send Text</button>
        </form>
    </div>
</div>
@endsection

@section('script')
@parent
@endsection