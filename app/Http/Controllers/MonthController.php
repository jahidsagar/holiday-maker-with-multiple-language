<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Middleware\AdminUserCheck;
use App\month;
use App\package;
use App\Rules\Monthvalidation;

class MonthController extends Controller
{
    //all month associated execution goes
    //here and its associated model

    function __construct() {
        $this->middleware(['auth', AdminUserCheck::class]);
    }
    public function index($id)
    {
    	$package = package::findorfail($id);
    	$months = DB::table('months')->where('package_id',$id)->orderBy('weight', 'asc')->get();

    	return view('admin.includes.months.month',[
    		'package'=>$package,
    		'months'=>$months,
    		'edit'=>false
    	]);
    }

    public function store(Request $request)
    {
    	// return $request->all();
        $request->validate([
            'months_name'=>['required',new Monthvalidation($request->package_id)]
        ]);

        $var = new month();
        $var->monthName = $request->months_name ;
        $var->package_id = $request->package_id ;
        $var->weight = $request->weight ;
        if(!$var->save()){
        	return redirect('/months/'.$request->package_id)->with('msg','may be some error !!!');
        }
        return redirect('/months/'.$request->package_id)->with('msg','month name save successfull');
    	
    }

    public function edit($appId , $monthId)
    {
        return view('admin.includes.months.month',
        	[
        		'edit'=>true,
        		'month'=>month::findorfail($monthId),
        		'package'=>package::findorfail($appId)
        	]
        );
    }

    public function update(Request $request , $id)
    {
        $request->validate([
            
        ]);

        $var = month::findorfail($id);
        $var->monthName = $request->months_name ;
        $var->package_id = $request->package_id ;
        $var->weight = $request->weight;
        if(!$var->save()){
        	return redirect('/months/'.$request->package_id)->with('msg','may be some error !!!');
        }
        return redirect('/months/'.$request->package_id)->with('msg','edit successfull');
    }
}
