@extends('admin.admin')

@section('title','all languge')

@section('html_header')
{{-- all style and css goes here --}}
@endsection

@section('content')
	 <div class="row">
	 	@if($edit == false)
	    <section id="all-apps" class="text-center">
		    <h2>All Languages</h2>
		    <h4 id="alert" class="text-center text-danger alert alert-danger" style="margin-left: 5%;"></h4>
		    <table class="table">
		        <thead>
		            <tr class="success">
		                <th>App Name</th>
		                <th>Edit</th>
		            </tr>
		        </thead>
		        <tbody>
		        	@foreach($languages as $language)
		        	<tr>
		                <td><a href="language-list.html">{{ $language->languageName}}</a></td>
		                <td><a href="{{ url('/languages/edit/').'/'.$language->id }}"><i class="fa fa-edit"></i></a></td>
		            </tr>
		        	@endforeach
		            
		    </table>
		    <button type="button" class="btn btn-primary add-language">Add Language</button>
		</section>
	    <div class="clearfix"></div>
	    <section class="col-md-offset-2 col-md-8 well" id="add-language">
	        <div class="panel panel-primary">
	            <div class="panel-heading text-center">Add Language</div>
	            <div class="panel-body">
	                <form class="form-horizontal" action="{{ url('/languages') }}" method="post">
	                	@csrf
	                    <div class="form-group">
	                        <label class="control-label col-sm-2" for="months_name">Language:</label>
	                        <div class="col-sm-10">
	                            <input type="text" class="form-control" id="months_name" placeholder="Enter Language" name="languageName">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <div class="col-sm-offset-2 col-sm-10">
	                            <button type="submit" class="btn btn-primary">Submit</button>
	                        </div>
	                    </div>
	                </form>
	            </div>
	        </div>
	    </section>
	    <div class="clearfix"></div>

	    {{-- =================================== edit form ================ --}}
	    @else
	    <section class="col-md-offset-2 col-md-8 well" id="">
	        <div class="panel panel-primary">
	            <div class="panel-heading text-center">Add Language</div>
	            <div class="panel-body">
	                <form class="form-horizontal" action="{{ url('/languages/edit/').'/'.$language->id }}" method="post">
	                	@csrf
	                    <div class="form-group">
	                        <label class="control-label col-sm-2" for="months_name">Language:</label>
	                        <div class="col-sm-10">
	                            <input type="text" class="form-control" id="months_name" placeholder="Enter Language" name="languageName" value="{{ $language->languageName }}">
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <div class="col-sm-offset-2 col-sm-10">
	                            <button type="submit" class="btn btn-primary">Submit</button>
	                        </div>
	                    </div>
	                </form>
	            </div>
	        </div>
	    </section>
	    <div class="clearfix"></div>
	    {{-- ======================================= end ==================== --}}
	    @endif
	</div>
@endsection

@section('footer_script')
{{-- all footer script goes here --}}
	<script>
		$(document).ready(function() {
		    $("#add-language").hide();
		    $(".add-language").click(function() {
		        $("#add-language").fadeIn();

		    });
		});

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