<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return redirect('/apps');
        if(\Auth::user()->roles_id == 3){
            \Auth::logout();
            return redirect()->to('/')->with('msg', 'admin not approved you yet !!');
        }else{
            // return redirect()->route('root');
            return redirect()->to('/apps');
        }
    }
}
