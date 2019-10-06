@extends('admin.admin')

@section('title','holiday edit')

@section('html_header')
{{-- all style and css goes here --}}
<link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap-select.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/prism.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/chosen.css') }}">
<style>
	.error{
		color: red;
	}
</style>
@endsection

@section('content')

	<div class="row">
	    <section class="col-md-9 well" id="add-holiday">
	        <h2 class="text-center">Edit Holiday</h2>
	        <form class="form-horizontal" action="{{ url('/holidays/edit/').'/'.$holiday->id }}" method="post" id="holidayform">
	        	@csrf
	        	<input type="hidden" name="month_id" value="{{ $holiday->month_id }}">
	            <div class="panel panel-primary">
	                <div class="panel-body">
	                    <div class="form-group">
	                        <label class="control-label col-sm-2" for="date">Holiday Date</label>
	                        <div class="col-sm-10">
	                            <span>Has range?</span>
	                            <select title="Pick a Calendar Type" class="selectpicker" id="range" required="" name="hasRange">
	                                <option value="no" >No</option>
	                                <option value="yes" @if($holiday->hasRange == 1) selected=""  @endif>Yes</option>
	                            </select>
	                            @if ($errors->has('hasRange'))
                                    <p><span class="text-danger">
                                        <strong>{{ $errors->first('hasRange') }}</strong>
                                    </span></p>
                                @endif
	                        </div>
	                    </div>
	                    <div id="" style="">
	                        <div class="form-group">
	                            <label class="control-label col-sm-2" for="start_date">Enter Start Date:</label>
	                            <div class="col-sm-10">
	                                <input type="number" class="form-control" id="start_date" placeholder="Enter Start Date" name="start_date" required="" value="{{ $holiday->startDate }}">
	                                @if ($errors->has('start_date'))
	                                    <p><span class="text-danger">
	                                        <strong>{{ $errors->first('start_date') }}</strong>
	                                    </span></p>
	                                @endif
	                            </div>
	                        </div>
	                    </div>
	                    <div id="ifHasRange" @if($holiday->hasRange == 0) style="display: none;" @endif>
	                        <div class="form-group">
	                            <label class="control-label col-sm-2" for="start_date">Enter End Date:</label>
	                            <div class="col-sm-10">
	                                <input type="number" class="form-control" id="start_date" placeholder="Enter End Date" name="end_date" value="{{ $holiday->endDate }}">
	                                @if ($errors->has('end_date'))
	                                    <p><span class="text-danger">
	                                        <strong>{{ $errors->first('end_date') }}</strong>
	                                    </span></p>
	                                @endif
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="panel panel-primary">
	                <div class="panel-body">
	                    <div class="form-group">
	                        <label class="control-label col-sm-2" for="year">Holiday year</label>
	                        <div class="col-sm-10">
	                            <span>Year Specific?</span>
	                            <select title="Pick a Calendar Type" class="selectpicker" id="specYear" required="" name="year_specific">
	                                <option value="no">No</option>
	                                <option value="yes" @if($holiday->yearSpecific == 1) selected=""  @endif>Yes</option>
	                            </select>
	                            @if ($errors->has('year_specific'))
                                    <p><span class="text-danger">
                                        <strong>{{ $errors->first('year_specific') }}</strong>
                                    </span></p>
                                @endif
	                        </div>
	                    </div>
	                    <div id="ifYes" @if($holiday->yearSpecific == 0) style="display: none;"  @endif>
	                        <div class="form-group">
	                            <label class="control-label col-sm-2" for="year">Enter Specific Year:</label>
	                            <div class="col-sm-10">
	                                <input type="number" class="form-control" id="year" placeholder="Enter Specific Year" name="year" value="{{ $holiday->specificYear }}">
	                                @if ($errors->has('year'))
	                                    <p><span class="text-danger">
	                                        <strong>{{ $errors->first('year') }}</strong>
	                                    </span></p>
	                                @endif
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <section class="panel panel-primary text-center cal-lang">
	                <div class="panel-body">
	                    <div class="col-md-offset-1 col-md-10 well text-center">
	                        <div class="col-md-12">
	                            <h4>Calendar Language</h4>
	                            <div>
	                                <select data-placeholder="Choose Languages..." class="chosen-select" id="chosen" multiple tabindex="4" style="width: 90%" required="" name="languages[]">
	                                    @foreach($languages as $language)
	                                    <option value="{{ $language->languageName }}">{{ $language->languageName }}</option>
	                                    @endforeach
	                                </select>
	                                 @if ($errors->has('languages'))
	                                    <p><span class="text-danger">
	                                        <strong>{{ $errors->first('languages') }}</strong>
	                                    </span></p>
	                                @endif
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </section>
	            <div class="clearfix"></div>
	            <section id="holiday-var">
	                <div id="dynamic"></div>
	            </section>
	            <div class="form-group text-center">
	                <div class="">
	                    <button type="submit" class="btn btn-primary">Submit</button>
	                </div>
	            </div>
	        </form>
	    </section>
	    <section class="col-md-3 well" id="add-languages">
	        <div class="form-group">
	            <label class="control-label col-sm-12" for="add-langauge">Add New Language</label>
	            <div class="col-sm-12">
	            	<form method="post" action="{{ url('/languages/ajax') }}" id="language_ajax">
	            		<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	                	<input type="text" class="form-control" id="add-langauge" placeholder="Enter New Language" name="languageName" required="">
	                	<input type="submit" class="btn btn-primary" value="Add Language" style="margin-left: 24%;margin-top: 5%;">
	                </form>
	                <h4 id="alert" class="text-center text-danger alert alert-danger" style="margin-left: 5%;"></h4>
	            </div>
	        </div>
	        <div class="clearfix"></div>
				<div class="lang_table">
		            <table class="table text-center">
						<thead class="text-center">
							<tr>
								<th scope="col" class="text-center">Available Languages</th>
							</tr>
						</thead>
						<tbody id="table_body" >
							 @foreach($languages as $language)
							 <tr>
								<td>{{ $language->languageName }}</td>
							</tr>
                            @endforeach
							
						<tr>
						</tbody>
					</table>
				</div>
	    </section>
	    <div class="clearfix"></div>
	</div>

