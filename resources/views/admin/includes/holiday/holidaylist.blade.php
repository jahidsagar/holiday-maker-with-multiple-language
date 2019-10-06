@extends('admin.admin')

@section('title','holiday list title')

@section('html_header')
{{-- all style and css goes here --}}
	<style>
		.right{
			float: right;
			padding: 3px;
		}
	</style>
@endsection

@section('content')

	 <div class="container-fluid">
	    <br>
	    <div class="right">
	    	<a href="{{ url('/createholiday').'/'.$month->id }}" class="btn btn-success">Add New Holiday</a>
	    </div>
	    <div class="clearfix"></div>
	    <section id="all-apps" class="text-center">
	        <h2>All Holidays</h2>
	        <h4 id="alert" class="text-center text-danger alert alert-danger" style="margin-left: 5%;"></h4>
	        <table class="table table-hover">
	            <thead>
	                <tr class="success">
	                    <th style="width: 10%">Holiday Language</th>
	                    <th style="width: 10%">Holiday Title</th>
	                    <th style="width: 40%">Holiday Description</th>
	                    <th style="width: 10%">Holiday Range</th>
	                    <th style="width: 10%">Holiday Month</th>
	                    <th style="width: 10%">Holiday Year</th>
	                    <th style="width: 10%">Edit</th>
	                </tr>
	            </thead>
	            <tbody>
	            	@foreach($holidays as $holiday)
	                <tr>
	                    <td>{{ $holiday->languageName }}</td>
	                    <td>{{ $holiday->title }}</td>
	                    <td>{{ $holiday->description }}</td>
	                    <td>{{ $holiday->startDate }}@if($holiday->hasRange == 1)-{{ $holiday->endDate }}@endif
	                    </td>
	                    <td>{{ $holiday->monthName }}</td>
	                    <td>{{ isset($holiday->specificYear)?$holiday->specificYear:"No" }}</td>
	                    <td><a href="{{ url('/holidays/edit/').'/'.$holiday->HolidaysId }}"><i class="fa fa-edit"></i></a></td>
	                </tr>
					@endforeach
	        </table>
	    </section>
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