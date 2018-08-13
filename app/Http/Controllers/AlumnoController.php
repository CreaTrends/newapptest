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
    public function index()
    {
        //
        //$user = Auth::user();
        
        
       /* $user = Curso::with('teacher','alumnos')->whereHas('teacher', function($q) {
                $q->where('user_id','=', 3);
            })->get();*/
        /*$alumnos = Alumno::select('*')
        ->join('cursos', 'cursos.id', '=', 'alumnos.curso_id')
        ->join('curso_user', 'curso_user.curso_id', '=', 'cursos.id')
        ->join('users', 'users.id', '=', 'curso_user.user_id')
        ->where('users.id', 3)
        ->get();*/

        $user = \Auth::user();
        $name=$user->name;
        $roles = $user->roles()->get();
        $user_id = $user->id;

        if($user->hasRole(['admin','superadministrator'])){
        
        $alumnos = Alumno::with('teacher')->paginate(5);
        }else {
            $alumnos = User::with('teacher_course')->get();
            
        }
        /*$users = Curso::
            whereHas('teacher', function($q) {
                $q->where('user_id','=', 3);
            })->
            whereHas('alumnos', function($q) {
                $q->where('user_id','=', 3);
            })
            ->get();*/
        //$user->hasRole('owner')
        /*$books = Curso::whereHas('author', function ($q) use ($authorId) {
            $q->where('id', $authorId);
        })->get();*/

        /*echo "<pre>";
        //$roles = $user->roles; // Get all user roles.
        return json_encode($alumnos,JSON_PRETTY_PRINT);*/
       
       return view('admin.students.index',compact('alumnos'));

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
