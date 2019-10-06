@extends('admin.admin')

@section('title','all users')

@section('html_header')
{{-- all style and css goes here --}}
	<style>
		table{

		}

	</style>
@endsection

@section('content')

	 <div class="container-fluid">
	        <h2 class="text-center">All Users</h2>
	        <h4 id="alert" class="text-center text-danger alert alert-danger" style="margin-left: 5%;"></h4>
			<div id="row">
				<table class="table">
				<thead>
					<tr>
					<th scope="col">Name</th>
					<th scope="col">Email</th>
					<th scope="col">Role</th>
					</tr>
				</thead>
				<tbody>
				@foreach($users as $user)
				<tr>
					<td>{{ $user->name }}</td>
					<td>{{ $user->email }}</td>
					<td>
						<form action="{{ url('/role/')}}" method="post" class="form-horizontal">
                    		@csrf
                    		<input type="hidden" name="userId" value="{{ $user->id }}">
                    		<div class="form-group">
		                        <div class="col-sm-10">
		                            <select name="role" class="">
		                    			<option value="1" @if($user->roles_id == 1) selected="" @endif>Admin</option>
		                    			<option value="2" @if($user->roles_id == 2) selected="" @endif>User</option>
		                    			<option value="3" @if($user->roles_id == 3) selected="" @endif>Block</option>
		                    		</select>
									<button type="submit" class="btn btn-primary">Submit</button>
		                        </div>
		                    </div>
                    		
                    	</form>
					</td>
				</tr>
				@endforeach
				</tbody>
			</div>
	</div>

@endsection

@section('footer_script')
{{-- all footer script goes here --}}
	<script>
		$sessionMessage = '{{ Session::get('msg') }}' ;
		{{ Session::forget('msg')}}
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
	</script>
@endsection