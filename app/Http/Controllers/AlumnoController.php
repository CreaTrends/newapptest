<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laratrust\LaratrustFacade as Laratrust;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
use App\Alumno;
use App\Curso;
use Image;
use Illuminate\Support\Str;
use App\Profile;
use DB;
class AlumnoController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:parent|teacher|administrator|superadministrator');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user = \Auth::user();
        $name=$user->name;
        $roles = $user->roles()->get();
        $user_id = $user->id;

        $perPage = $request->has('limit') ? $request->get('limit') : 10;

        // obtenemos el curso
        $curso = Curso::wherehas('teacher',function($q)use($user_id){
                $q->where('user_id',$user_id);
            })->get()->pluck('id')->toArray();

        

        $query = Alumno::query();
        //getting user role 
        $query->when($user->hasRole('teacher'), function ($q) use($curso){ 
            return $q->whereHas('curso',function($a) use($curso){
                $a->whereIn('curso_id',$curso);
            });
        });
        // estados

        $query->when($request->get('status') != null, function ($q) use($request){ 
            return $q->where('status',$request->get('status'));
        });
        // curso
        $query->when($request->get('curso') > 0, function ($q) use($request){ 
            return $q->whereHas('curso',function($a) use($request){
                $a->where('curso_id',$request->curso);
            });
        });
        $alumnos = $query->paginate($perPage);


        $cursos = Curso::all();

        //Declare new queries you want to append to string:
        $newQueries = [
            'status'=> $request->get('status'),
            'curso'=> $request->get('curso')
        ];

        $the_url = route('alumnos.index',array_filter($newQueries));

        $data['limits'] = array();
        
        $limits = array_unique(array(10, 25, 50, 75, 100));
        
        sort($limits);
        foreach($limits as $value) {
                $filters['limits'][] = array(
                    'text'  => $value,
                    'value' => $value,
                    'href'  => array_filter($newQueries) ? url($the_url.'&limit='.$value) : url($the_url.'?limit='.$value)
                );
        }

        $newQueries = [
            'status'=> $request->get('status'),
            'limit'=> $request->get('limit'),
        ];

        $the_url = route('alumnos.index',array_filter($newQueries));

        $filters['cursos'][] = array(
                    'text'  => '----Filtra por curso-----',
                    'value' => '0',
                    'href'  => array_filter($newQueries) ? url($the_url.'&curso=') : url($the_url.'?curso=')

                );
        foreach($cursos as $value) {
                $filters['cursos'][] = array(
                    'text'  => $value->name,
                    'value' => $value->id,
                    'href'  => array_filter($newQueries) ? url($the_url.'&curso='.$value->id) : url($the_url.'?curso='.$value->id)

                );
        }
        

        $newQueries = [
            'curso'=> $request->get('curso'),
            'limit'=> $request->get('limit'),
        ];

        $the_url = route('alumnos.index',array_filter($newQueries));

        $status = array_unique(array(
            'default'=>null,
            'activo'=>'1',
            'inactivo'=>'0'
        ));

        foreach($status as $value=>$key) {
                $filters['status'][] = array(
                    'text'  => $key == null ? 'Estado':$value ,
                    'value' => $key,
                    'href'  => array_filter($newQueries) ? url($the_url.'&status='.$key) : url($the_url.'?status='.$key)

                );
        }

        
       return view('admin.students.index',compact('alumnos','cursos','perPage','filters'));

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
        $validatedData = $request->validate([
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
        ]);

        $alumno = Alumno::create($request->all());

        $alumno->curso()->attach($request->get('courses'));
        $alumno->parent()->attach($request->get('parents'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $alumnos = Alumno::findOrFail($id);
        echo "<pre>";
        return json_encode($alumnos,JSON_PRETTY_PRINT);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $alumnos = Alumno::with('curso','teacher','parent')->find($id);
        
        foreach($alumnos->curso as $curso){
            $cursos[] = $curso->name ;
        }
        $curso = implode(',',$cursos);
        $medications[] = explode(',',$alumnos->medications);        
        /*echo "<pre>";
        return json_encode($curso,JSON_PRETTY_PRINT);*/
        return view('admin.students.edit')->with(compact('alumnos','medications','curso'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $alumno = Alumno::findOrFail($id);
        $alumno->firstname = $request->firstname;
        $alumno->lastname = $request->lastname;
        $alumno->address = $request->address;
        $alumno->city = $request->city;
        
        $alumno->save();


        if($request->file('fileupload')){
            $avatar = $request->file('fileupload');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();

            Image::make($avatar)->fit(300, 300)->save( public_path('/static/image/profile/' . $filename ) );


            $alumno->fill(['image' => $filename])->save();
        }
        return redirect()->route('alumnos.edit', $alumno->id);
    }
    public function updateinfo(Request $request, $id)
    {
        if($request->get('medication') != ''){
            $medications = implode(',',$request->get('medication'));
        }else{
            $medications = 'Sin Datos';
        }
        if($request->get('allergies') != ''){
            $allergies = implode(',',$request->get('allergies'));
        }else{
            $allergies = 'Sin Datos';
        }
        $alumno = Alumno::findOrFail($id);
        $alumno->medications = $medications;
        $alumno->allergies = $allergies;
        $alumno->birthday = date("Y-m-d", strtotime($request->birthday));
        $alumno->status = $request->status == 'activo' ? '1':'0';
        $alumno->gender = $request->gender;
        $alumno->save();
        //return implode(',',$request->get('medication'));
        return redirect()->route('alumnos.edit', $alumno->id);
    }
    public function updateCurso(Request $request, $id){

        $alumno = Alumno::findOrFail($id);
        $alumno->curso()->sync($request->get('courses'));
        $alumno->save();



        return redirect()->route('alumnos.edit', $alumno->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $taks = Alumno::findOrFail($id);
        $taks->delete();
        return redirect()->back()->with('deleteInfo','El Alumno Ha sido eliminado');
    }

    public function deleteall(Request $request){

        $alumnoIds = explode(',',$request->id);
        $userIds = is_array($alumnoIds) ? $alumnoIds : (array) func_get_args();

        $user = \Auth::user();
        $alumnos = Alumno::whereIn('id',$alumnoIds)->get();

        /*foreach($notes as $note){
            $note->delete();
        }*/

        
        if(request()->ajax()) {
        return response()->json([
                'status' => 'OK',
                'ids' => $alumnos->pluck('id'),
                'title'=>$alumnoIds
            ],200);
        }

        

        return response()->json(['error' => $alumnos],200);

    }

    public function inviteParent(Request $request, $id){

        $password = $this->generated_password();
        
        
        $request->name = $request->parent_name;
        $request->email = $request->parent_email;
        $request->password = bcrypt($password);
        $request->role = 4;
        $request->api_token = bin2hex(openssl_random_pseudo_bytes(30));
        

        $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'api_token' => bin2hex(openssl_random_pseudo_bytes(30)),
                'password' => bcrypt($password)
            ]);
        $user->attachRole($request->role);

        $user->students()->attach($id);

        $customer = new Profile();
        $customer->first_name = $request->parent_name;
        $customer->last_name = $request->parent_lastname;
        $customer->email = $request->parent_email;
        $user->profile()->save($customer);


        $data = array(
            "name"=>$request->name.' '.$request->last,
            "email"=>$request->name.' '.$request->email,
            "url"=>route('login'),
            "password"=>$password
        );

        Mail::send('email.test', $data, function ($message) {
            $message->from('jalabornozdesign@gmail.com', 'Test Mail');
             
            $message->to("receiver@example.com")->subject('Bienvenido a Jardin Anatolia');
        });

        # set the manual password
        return $user->id;
    }
    public function inviteProcess(){

    }
    private function generated_password(){
        # set the manual password
        $length = 10;
        $keyspace = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        $password = $str;
        return $password;
    }
    protected function hash_split($hash)
    {
        $output = str_split($hash,8);
        return $output[rand(0,1)];
    }
}
