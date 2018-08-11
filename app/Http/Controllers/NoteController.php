<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;
use Storage;
use App\User;
use App\Curso;
use App\Alumno;

use Carbon\Carbon;   

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        /*$user = User::find(auth()->user()->id);
        $userId=$user->id;
        //$notes = Alumno::with('parent')->where('user_id',auth()->user()->id)->get();
        
        $cursos = Alumno::with('parent')->where('id',$userId)->get();

        $alumnos = Alumno::with('curso')->where('id',10)->whereHas('parent', function($q) use($userId){
                $q->where('user_id', $userId);
            })->get();

        foreach($alumnos as $alumno){
            $id = $alumno->id;
            $xx[] = Curso::whereHas('alumno', function($q) use($id){
                $q->where('alumno_id', $id);
            })->first()->id;

        }



        $notes = Note::whereIn('curso_id',$xx)->get();*/
        $userId=auth()->user()->id;
        
        $childs = Alumno::with('parent')->whereHas('parent', function($q) use($userId){
                $q->where('user_id', $userId);
            })->get();

        //return view('apoderados.childs',compact('childs'));

        echo "<pre>";
        return json_encode($childs,JSON_PRETTY_PRINT);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->user_id = auth()->user()->id;

        $note = Note::create([
            'user_id'   =>  auth()->user()->id,
            'curso_id'  =>  $request->curso_id,
            'subject'   =>  $request->subject,
            'body'      =>  nl2br($request->message),
            'attached'  =>  $request->file('file_note'),
            'status'    =>  1,
            'sticky'    =>  $request->get('sticky') ? $request->get('sticky'):'0'
        ]);
        /*$fileName = md5(time()).'.'.$request->file('fileupload')->getClientOriginalExtension();*/
        if($request->file('file_note')){
            $path = Storage::disk('public')->put('files',  $request->file('file_note'));
            $note->fill(['attached' => $path])->save();

            
        }
            

        return redirect()->route('notes', ['id' => $request->curso_id])->with('info', 'Entrada creada con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , $id)
    {
        //
        $child_id = $id;
        $user = User::find(auth()->user()->id);
        $userId=$user->id;
        //$notes = Alumno::with('parent')->where('user_id',auth()->user()->id)->get();
        
        $cursos = Alumno::with('parent')->where('id',$userId)->get();

        /*$alumnos = Alumno::with('curso')->where('id',$child_id)->whereHas('parent', function($q) use($userId){
                $q->where('user_id', $userId);
            })->get();*/
        $alumnos = Alumno::with('curso')->whereHas('parent', function($q) use($userId){
                $q->where('user_id', $userId);
            })->get();

        foreach($alumnos as $alumno){
            $id = $alumno->id;
            $xx[] = Curso::whereHas('alumno', function($q) use($id){
                $q->where('alumno_id', $id);
            })->first()->id;

        }

        $notes = Note::whereIn('curso_id',$xx)->get()->groupBy(function($item){ 
            return Carbon::parse($item->created_at)->format('Y-m-d');
        });

        return view('apoderados.notes',compact('notes'));

        echo "<pre>";
        return json_encode($notes,JSON_PRETTY_PRINT);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $note = Note::find($id)->delete();
        return redirect()->back()->with('info', 'Eliminado correctamente');
        
    }
}
