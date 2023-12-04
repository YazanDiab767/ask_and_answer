@extends('layouts.header')

@section('title','C')

@section('style')
	@parent
	<style>
		.select2-search__field, .select2-container{
			width: 100% !important;
		}
	</style>
@endsection

@section('body')

<div class="theme-layout">
    <form>
        <input type="text" placeholder="Enter a text" class="form-control" />
    </form>
</div>
@endsection

@section('script')
@parent
@endsection