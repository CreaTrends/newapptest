<?php

namespace App\Http\Controllers;

use App\Curso;
use App\User;
use App\Note;
use App\Alumno;
use App\Profile;
use App\Notebook;
use App\Activity;
use App\Attached;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Response;

use Carbon\Carbon;
use Notification;
use App\Notifications\NewNotebook;
use Mail;
use App\Mail\WelcomeParent;

use App\Mail\DailyReportEmail;




class CursoController extends Controller
{
    

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = User::find(auth()->user()->id);
        $userId=$user->id;
        $cursos = User::with('teacher_course')->withCount('teacher_course')->where('id',$user->id)->get();
        //return view('admin.cursos.index',compact('cursos'));

        


        if(!auth()->user()->hasRole('administrator|superadministrator')){
            $cursos = Curso::with('teacher','alumnos_list')->whereHas('teacher', function($q) use($userId){
                $q->where('user_id', $userId);
            })->get();
            $users = User::where('id', '!=', $userId)->whereRoleIs('teacher')->get();

            return view('admin.cursos.index',compact('cursos','users'));
        }

        $cursos = Curso::with('teacher','alumnos_list')->get();

        $users = User::where('id', '!=', $userId)->whereRoleIs('teacher')->get();

        return view('admin.cursos.index',compact('cursos','users'));
        /*echo "<pre>";

        return json_encode(Curso::with('teacher','alumnos_list')->get(),JSON_PRETTY_PRINT);*/

        /*$cursos = Curso::find(3);
        $user = Curso::where('id', 3)->with('alumnos')->get();

        $alumno = new Alumno;
        $alumno->name = 'Walk the dog';
        $alumno->lastname = 'Walk Barky the Mutt';

        $cursos->alumnos()->save($alumno);
        echo "<pre>";
        return json_encode($user,JSON_PRETTY_PRINT);*/
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
        $this->validate($request, [
            'name' => 'required',
        ]);

        $curso = Curso::create($request->all());

        $curso->teacher()->attach($request->get('teachers'));
        return redirect()->route('cursos.show', $curso->id)->with('info', 'Curso ingresado con éxito');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $curso = Curso::findOrFail($id);
        $cursos = Curso::with('alumnos','teacher')->find($curso->id);
        $teachers = User::with('profile')->whereRoleIs('teacher')->get();
        //$teacher = $teachers->profile->pluck('id')->toArray();
        $assignedTeacher  = $curso->teacher->pluck('id')->toArray();
        
        /*echo "<pre>";
        return json_encode($cursos,JSON_PRETTY_PRINT);*/
        return view('admin.cursos.show',compact('cursos','teachers','assignedTeacher'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
        
        //return redirect()->route('cursos', $cursos->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $this->validate($request, [
            'name' => 'required',
        ]);
        $cursos = Curso::find($id);
        $cursos->fill($request->all())->save();
        $cursos->teacher()->sync($request->get('teachers'));
        return redirect()->route('cursos.show', $cursos->id)->with('info', 'Curso actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $note = Curso::find($id)->delete();
        return redirect()->back()->with('info', 'Eliminado correctamente');
    }

    public function getdata(Request $request)
    {
        //
        if($request->has('user_id') && !auth()->user()->hasRole('administrator|superadministrator')){
            $cursos = Curso::with('teacher')->whereHas('teacher', function($q){
                $q->where('user_id', 3);
            })->get();

            return $cursos;

        }

        return Curso::all();
    }

    public function message($id){
        $cursos = Curso::findOrFail($id);

        return view('admin.cursos.notebook',compact('cursos'));

    }
    public function notify(){
        
        $curso = Curso::with('alumnos')->find(1);
        $alumnos = $curso->alumnos()->get();
        
        foreach($alumnos as $alumno){
            $id = $alumno->id;
            
            //$get  = Alumno::with('parent')->find($alumno->id)->first(array('name','id'));

            $Videos = Alumno::with('parent')->whereHas('parent', function($q) use($id){
                $q->where('alumno_parent.alumno_id','=',$id);
            })->first(array('id','firstname','lastname'));

            $data[] = $Videos;

            $buildingCategories[] = collect($Videos->parent)->map(function ($item, $key) {
                return $item->id;
            });
            foreach($Videos->parent as $parent){
                $apoderados[]=$parent;
            }
            
        }

        foreach($apoderados as $apoderado ){

            $user = User::with('profile')->find($apoderado->id);

            Mail::to($user)
            ->bcc('jalbornozdesign@gmail.com','jotaeme')
            ->send(new WelcomeParent($user));
        }
        //Mail::to($user)->send(new WelcomeParent($user));
       
        echo "<pre>";
        return json_encode($user,JSON_PRETTY_PRINT);
        //Notification::route('mail', 'taylor@example.com')->notify(new NewNotebook($user));

    }

