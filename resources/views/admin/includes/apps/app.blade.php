@extends('admin.admin')

@section('title','all app')

@section('html_header')
{{-- all style and css goes here --}}
<style>
	.error{
		color: red;
	}
</style>
@endsection

@section('content')
	<section id="app-form">
	    <h2 class="text-center">Add New App</h2>


	    <h4 id="alert" class="text-center text-danger alert alert-danger" style="margin-left: 5%;"></h4>

		@if($edit == false)
	    <form class="form-horizontal" action="{{ url('/apps') }}" method="post" id="packageForm">
	    	@csrf
	        <div class="form-group">
	            <label class="control-label col-sm-2" for="package_name">App Name:</label>
	            <div class="col-sm-10">
	                <input type="text" class="form-control" id="package_name" placeholder="Enter App Name" name="package_name" required="">
	                @if ($errors->has('package_name'))
                        <p><span class="text-danger">
                            <strong>{{ $errors->first('package_name') }}</strong>
                        </span></p>
                    @endif
	            </div>
	        </div>
	        <div class="form-group">
	            <label class="control-label col-sm-2" for="app_title">Package Name:</label>
	            <div class="col-sm-10">
	                <input type="text" class="form-control" id="app_title" placeholder="Enter Package Name" name="app" required="">
	                @if ($errors->has('app'))
                        <p><span class="text-danger">
                            <strong>{{ $errors->first('app') }}</strong>
                        </span></p>
                    @endif
	            </div>
	        </div>
	        <div class="form-group">
	            <div class="col-sm-offset-2 col-sm-10">
	                <button type="submit" class="btn btn-success">Submit</button>
	            </div>
	        </div>
	    </form>

		{{--======================================== for edit purpose ===========--}}
		@else
		<form class="form-horizontal" action="{{ url('/apps/edit/').'/'.$app->id }}" method="post" id="packageForm"> 
	    	@csrf
	        <div class="form-group">
	            <label class="control-label col-sm-2" for="package_name">App Name:</label>
	            <div class="col-sm-10">
	                <input type="text" class="form-control" id="package_name" placeholder="Enter App Name" name="package_name" value="{{$app->name}}">
	                @if ($errors->has('package_name'))
                        <p><span class="text-danger">
                            <strong>{{ $errors->first('package_name') }}</strong>
                        </span></p>
                    @endif
	            </div>
	        </div>
	        <div class="form-group">
	            <label class="control-label col-sm-2" for="app_title">Package Name:</label>
	            <div class="col-sm-10">
	                <input type="text" class="form-control" id="app_title" placeholder="Enter Package Name" name="app" value="{{$app->app}}">
	                @if ($errors->has('app'))
                        <p><span class="text-danger">
                            <strong>{{ $errors->first('app') }}</strong>
                        </span></p>
                    @endif
	            </div>
	        </div>
	        <div class="form-group">
	            <div class="col-sm-offset-2 col-sm-10">
	                <button type="submit" class="btn btn-success">Update</button>
	            </div>
	        </div>
	    </form>
	    @endif
		{{-- ======================================= end ========================--}}

	</section>
	<br>
	@if(isset($apps))
	<section id="all-apps" class="text-center">
	    <h2>All Apps</h2>
	    <table class="table">
	        <thead>
	            <tr class="success">
	                <th>App Name</th>
	                <th>Package name</th>
	                <th>Edit</th>
	            </tr>
	        </thead>
	        <tbody>
	        	@foreach($apps as $app)
	        	<tr>
	                <td><a href="{{ url('months/').'/'.$app->id }}">{{ $app->name}}</a></td>
	                <td><a href="{{ url('months/').'/'.$app->id }}">{{ $app->app }}</a></td>
	                <td><a href="{{ url('/apps/edit/').'/'.$app->id }}"><i class="fa fa-edit"></i></a></td>
	            </tr>
	        	@endforeach
	            
	    </table>
	</section>
	@endif
@endsection

@section('footer_script')
{{-- all footer script goes here --}}
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.js"></script>
	<script>
		$sessionMessage = '{{ Session::get('msg') }}' ;
		if($sessionMessage.length > 0 ){
			$('#alert').show();
			$('#alert').html($sessionMessage);
			setTimeout(function(){ 
	            $('#alert').removeClass('alert alert-danger');
	            $('#alert').hide();
	            SessionMessage = '{{ Session::forget('msg')}}';
	            $('#alert').html('');
	        }, 3000);
		}else{
			$('#alert').hide();
		}
		
		$( document ).ready(function() {
			$("#packageForm").validate();
		});
	</script>
@endsection