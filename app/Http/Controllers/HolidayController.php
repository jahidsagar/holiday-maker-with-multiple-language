<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Middleware\AdminUserCheck;
use App\holiday;
use App\month;
use App\language;
use App\description;
class HolidayController extends Controller
{
    //
    function __construct() {
        $this->middleware(['auth', AdminUserCheck::class]);
    }
    public function holidaylist($id)
    {
    	// return $id;
        $holidays_all = DB::table('months')
                        ->where('months.id',$id)
                        ->join('holidays', 'months.id', '=', 'holidays.month_id')
                        ->join('description_holidays', 'description_holidays.holiday_id', '=', 'holidays.id')
                        ->join('descriptions', 'descriptions.id', '=', 'description_holidays.description_id')
                        ->join('languages','languages.id','=','descriptions.language_id')
                        ->select(
                            'months.id as monthId',
                            'months.monthName',
                            'months.package_id as monthPackage', 
                            'holidays.id as HolidaysId',
                            'holidays.hasRange',
                            'holidays.startDate',
                            'holidays.endDate',
                            'holidays.yearSpecific',
                            'holidays.specificYear',
                            'holidays.month_id',
                            'descriptions.*',
                            'languages.languageName'
                        )
                        ->get();
    	return view('admin.includes.holiday.holidaylist',
    		[
    			'month'=>month::findorfail($id),
                'holidays'=>$holidays_all
    		]
    	);
    }

    public function createholiday($id)
    {
    	// return (new language())->all_languages();
    	return view('admin.includes.holiday.createholiday',
    		[
    			'month_id'=>$id,
    			'languages'=>(new language())->all_languages(),
    		]
    	);
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date'=>'required',
            'hasRange'=>'required',
            'year_specific'=>'required',
            'month_id'=>'required',
            'languages'=>'required'
        ]);

        $var = new holiday();
        
        $var->startDate = $request->start_date ;
        $var->hasRange = $request->hasRange == 'yes'? true : false ;
        if($request->hasRange == 'yes'){
            $request->validate([
                'end_date'=>'required',
            ]);
            $var->endDate = $request->end_date;
        }
        // return $request->hasRange;
        $var->yearSpecific = $request->year_specific == 'yes'? true : false ;
        if ($request->year_specific == 'yes') {
            $request->validate([
                'year'=>'required',
            ]);
            $var->specificYear = $request->year ;
        }
        
        $var->month_id = $request->month_id ;
        if ($var->save()) {
            $desc = new description();
            foreach ($request->languages as $language) {
                $language_title = $request->input($language.'_title');
                $language_description =$request->input($language.'_description');
                $arr[] = $desc->insertDescription($language , $language_title , $language_description);
            }

            foreach ($arr as $id) {
                DB::table('description_holidays')->insert(
                    ['description_id' => $id, 'holiday_id' => $var->id]
                );
            }
            return redirect('/holidays/'.$request->month_id)->with('msg','create successful');
        }
        return redirect('/holidays/'.$request->month_id)->with('msg','may be some error !!!');
    }

    public function edit($id)
    {
        $var = holiday::findorfail($id);
        $desciptions_all = DB::table('holidays')
                ->where('holidays.id','=',$id)
                ->join('description_holidays','description_holidays.holiday_id','=','holidays.id')
                ->join('descriptions','descriptions.id','=','description_holidays.description_id')
                ->join('languages','languages.id','=','descriptions.language_id')
                ->select(
                    'descriptions.*',
                    'languages.languageName'
                )
                ->get();


        foreach ($desciptions_all as $value) {
            $single_description[] = ['lang'=>$value->languageName,'title'=>$value->title , 'description'=>$value->description];
            $single_language[]=['language_name'=>$value->languageName];
        }

        // return $single_description;
        return view('admin.includes.holiday.holidayedit',
            [
                'holiday'=>$var,
                'single_language'=>$single_language,
                'single_description'=>$single_description,
                'languages'=>(new language())->all_languages(),
            ]
        );
    }

    public function update(Request $request , $id)
    {
        $request->validate([
            'start_date'=>'required',
            'hasRange'=>'required',
            'year_specific'=>'required',
            'month_id'=>'required',
            'languages'=>'required'
        ]);
        $var = holiday::findorfail($id);
        //grap all many to many id from description_holidays
        $all_description_id = DB::table('description_holidays')->where('holiday_id',$var->id)->get();
        //delete all rows
        DB::table('description_holidays')->where('holiday_id', $id)->delete();
        foreach ($all_description_id as $key) {
            DB::table('descriptions')->where('id', $key->description_id)->delete();
        }


        $var->startDate = $request->start_date ;
        $var->hasRange = $request->hasRange == 'yes'? true : false ;
        if($request->hasRange == 'yes'){
            $var->endDate = $request->end_date;
        }else{
            $var->endDate = null;
        }
        // return $request->hasRange;
        $var->yearSpecific = $request->year_specific == 'yes'? true : false ;
        if ($request->year_specific == 'yes') {
            $var->specificYear = $request->year ;
        }else{
            $var->specificYear = null;
        }
        
        $var->month_id = $request->month_id ;
        if($var->save()){

            $desc = new description();
            foreach ($request->languages as $language) {
                $language_title = $request->input($language.'_title');
                $language_description =$request->input($language.'_description');
                $arr[] = $desc->insertDescription($language , $language_title , $language_description);
            }

            foreach ($arr as $id) {
                DB::table('description_holidays')->insert(
                    ['description_id' => $id, 'holiday_id' => $var->id]
                );
            }
            return redirect('/holidays/'.$request->month_id)->with('msg','edit successful');
        }
        return redirect('/holidays/'.$request->month_id)->with('msg','may be some error !!!');
    }
}
