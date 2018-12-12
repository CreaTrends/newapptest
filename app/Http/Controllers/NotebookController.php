<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Schema;

use App\Notebook;
use App\User;
use App\Alumno;
use App\Curso;

use Carbon\Carbon;
use Notification;
use App\Notifications\NewNotebook;
use Mail;
use App\Mail\WelcomeParent;

use App\Mail\DailyReportEmail;
use App\Mail\DailyReport as DailyNotebookReport;

use Illuminate\Support\Facades\DB;

class NotebookController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $alumno_id = 10;
        $notebook = Notebook::whereDate('notebook_date', Carbon::today())
        ->with('activities')
        ->with('attachs')
        ->whereHas('alumno',function($q) use($alumno_id){
            $q->where('alumno_id',$alumno_id);
        })
        ->get();

        $cursos = Curso::all();
        
        return view('admin.notebooks.index',compact('notebook','cursos'));
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
       //$activity_food = array_filter(array_map('array_filter', $request->get('food'))) ? $request->get('food'):null;
        //$activity_moods = $request->has('mood') ? $request->get('mood'): null;
        /*$data = is_array($request->get('data')) ?  array_filter(array_map('array_filter', $request->get('data'))) : $request->get('data') ? $request->get('data'):null;*/

        $this->validate($request, [
                'new_recipientsSelected'    => 'required',
                'data'    => 'required',
                'fileupload'                => 'sometimes|required|array|min:1',
                'fileupload.*'              => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'

        ]);

        $data = is_array($request->get('data')) ? array_filter(array_map('array_filter', $request->get('data'))) : $request->get('data');

        $activity_data = $data ? $data:null;

        $alumnosIds = explode(',',$request->get('new_recipientsSelected'));

        $attached = null;

        if($request->hasfile('fileupload')){

            foreach($request->file('fileupload') as $image)
            {
                $name=$image->getClientOriginalName();
                
                $sub_name= md5($name.time()).'.'.$image->getClientOriginalExtension();
                $image->move(public_path().'/static/uploads/notebook/', $sub_name);
                
                $attached[] = $sub_name;  
            }
        }
        foreach ($alumnosIds as  $alumno) {
            $notebook = Notebook::create([
                'alumno_id'     => $alumno,
                'data'          => $activity_data,
                'activity_type' => $request->get('activity_type'),
                'attached'      => $attached,
                'notebook_date' => Carbon::now(),
            ]);

            $users= User::wherehas('students',function($q) use($alumno){
                $q->where('alumno_id',$alumno);
            })->get();

            $when = now()->addSeconds(2);

            foreach($users as $user){
                

                /*$user->notify(new NewNotebook($notebook, auth()->user()->id));*/
                $user->notify((new NewNotebook($notebook, auth()->user()->id))->delay($when));

                
            }
        }

        //return response()->json($apoderado,200,[],JSON_PRETTY_PRINT);
           return back()->with('status', 'Hemos Actualizado la linea de tiempo');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notebook  $notebook
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        //

        return 'show';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notebook  $notebook
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        //
        return 'edit';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notebook  $notebook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notebook $notebook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notebook  $notebook
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notebook $notebook)
    {
        //
    }

    public function filter(Request $request){
        $id_curso = $request->id ? $request->id : '';
        $notebook_type  = $request->type ? $request->type : '';
        $query = Alumno::query();
        $query = $query->when($request->get('id') != '', function ($q) use($id_curso){
            $q->whereHas('curso', function ($query) use($id_curso){
                $query->where('curso_id', $id_curso);
            });
        });
        $query = $query->when($request->get('id') != '', function ($q) use($id_curso){
            $q->whereHas('curso', function ($query) use($id_curso){
                $query->where('curso_id', $id_curso);
            });
        });
        $query = $query->whereDoesntHave('notebooks',function($q) use($notebook_type){
            $q->whereDate('created_at',Carbon::today()->toDateString())
            ->where('activity_type', $notebook_type);
        });
        $users = $query->get();

        $get_form = 'food';

        $html = view('admin.notebooks.listusers',compact('users'))->render();
        $form = view('admin.notebooks.partials.forms.'.$get_form.'_form')->render();

        return response()->json([
            'html'=>$html,
            'form'=>$form
        ]);

        $html = view('admin.notebooks.listusers')->render();
    }

    public function forms(Request $request){

        try {
            $form = view('admin.notebooks.partials.forms.'.$request->get('form').'_form')->render();

        } catch(\Exception $e){
             // do task when error
            $form = view('admin.notebooks.partials.forms.error_form')->render();
            if(request()->ajax()) {
            return response()->json([
                'status' => 'Error',
                'form'=>$form
                ],404);
            }
              return response()->json([
                'status' => 'error',
                'message'=>'Invalid Url'
            ],404);
        }
        

        if(request()->ajax()) {
            return response()->json([
                'status' => 'OK',
                'form'=>$form
            ]);
        }
        
    }

    public function images(){

        return "asdasdas";


    }

    public function report(Request $request){

        

        // get notebooks 

        $alumno = Alumno::wherehas('notebooks',function($q) {
            $q->whereNotNull('data')
            ->whereDate('created_at',Carbon::today()->toDateString());
        })
        ->get()->pluck('id');

        $childs = Alumno::whereHas('parent',function($q) use($alumno){
            $q->whereIn('alumno_id',$alumno);
        })
        ->with('parent')
        ->get();
        
        /*foreach($childs  as $child){


            
            foreach($child->parent as $parent){
                

               
             //Mail::to($parent->email)->send(new DailyNotebookReport($child,$parent));

             if( count(Mail::failures()) > 0 ) {

               echo "There was one or more failures. They were: <br />";

               foreach(Mail::failures as $parent->email) {
                   echo " - $email_address <br />";
                }

            } else {
                echo '<br />';
                echo "No errors, all sent successfully!<br />";
                echo " - $parent->email <br />";
            }
                
            }
             
            
        }*/

        // calculate new statistics
        $recipients = DB::table('users')
          ->selectRaw('users.id as parent_id,alumnos.id as alumno_id')
          ->join('profiles','profiles.user_id','=','users.id')
          ->join('alumno_parent','alumno_parent.user_id','=','users.id')
          ->join('alumnos','alumnos.id','=','alumno_parent.alumno_id')
          ->join('notebooks','notebooks.alumno_id','=','alumnos.id')
          ->whereNotNull('notebooks.data')
          ->whereDate('notebooks.created_at',Carbon::today()->toDateString())
          ->get();

        /*foreach($recipients as $recipient){
            $user = User::findorfail($recipient->parent_id);
            $child = Alumno::findorfail($recipient->alumno_id);

            Mail::to($user->email)->send(new DailyNotebookReport($child,$user));
        }*/

        $users = $recipients;

        $creator = User::find(\Auth::id())->name;

        
        return response()->json([$users],200,[],JSON_PRETTY_PRINT);
        return back()->with('status', 'Se envio la libreta diaria');
        return response()->json($childs,200,[],JSON_PRETTY_PRINT);

    }
}
