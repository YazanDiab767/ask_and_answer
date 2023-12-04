
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
    <div class="w-50">
        <form>
            <input type="text" placeholder="Enter a text" class="form-control" />
        </form>
    </div>
</div>
@endsection

@section('script')
@parent
@endsection