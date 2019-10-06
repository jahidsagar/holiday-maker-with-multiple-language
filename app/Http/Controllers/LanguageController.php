<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Middleware\AdminUserCheck;
use App\language;

class LanguageController extends Controller
{
    //this controller is for language management
    //all kinds of relavent data must handle this file 
    //and this model
    function __construct() {
        $this->middleware(['auth', AdminUserCheck::class],['except' => array('ajax')]);
        //add the middleware of admin||user
    }

    public function index()
    {
    	return view('admin.includes.languages.language',[
    		'languages'=>language::all()->where('user_id',\Auth::user()->id),
            'edit'=>false
    	]);
    }

    public function store(Request $request)
    {
    	// return $request->all();
        $precheck = language::all()->where('languageName',$request->languageName)->where('user_id',\Auth::user()->id);
        if (count($precheck) > 0) {
            return null;
        }
    	$var = new language();
    	$var->languageName = $request->languageName;
        $var->user_id = \Auth::user()->id;

    	if (! $var->save()) {
    		return redirect('/languages')->with('msg','may be some errors !!!');
    	}
    	return redirect('/languages')->with('msg','language saved successful');
    }

    //save data from ajax request
    public function ajax(Request $request)
    {
        // return $request->all();
        $f = language::all()->where('languageName',strtolower($request->languageName))->where('user_id',\Auth::user()->id);
        if(count($f)>0) return 'null';
        $var = new language();
        $var->languageName = strtolower($request->languageName);
        $var->user_id = \Auth::user()->id;

        if (! $var->save()) {
            return 'null';
        }
        return $var->languageName;
    }


    public function edit($id)
    {
        // return language::all()
        //             ->where('user_id',\Auth::user()->id)
        //             ->where('id',$id)
        //             ->first();
        return view('admin.includes.languages.language',[
            'language'=>language::all()
                    ->where('user_id',\Auth::user()->id)
                    ->where('id',$id)
                    ->first(),
            'edit'=>true,
        ]);
    }

    public function update(Request $request, $id)
    {
        $var = language::findorfail($id);
        $var->languageName = $request->languageName;
        if (! $var->save()) {
            return redirect('/languages')->with('msg','may be some errors !!!');
        }
        return redirect('/languages')->with('msg','language saved successful');
    }
}
