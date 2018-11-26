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
        }
        /*$notebook = Notebook::create([
            'foods'         =>$activity_food,
            'moods'         =>$activity_moods,
            'notebook_date' => Carbon::now(),

        ]);*/

        //$notebook->alumno()->attach($request->recipients);

        return response()->json([
                're'=>$activity_data,
                'notebook_id'=>$request->all(),
            ],200,[],JSON_PRETTY_PRINT);
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
}
