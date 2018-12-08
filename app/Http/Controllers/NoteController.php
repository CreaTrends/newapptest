<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Notifications\NewNoteNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

use App\Note;
use App\User;
use App\Profile;
use App\Curso;
use App\Alumno;

use Mail;


class NoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|teacher|administrator|parent');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        

        $user = User::with('profile')->find(auth()->user()->id);
        $user_id = auth()->user()->id;

            $query = Note::query();
            $query->when($request->get('filter') == 'sent', function ($q, $user_id) { 
                return $q->whereUserId($user_id);
            });
            $notes = $query->with('author');
            $notes = $query->orderBy('sticky','DESC');
            $notes = $query->orderBy('created_at','DESC');

            $notes = $query->paginate(10);

            $cursos = Curso::query();
            $cursos = $cursos->when($user->hasRole('teacher', true), function ($q) {
                $q->whereHas('teacher', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });
            });

            $cursos = $cursos->get();

            //return response()->json($cursos,200,[],JSON_PRETTY_PRINT);
            /*$cursos->when($user->hasRole('teacher', true), function ($q) {
                return $q->whereHas('students',function($q) use($message_to){
                    $q->whereIn('alumno_id',$message_to);
                });
            });
            $cursos->when(request('filter_by') == 'date', function ($q) {
                return $q->orderBy('created_at', request('ordering_rule', 'desc'));
            });*/
       
            //return $cursos;
        //return $request->get('filter');
            //return response()->json($notes,200,[],JSON_PRETTY_PRINT);

            $notification = auth()->user()->notifications()->where('id',$request->get('nid'))->first();
        /*dd($notes);*/
        if($notification){
            $notification->markAsRead();
        }
        

        return view('admin.notes.index', compact('notes','user','cursos'));

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        return 'hola ';
    }

    public function save(Request $request)
    {

        //
        $this->validate($request, [
            'recipients' => 'required',
            'subject' => 'required',
            'message' => 'required',
            'file_note' => 'sometimes|required|min:1',
            'file_note.*' => 'file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048'
        ]);

        $input = $request->all();

        
        if($input['recipients'] == '0'){
            $er = Curso::all()->pluck('id')->toArray(); 
        }else {
           $er = $request->recipients; 
        }
        // Get parent of child in courses 
        $message_to = Alumno::whereHas('curso',function($q) use($er){
            $q->whereIn('curso_id',$er);
        })->pluck('id')->toArray();

        // Get parents ids
        $recipientes = User::whereHas('students',function($q) use($message_to){
            $q->whereIn('alumno_id',$message_to);
        })->pluck('id')->toArray();

        // setup variables
        $fake_curso = Curso::first()->id;

        $request['user_id'] = auth()->user()->id;
        $request['curso_id'] = $fake_curso;
        $request['body'] = $request->message;

        // insertamos la circular
        $note = Note::create($request->all());

        // sincronizamos los usuarios
        $note->note_user()->sync($recipientes);

        // si tiene archivo adjuntos
        
        if($request->hasfile('photos')){

            foreach($request->file('photos') as $image)
            {
                $name=$image->getClientOriginalName();

                $uploadedFile = $image;
                $filename = time().$uploadedFile->getClientOriginalName();
                
                $sub_name = md5($name.time()).'.'.$image->getClientOriginalExtension();
                //$image->move(public_path().'/static/files/', $sub_name);

                
 
                $image->move(public_path().'/static/uploads/notes/', $sub_name);

                $the_file = array(
                    'name'=>$name,
                    'encrypt'=>$sub_name,
                    'type'=>$image->getClientOriginalExtension()
                );

                //$path = Storage::disk('public')->put('files',  $sub_name);
                
                $data[] = $the_file; 


            }
            $note->fill(['attached' => $data])->save();
        }
      
        /*$cover = $request->file('bookcover');
        $extension = $cover->getClientOriginalExtension();
        Storage::disk('public')->put($cover->getFilename().'.'.$extension,  File::get($cover));*/
        
        // verificamos notificaciones 
        $sent_to = User::whereIn('id',$recipientes)->get();
        $when = Carbon::now()->addSeconds(5);
        foreach($sent_to as $users){
            $user = User::findorFail($users->id);
            $user->notify((new NewNoteNotification($note, $user->id))->delay($when));
            
            //$user->notifications()->delete();
        }
        // notificamos al equipo
        if($request->has('include_team')) {

            $to_teacher = User::where('id','!=',auth()->user()->id)->whereHas(
                'roles', function($q){
                    $q->whereIn('name', ['superadministrator','teacher','administrator']);
                }
            )->get();

            foreach($to_teacher as $users){
                $user = User::findorFail($users->id);
                $user->notify(new NewNoteNotification($note, $user->id));
                
                //$user->notifications()->delete();
            }

        }


//$user->notify(new NewNoteNotification($note, $user->id))->delay($when);


        

        $html = view('admin.notes.noteslist', compact('note'))->render();

        
            return response()->json([
                'status' => 'OK',
                'sticky' => $note->sticky,
                'id' => $note->id,
                'pro' => $note->user,
                'html' => $html
            ]);
        
        

        return response()->json(['error' => 'Not authorized.'],403);
        

       // return redirect()->route('notes.index')->with('info', 'Circular enviada con éxito');
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
        if($request->hasfile('file_note')){

            foreach($request->file('file_note') as $image)
            {
                $name=$image->getClientOriginalName();
                
                $sub_name= md5($name.time()).'.'.$image->getClientOriginalExtension();
                //$image->move(public_path().'/static/image/notebook/', $sub_name); 

                //$path = Storage::disk('public')->put('files',  $sub_name);
                
                $data[] = $sub_name; 


            }
        }

        return $data;
        //$note->fill(['attached' => $data])->save(); 
        


            

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

        $notes = Note::whereHas('note_user', function($q) use($id){
                $q->where('note_id', $id);
            })->get();


        
        /*$user->hasRoleAndOwns('admin', $notes);*/
        /*if (!$user->owns($notes, 'user_id')) { //This will check the 'user_id' inside the $post
            $notes->note_user()->where('user_id',auth()->user()->id)->update(['readed' => 0 ]);
        }*/

        /*$update = Note::find(126)->note_user()->wherePivot('user_id', '=', 13)->whereNull('readed_at')
        ->update([
            'readed_at' => Carbon::now(),
            'readed' => '1'
        ]);*/
        return response()->json(['error' => 'Not authorized.'],403);

        return $notes;
        
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

    private function inside($name){
        return 'esto es uan funcion interna';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::find(auth()->user()->id);
        $note = Note::with('author','note_user','curso','readed')->find($id);

        $cursos = Curso::all();

        $usuarios = User::All();

        $html = view('admin.notes.noteslist', compact('note'))->render();
        
        
        if(request()->ajax()) {
            return response()->json($note);
        }
        return response()->json($note,200,[],JSON_PRETTY_PRINT);

        return response()->json(['error' => 'Not authorized.'],403);

        
        if ($user->hasRole('superadministrator')) { //This will check for 'idUser' inside the $post
            
        }else {
            $this->authorize('update',$note);
        }
        
        return view('admin.notes.edit', compact('note','cursos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'recipients' => 'sometimes|required',
            'subject' => 'required',
            'message' => 'required',
            'file_note' => 'sometimes|required|min:1',
            'file_note.*' => 'file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048'
        ]);
        $note = Note::find($id);
        $this->authorize('update',$note);
        $note->body = $request->message;
        $note->subject = $request->message;
        $note->sticky = $request->sticky;
        $note->status = '1';
        $note->fill($request->all())->save();

        if(request()->has('recipients')){
        // set variables 
        $curso_id = request()->recipients;

        // Get parent of child in courses 
        $message_to = Alumno::whereHas('curso',function($q) use($curso_id){
            $q->whereIn('curso_id',$curso_id);
        })->pluck('id')->toArray();

        // Get parents ids
        $recipientes = User::whereHas('students',function($q) use($message_to){
            $q->whereIn('alumno_id',$message_to);
        })->pluck('id')->toArray();


            $note->note_user()->sync($recipientes);
        }

        

        if($request->hasfile('photos')){

            foreach($request->file('photos') as $image)
            {
                $name=$image->getClientOriginalName();

                $uploadedFile = $image;
                $filename = md5($name.time()).$uploadedFile->getClientOriginalName();
                
                $sub_name = md5($name.time()).'.'.$image->getClientOriginalExtension();
                //$image->move(public_path().'/static/files/', $sub_name);

                
 
                $image->move(public_path().'/static/uploads/notes/', $sub_name);

                $the_file = array(
                    'name'=>$name,
                    'encrypt'=>$sub_name,
                    'type'=>$image->getClientOriginalExtension()
                );

                //$path = Storage::disk('public')->put('files',  $sub_name);
                
                $data[] = $the_file; 


            }
            $note->fill(['attached' => $data])->save();
        }

        $html = view('admin.notes.noteslist', compact('note'))->render();

        if(request()->ajax()) {
            return response()->json([
                'status' => 'OK',
                'id' => $id,
                'html' => $html
            ]);
        }

        
        
        
        //return redirect()->route('notes.index')->with('info', 'Entrada actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        
        $note = Note::findorfail($id)->delete();
        return redirect()->back()->with('info', 'Eliminado correctamente');
        
    }

    public function deleteall(Request $request){

        $noteIds = explode(',',$request->id);
        $userIds = is_array($noteIds) ? $noteIds : (array) func_get_args();

        $user = Auth::user();
        $notes = Note::whereIn('id',$noteIds)->get();

        foreach($notes as $note){
            $note->delete();
        }

        
        if(request()->ajax()) {
        return response()->json([
                'status' => 'OK',
                'ids' => $notes->pluck('id'),
                'title'=>$noteIds
            ],200);
        }

        

        
        return response()->json(['error' => $notes],403);

        //$html = view('admin.notes.noteslist', compact('note'))->render();

        

        
        //return redirect()->route('notes')->with('info', 'Entrada eliminada con éxito');

    }

    public function displaynote(Request $request , $id){

        try{
        $note = Note::where('id',$id)
        ->withCount('note_user')
        ->with('readed')
        ->with('unreaded')
        ->withCount('unreaded')
        ->firstOrFail();

        }catch(\Exception $e){

            return response()->json(['error' => 'Mismatch Url.'],404);

        }

        

        $html= view('admin.notes.display', compact('note'))->render();
        if(request()->ajax()) {
        return response()->json([
                'status' => 'OK',
                'message' => $html,
                'title'=>$note->subject
            ]);
        }

        return response()->json(['error' => 'Not authorized.'],403);
    }

    public function deleteuser(Request $request , $id){

        $note = Note::findorfail($id);

        $note->note_user()->detach(auth()->user()->id);

        return redirect()->back()->with('info', 'Eliminado correctamente');

       

    }
}