    /**
     * Show the form for send announcement .
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function notes($id){
        $curso = Curso::FindOrFail($id);
        $notes = Note::with('user')
        ->withCount('readed','unreaded')
        ->where('curso_id',$id)
        ->orderBy('sticky', 'DESC')
        ->orderBy('created_at', 'DESC')
        ->paginate(10);
        
        /*echo "<pre>";
        return json_encode($notes,JSON_PRETTY_PRINT);*/
        return view('admin.cursos.notes',compact('curso','notes','user'));
    }

    /**
     * Show the form for send announcement .
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function notebook($id){
        $cursos = Curso::with('alumnos')->where('id',$id)->first();
        return view('admin.cursos.notebook',compact('cursos'));
    }

    public function notebookstore(Request $request){

        //echo "<pre>";
        //$avatar[] = $request->file('fileupload');

        

        $this->validate($request, [

                'fileupload' => 'sometimes|required|array|min:1',
                'fileupload.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);
        
        $cursoID = $request->curso['id'];
        $notebookDateHuman = Carbon::parse($request->curso['date'])->diffForHumans();
        $notebookDate = Carbon::parse($request->curso['date']);
        $notebookDateLong = $notebookDate->format('Y-m-d');
        if($request->hasfile('fileupload')){

            foreach($request->file('fileupload') as $image)
            {
                $name=$image->getClientOriginalName();
                
                $sub_name= md5($name.time()).'.'.$image->getClientOriginalExtension();
                $image->move(public_path().'/static/image/notebook/', $sub_name);  
                $data[] = $sub_name;  
            }
        }
        
        foreach($request->alumnos as $alumno_notebook){

            /*foreach($alumno_notebook['food'] as $k=>$v){
                $rr = $v['type'].','.$v['amount'];
                $dr[]=$rr;
            }
            $notebook_to_user[] = array(
                "alumno_id"=>$alumno_notebook['alumno_id'],
                "alumno_food"=>serialize($alumno_notebook['food']),
                "ddd"=>$dr

            );*/
            if(!isset($alumno_notebook['alumno_estado']) || !array_filter($alumno_notebook['food']) || !array_filter($alumno_notebook['nap']) || !array_filter($alumno_notebook['mood'])){
               continue;
           }
            
            $notebookInsert = array(
                "alumno_id"=>$alumno_notebook['alumno_id'],
                "foods"=>serialize($alumno_notebook['food']),
                'activities'=>$request->activities
            );
            $notebook = new Notebook;
            if(isset($alumno_notebook['alumno_estado'])){
                $estado = $alumno_notebook['alumno_estado'];
            }else {
              $estado = '';  
            }

            $check_poops = array_filter(array_map('array_filter', $alumno_notebook['mood'])) ? $alumno_notebook['mood']:null;
            $check_foods = array_filter(array_map('array_filter', $alumno_notebook['food'])) ? $alumno_notebook['food']:null;
            $check_naps = array_filter(array_map('array_filter', $alumno_notebook['nap'])) ? $alumno_notebook['nap']:null;
            
            $notebook->foods        =   $check_foods;
            $notebook->moods        =   $estado;
            $notebook->naps         =   $check_naps;
            $notebook->depositions   =  $check_poops;
            $notebook->comment      =   $alumno_notebook['observation'];
            $notebook->notebook_date=   Carbon::now();
            $notebook->save();

            $notebook->alumno()->attach($alumno_notebook['alumno_id']);

            $theactivity[] = $request->activities;
            if(!empty($request->activities)){
                $actividad = new Activity();
                $actividad->description = $request->activities;
                $actividad->save();
                $actividad->notebooks()->attach($notebook->id);
            }
            if(!empty($data)){
                $form= new Attached();
                $form->file=$data;        
                $form->save();
                $form->notebooks()->attach($notebook->id);
            }

            $alumnoId = $alumno_notebook['alumno_id'];
            $tt = Alumno::with('parent')->where('id','=',$alumno_notebook['alumno_id'])->first();


            
            /*foreach($tt->parent as $apoderados){
                $email = User::where('id',$apoderados->id)->first();
                $sender = Profile::where('user_id',auth()->user()->id)->first();

                $objDemo = new \stdClass();
                $objDemo->sender_name = $sender->first_name;
                $objDemo->date = Carbon::today()->toFormattedDateString();
                $objDemo->parent = $email->name;
                $objDemo->alumno_name = $tt->firstname;

                Mail::to($email)->send(new DailyReportEmail($objDemo));
                //$emails = ['myoneemail@esomething.com', 'myother@esomething.com','myother2@esomething.com'];
                
            }*/

            // verificamos notificaciones 
            //$sent_to = User::whereIn('id',$recipientes)->get();

            foreach($tt->parent as $users){
                $user = User::findorFail($users->id);
                $user->notify(new NewNotebook($notebook, auth()->user()->id));
                //$user->notifications()->delete();
            }
            
            

            
            //Mail::to($apoderados)->send(new DailyReportEmail($apoderados));
            
            /*$activity = new Activity();
            $activity->notebook_id = $notebook->id;
            $notebook->activities()->save($activity);*/
            
        }
        /*foreach($usuario as $padre){
                Mail::to($padre)->send(new DailyReportEmail($padre));
            }*/
        
        /*echo "<pre>";
        return json_encode($tt,JSON_PRETTY_PRINT);*/
        return redirect()->route('cursos.show', ['id' => $cursoID])->with('info', 'Comunicación creada con éxito');
        /*return json_encode($request->activities,JSON_PRETTY_PRINT);*/

    }

    
}
