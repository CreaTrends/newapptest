<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('role:teacher|administrator|superadministrator');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->user()->id;
        $user = User::with('profile')->where('id',$userId)->first();
        return view('admin.index',compact('user'));
    }
    public function apoderado()
    {
        return view('apoderados.index');
    }
}
