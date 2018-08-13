<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Curso;
use App\Alumno;
use App\Notebook;
use Carbon\Carbon;

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

        $data = [];
        $data['cursos'] = Curso::count();
        $data['alumnos'] = Alumno::count();
        $data['parents'] = User::whereRoleIs('parent')->count();
        $data['active'] = User::where('first_login','1')->whereRoleIs('parent')->count();
        $data['not_active'] = User::where('first_login','0')->whereRoleIs('parent')->count();
        $data['teacher'] = User::whereRoleIs('teacher')->count();
        $data['notebooks'] = Notebook::count();
        $data['birthdays'] = Alumno::whereRaw('MONTH(birthday) = ?', [Carbon::now()->month])->get();
        /*echo "<pre>";
        return json_encode($data,JSON_PRETTY_PRINT);*/
        return view('admin.index',compact('user','data'));
    }
    public function apoderado()
    {
        return view('apoderados.index');
    }
}
