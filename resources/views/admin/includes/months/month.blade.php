@extends('admin.admin')

@section('title','all months')

@section('html_header')
{{-- all style and css goes here --}}
@endsection

@section('content')
	<div class="row">
		@if($edit == false)
	    <section class="cal-comb text-center">
	        <h3>Add Months</h3><br>
	        <h4 id="alert" class="text-center text-danger alert alert-danger" style="margin-left: 5%;"></h4>
	        <div class="col-md-offset-2 col-md-8 well text-center">
	            <div class="col-md-12">
	                <h4>Months-list</h4>
					@if ($errors->has('months_name'))
					    <p><span class="text-danger">
					        <strong>{{ $errors->first('months_name') }}</strong>
					    </span></p>
					@endif
					@if(isset($months))

	                <ol class="list-group">

	                	@foreach($months as $month)
	                    <li class="list-group-item">
	                    	<span>{{ $month->weight}}. </span>
	                    	<a href="{{ url('/holidays/').'/'.$month->id }}">{{ $month->monthName }} </a>
	                    	<a href="{{ url('/months/edit/').'/'.$package->id.'/'.$month->id }}" class="btn btn-info">Edit</a>
	                    </li>
	                    @endforeach

	                </ol>

	                @endif
	                <button type="button" class="btn btn-success add-months">Add Months</button>
	            </div>
	        </div>
	    </section>
	    <div class="clearfix"></div>
	    <section class="col-md-offset-2 col-md-8 well" id="add-months">
	        <div class="panel panel-success">
	            <div class="panel-heading text-center">Add Months</div>
	            <div class="panel-body">
	                <form class="form-horizontal" action="{{ url('/months') }}" method="post">
	                	@csrf
	                    <div class="form-group">
	                        <label class="control-label col-sm-2" for="months_name">Months:</label>
	                        <input type="hidden" name="package_id" value="{{ $package->id }}">
	                        <div class="col-sm-10">
	                            <input type="text" class="form-control" id="months_name" placeholder="Enter Months Name" name="months_name" required="">
	                            
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label class="control-label col-sm-2" for="months_name">Serial:</label>
	                        <div class="col-sm-10">
	                            <input type="text" class="form-control" id="months_name" placeholder="Enter Weight" name="weight" required="" value="0">
	                            
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <div class="col-sm-offset-2 col-sm-10">
	                            <button type="submit" class="btn btn-success">Submit</button>
	                        </div>
	                    </div>
	                </form>
	            </div>
	        </div>
	    </section>

	    @else

	    <div class="clearfix"></div>

		<section class="col-md-offset-2 col-md-8 well">
	        <div class="panel panel-success">
	            <div class="panel-heading text-center">Add Months</div>
	            <div class="panel-body">
	                <form class="form-horizontal" action="{{ url('/months/edit/').'/'.$month->id }}" method="post">
	                	@csrf
	                    <div class="form-group">
	                        <label class="control-label col-sm-2" for="months_name">Months:</label>
	                        <input type="hidden" name="package_id" value="{{ $package->id }}">
	                        <div class="col-sm-10">
	                            <input type="text" class="form-control" id="months_name" placeholder="Enter Months Name" name="months_name" value="{{ $month->monthName }}">
	                        </div>
	                    </div>
	                     <div class="form-group">
	                        <label class="control-label col-sm-2" for="months_name">Serial:</label>
	                        <div class="col-sm-10">
	                            <input type="text" class="form-control" id="months_name" placeholder="Enter Weight" name="weight" required="" value="{{ $month->weight }}">
	                            
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <div class="col-sm-offset-2 col-sm-10">
	                            <button type="submit" class="btn btn-success">Update</button>
	                        </div>
	                    </div>
	                </form>
	            </div>
	        </div>
	    </section>
	    @endif
	</div>
@endsection

@section('footer_script')
{{-- all footer script goes here --}}
<script>
	//button click form show
    $(document).ready(function() {
        $("#add-months").hide();
        $(".add-months").click(function() {
            $("#add-months").fadeIn();

        });
    });

    //for alert message
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
</script>

@endsection