@endsection

@section('footer_script')
{{-- all footer script goes here --}}
<script src="{{ asset('admin/assets/chosen.jquery.js') }}" type="text/javascript"></script>
<script src="{{ asset('admin/assets/prism.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('admin/assets/init.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.js"></script>

	<script>
		$('#alert').hide();
		$('#range').on('change',function(){
			//console.log("hi");
			if($('#ifHasRange').css('display') == 'none'){
				document.getElementById("ifHasRange").style.display = "block";
				$("[name='end_date']").attr("required", true);
			}else{
				document.getElementById("ifHasRange").style.display = "none";
				$("[name='end_date']").removeAttr("required", true);
			}
		});

		$('#specYear').on('change',function(){
			if($('#ifYes').css('display') == 'none'){
				document.getElementById("ifYes").style.display = "block";
				$("[name='year']").attr("required", true);
			}else{
				document.getElementById("ifYes").style.display = "none";
				$("[name='year']").removeAttr("required", true);
			}
		});
	    //====================================================== create and delete div 
	    $('.chosen-select').on('change', function(evt, params) {
			if (params.selected != undefined) {
				//add the new div with id
				$('#dynamic').append(`
					<div id="`+params.selected+`">
						<div class="form-group">
							<h3 class="text-center">Language : `+params.selected+`</h3>
		                    <label class="control-label col-sm-2" for="holiday_title">Holiday Title(`+params.selected+`):</label>
		                    <div class="col-sm-10">
		                        <input type="text" class="form-control" id="holiday_title" placeholder="Enter Holiday Title" name="`+params.selected+`_title" required>
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="control-label col-sm-2" for="holiday_desc">Holiday Description:</label>
		                    <div class="col-sm-10">
		                        <textarea class="form-control" rows="5" id="holiday_desc" placeholder="Enter Holiday Description" name="`+params.selected+`_description" required></textarea>
		                    </div>
		                </div>
	                </div>
	                `);
			}
			if (params.deselected != undefined) {
				//cancel the div using id
				//console.log(params.deselected);
				$('#'+params.deselected).remove();
			}
		});

	    //======================================================= ajax request 
	    $( "#language_ajax" ).submit(function( event ) {
 
        // console.log('working success');
          // Stop form from submitting normally
          event.preventDefault();
         if($("#add-langauge").val() == "") return ;
          // Get some values from elements on the page:
          var $form = $( this ),
            term = $form.find( "input[name='languageName']" ).val(),
            url = $form.attr( "action" );

          // Send the data using post
          var posting = $.post( url, { "_token": $('#token').val(), "languageName": term } );
         
          var succ = "language added";
         var denied = "already has";
          // get the return data
          posting.done(function( data ) {
            console.log(data);
            if (data != 'null' ) {
                $('#chosen').append('<option value="'+data+'">'+ data +' </value>');
                $('#chosen').trigger('chosen:updated');
                $('#table_body').append(`
                	<tr>
						<td>`+data+` <span class="badge badge-secondary">new</span></td> 
					</tr>`
					);
                $('#alert').show();
				$('#alert').html(succ);
				setTimeout(function(){ 
		            //$('#alert').removeClass('alert alert-danger');
		            $('#alert').hide();
		            $('#alert').html('');
		        }, 3000);

            }else{
            	$('#alert').show();
				$('#alert').html(denied);
				setTimeout(function(){ 
		            //$('#alert').removeClass('alert alert-danger');
		            $('#alert').hide();
		            $('#alert').html('');
		        }, 3000);
            }
            //empty the tags input
            $("#add-langauge").val('');
            //if i dont trigger , than it wont update
          });
        });

	    //================================== putting the language on chosen 
	    var all_languages = <?php echo json_encode($single_language); ?> ;
	    var all_description = <?php echo json_encode($single_description); ?>;

		$( document ).ready(function() {
		    $.each(all_description , function(key,value){
	            //console.log(value);
	            $("#chosen option[value='" + value.lang + "']").attr("selected","selected");

	            

	            $('#dynamic').append(`
					<div id="`+value.lang +`">
						<div class="form-group">
							<h3 class="text-center">Language : `+value.lang+`</h3>
		                    <label class="control-label col-sm-2" for="holiday_title">Holiday Title :</label>
		                    <div class="col-sm-10">
		                        <input type="text" class="form-control" id="holiday_title" placeholder="Enter Holiday Title" name="`+value.lang +`_title" required value="`+value.title+`">
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label class="control-label col-sm-2" for="holiday_desc">Holiday Description :</label>
		                    <div class="col-sm-10">
		                        <textarea class="form-control" rows="5" id="holiday_desc" placeholder="Enter Holiday Description" name="`+value.lang +`_description" required>`+value.description+`</textarea>
		                    </div>
		                </div>
	                </div>
	                `);
	            $('#chosen').trigger('chosen:updated');
	        });
		    
			// validate the comment form when it is submitted
			$("#holidayform").validate();
	    });
	    //============================
	</script>
@endsection