<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->hasRole('parent')){
                return redirect('/apoderado');
            }
            if(auth()->user()->hasRole('teacher|administrator|superadministrator')){
                return redirect('/admin');
            }
            abort(401, 'This action is unauthorized.');
    }
}
