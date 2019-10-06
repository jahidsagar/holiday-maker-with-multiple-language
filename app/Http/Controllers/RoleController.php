<?php

namespace App\Http\Controllers;
use App\Http\Middleware\AdminCheck;
use Illuminate\Http\Request;
use App\User;
class RoleController extends Controller
{
    //
    function __construct() {
        $this->middleware(['auth', AdminCheck::class]);
        //add the middleware of admin||user
        //if we block all random user until accesp than may be 
        //no need user middleware , coz we block everyone
    }
    public function index()
    {
    	return view('admin.includes.role.role',['users'=>User::all()]);
    }

    public function setRole(Request $request)
    {
    	//return $request->all();
    	$var = User::findorfail($request->userId);
    	$var->roles_id = $request->role;
    	if ($var->save()) {
    		return redirect('/role')->with('msg','role change successful');
    	}
    	return redirect('/role')->with('msg','may be some error !!!');
    }
}
