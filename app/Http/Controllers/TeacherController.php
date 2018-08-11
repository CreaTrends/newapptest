<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Curso;
use App\User;
use App\Teacher;
use App\Alumno;

class TeacherController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('role:teacher|administrator|superadministrator');
    }

    public function index(){
        $user = User::find(auth()->user()->id);
        $cursos = User::with('teacher_course')->withCount('teacher_course')->where('id',$user->id)->get();
        
        //return Curso::with('teacher')->where('id',$user->id)->get();
        return view('teacher.index',compact('cursos','user'));
        
    }
}
