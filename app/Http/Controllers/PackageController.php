<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AdminUserCheck;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;

use App\package;
use App\month;
use App\holiday;

class PackageController extends Controller
{
    //
	function __construct() {
        $this->middleware(['auth', AdminUserCheck::class],['except' => array('all_holidays','all_holidays_with_date')]);
        //add the middleware of admin||user
        //if we block all random user until accesp than may be 
        //no need user middleware , coz we block everyone
    }

    public function index()
    {
    	return view('admin.includes.apps.app',[
    		'apps'=>DB::table('packages')->where('user_id',\Auth::user()->id)->orderBy('updated_at','desc')->get(),
            'edit'=>false
    	]);
    }

    public function store(Request $request)
    {
    	// return $request->all();
        $request->validate([
            'package_name'=>'required',
            'app'=>'required|unique:packages'
        ]);

    	$var = new package();
    	$var->name = $request->package_name ;
    	$var->app = $request->app ;
    	$var->user_id = \Auth::user()->id ;
    	if(!$var->save()){
    		return redirect('/apps')->with('msg','may be some error !!');
    	}
    	return redirect('/apps')->with('msg','package save successfull');
    }

    public function edit($id)
    {
        return view('admin.includes.apps.app',[
            'app'=>package::all()
                    ->where('user_id',\Auth::user()->id)
                    ->where('id',$id)
                    ->first(),
            'edit'=>true,
        ]);
    }

    public function update(Request $request , $id)
    {
        
        $this->validate($request, [
            'app' => [
                'required',
                Rule::unique('packages')->ignore($id),
            ],
        ]);


        $var = package::findorfail($id);
        $var->name = $request->package_name;
        $var->app = $request->app;
        if(!$var->save()){
            return redirect('/apps')->with('msg','may be some error !!');
        }
        return redirect('/apps')->with('msg','package save successfull');
    }

    //we cant delete any package until all links are removed
    public function delete($id)
    {
        //find the file 
        //and delete
        //and redirect
    }

    //===================================== API ===============
    public function all_holidays($appName)
    {
        $appDetails = package::all()->where('app',$appName)->first();
        if(!isset($appDetails)) return null;
        $allMonths = month::all()->where('package_id',$appDetails->id);
        foreach ($allMonths as $month) {
            $holidays = DB::table('holidays')->where('month_id',$month->id)->select('holidays.id','holidays.hasRange','holidays.startDate','holidays.endDate','holidays.yearSpecific','holidays.specificYear','holidays.created_at','holidays.updated_at')->get();
            foreach ($holidays as $holiday) {
                $desc = DB::table('description_holidays')
                    ->where('description_holidays.holiday_id','=',$holiday->id)
                    ->join('descriptions', 'descriptions.id', '=', 'description_holidays.description_id')
                    ->select('descriptions.languageName','descriptions.title','descriptions.description')
                    ->get();

                    $_all[] = [
                        'monthname'=>$month->monthName,
                        'monthweight'=>$month->weight,
                        'holiday'=>$holiday,
                        'descriptions'=>$desc
                    ];
            }
        }
        if (!isset($_all)) return $allMonths;
        return $_all;
    }

    public function all_holidays_with_date($appName , $date)
    {
        $appDetails = package::all()->where('app',$appName)->first();
        if(!isset($appDetails)) return null;
        $allMonths = month::all()->where('package_id',$appDetails->id);
        foreach ($allMonths as $month) {
            $holidays = holiday::all()->where('month_id',$month->id)->where('updated_at','>',$date);
            foreach ($holidays as $holiday) {
                $desc = DB::table('description_holidays')
                    ->where('description_holidays.holiday_id','=',$holiday->id)
                    ->join('descriptions', 'descriptions.id', '=', 'description_holidays.description_id')
                    ->select('descriptions.languageName','descriptions.title','descriptions.description')
                    ->get();

                    $_all[] = [
                        'monthname'=>$month->monthName,
                        'monthweight'=>$month->weight,
                        'holiday'=>$holiday,
                        'descriptions'=>$desc
                    ];
            }
        }
        if (!isset($_all)) return $allMonths;
        return $_all;
    }
}
