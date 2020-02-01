<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		//App::setLocale($locale);
        return view('home');
    }
	public function changelangouage(Request $request){
	
		 App::setLocale($request['lang']);
		// $lang = $request['lang'];
		// $routeArray = app('request')->route()->getAction();
		return app()->getLocale();
		// return;
		// return redirect()->back();		

	}
}
