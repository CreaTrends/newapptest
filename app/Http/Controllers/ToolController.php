<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;
use File;
use Excel;
use Response;
use Carbon\Carbon;
use App\Note;
use App\Curso;
use App\Alumno;
use App\User;
use App\Profile;

use Notification;
use App\Notifications\NewNotebook;
use Mail;
use App\Mail\WelcomeParent;

class ToolController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function test(){

        echo "test de tool controller";

    }
    public function index(){

        echo "index del controlador import";

    }
    public function importExcel(Request $request){
        //validate the xls file
        $this->validate($request, array(
            'file'      => 'required'
        ));

        if($request->hasFile('file')){
            $extension = File::extension($request->file->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
 
                $path = $request->file->getRealPath();

                $data = Excel::load($path, function($reader) {

                    $reader->ignoreEmpty();
                    
                })->get();

                if(!empty($data) && $data->count()){
 
                    foreach ($data as $key => $value) {
                        if($value->a_nombre != ''){

                            if($request->has('curso_id')){
                                $curso_id = $request->curso_id;
                            }else {
                                $curso_id = Curso::where('name',explode(',',$value->a_nivel))->first()->id;
                            }
                           
                           

                           
                           $mName = !empty($value->m_nombre) ? explode(' ',$value->m_nombre) : '';
                           $pName = !empty($value->p_nombre) ? explode(' ',$value->p_nombre) : '';
                           
                            $insert[] = [
                                'firstname'         =>  $value->a_nombre.' '.$value->a_snombre,
                                'lastname'          =>  $value->a_paterno.' '.$value->a_materno,
                                'birthday'          =>  Carbon::parse($value->a_nacimiento)->format('Y-m-d'),
                                'curso_id'          =>  $curso_id,
                                'curso_name'        =>  $value->a_nivel,
                                "mother_role"       =>  4,
                                "mother_firstname"  =>  count($mName) > 1 ? $mName[0]:'',
                                "mother_lastname"   =>  count($mName) > 1 ? $mName[1]:'',
                                "mother_email"      =>  $value->m_email,
                                "mother_phone"      =>  $value->m_celular,
                                "mother_bday"       =>  Carbon::parse($value->m_nacimiento)->format('Y-m-d'),
                                "mother_gender"     =>  'Female',
                                "mother_image"      =>  'default.jpg',
                                "parent_role"       =>  4,
                                "parent_firstname"  =>  count($pName) > 1 ? $pName[0]:'',
                                "parent_lastname"   =>  count($pName) > 1 ? $pName[1]:'',
                                "parent_email"      =>  $value->p_email,
                                "parent_phone"      =>  $value->p_celular,
                                "parent_bday"       =>  Carbon::parse($value->p_nacimiento)->format('Y-m-d'),
                                "parent_gender"     =>  'Male',
                                "parent_image"      =>  'default.jpg'
                            ];
                            
                            if(!empty($insert)){

                                // insertamos alumno
                                $alumno = new Alumno();
                                $alumno->firstname = $value->a_nombre.' '.$value->a_snombre; //add a default value here
                                $alumno->lastname = $value->a_paterno.' '.$value->a_materno; //add a default value here
                                $alumno->save();
                                $alumno->curso()->attach($curso_id);

                               // insertamos apoderado 1
                                if(count($pName) > 1){
                                    $password = $this->make_password();
                                    $role = 4;
                                    $user = User::create([
                                        'name' => $value->p_nombre,
                                        'email' => $value->p_email,
                                        'api_token' => bin2hex(openssl_random_pseudo_bytes(30)),
                                        'password' => bcrypt($password)
                                    ]);
                                    $user->attachRole($role);
                                    $user->students()->attach($alumno->id);
                                    // asignamos un profile
                                    $profile = new Profile();
                                    $profile->first_name = count($pName) > 1 ? $pName[0]:'';
                                    $profile->last_name = count($pName) > 1 ? $pName[1]:'';
                                    $profile->email = $value->p_email;
                                    $profile->address = '';
                                    $profile->telephone = $value->m_celular;
                                    $profile->birthday = Carbon::parse($value->p_nacimiento)->format('Y-m-d');
                                    $profile->gender = 'Male';
                                    $profile->image = 'default.jpg';
                                    $user->profile()->save($profile);
                                    if($value->p_email){
                                        $user->email = $value->p_email;
                                        $user->password = $password;
                                        $user->name=$value->p_nombre;
                                        Mail::to($user->email)->send(new WelcomeParent($user));
                                    }

                                    
                                }
                                // insertamos apoderado2
                                if(count($mName) > 1){
                                    $password = $this->make_password();
                                    $role = 4;
                                    $user = User::create([
                                        'name' => $value->m_nombre,
                                        'email' => $value->m_email,
                                        'api_token' => bin2hex(openssl_random_pseudo_bytes(30)),
                                        'password' => bcrypt($password)
                                    ]);
                                    $user->attachRole($role);
                                    $user->students()->attach($alumno->id);

                                    // asignamos un profile
                                    $profile = new Profile();
                                    $profile->first_name = count($mName) > 1 ? $mName[0]:'';
                                    $profile->last_name = count($mName) > 1 ? $mName[1]:'';
                                    $profile->email = $value->m_email;
                                    $profile->address = '';
                                    $profile->telephone = $value->m_celular;
                                    $profile->birthday = Carbon::parse($value->p_nacimiento)->format('Y-m-d');
                                    $profile->gender = 'Female';
                                    $profile->image = 'default.jpg';
                                    $user->profile()->save($profile);
                                    if($value->m_email){
                                        $user->email = $value->m_email;
                                        $user->password = $password;
                                        $user->name=$value->m_nombre;
                                        Mail::to($user->email)->send(new WelcomeParent($user));
                                    }

                                    
                                }

                                
                                

                                
                            }
                            /*$alumno = new Alumno();
                            $alumno->firstname = $value->a_nombre.' '.$value->a_snombre; //add a default value here
                            $alumno->lastname = $value->a_paterno.' '.$value->a_materno; //add a default value here
                            $alumno->save();*/
                            //$alumno->curso()->attach($curso_id);
                        }
                    }


                    
 
                    /*if(!empty($insert)){
 
                        $insertData = DB::table('students')->insert($insert);
                        if ($insertData) {
                            Session::flash('success', 'Your Data has successfully imported');
                        }else {                        
                            Session::flash('error', 'Error inserting the data..');
                            return back();
                        }
                    }*/
                    // test code
                    //insert using foreach loop
                    /*  foreach($leads as $key => $input) {
                        $scores = new Score();
                        $scores->Subject_id = isset($leads[$key]) ? $leads[$key] : ''; //add a default value here
                        $scores->Lead_id = isset($subject_ids[$key]) ? $subject_ids[$key] : ''; //add a default value here
                        $scores->save();
                      }


                      //insert using array at once
                      $rows = [];
                      foreach($leads as $key => $input) {
                        array_push($rows, [
                          'Subject_id' => isset($leads[$key]) ? $leads[$key] : '', //add a default value here
                          'Lead_id' => isset($subject_ids[$key]) ? $subject_ids[$key] : '' //add a default value here
                        ]);
                      }
                      Score::insert($rows);*/
                }
 
                return $insert;
 
            }else {
                /*Session::flash('error', 'File is a '.$extension.' file.!! Please upload a valid xls/csv file..!!');
                return back();*/
            }
        }
        
        //validate the xls file
        
 

    }
    private function make_password(){
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
    public function exportExcel($id){

        //validate the xls file
        $curso = Curso::with('alumnos_list')->where('id',$id)->first();
        /*Excel::create('users', function($excel) use($curso) {
            $excel->sheet('Sheet 1', function($sheet) use($curso) {
                $sheet->fromArray($curso);
            });
        })->export('xls');*/
        $alumnos = Alumno::with('curso','parent')->whereHas('curso', function($q) use($id){
                $q->where('curso_id', $id);
            })->get();

        $alumnoArray = [];
        $alumnoArray[] = ['firstname', 'lastname'];
        foreach ($alumnos as $alumno) {
            $alumnoArray[] = $alumno->toArray();
            foreach($alumno->parent as $parent){
             $alumnoArray[] = $parent->toArray();   
            }
        }
        
        /*$alumnos=$cursos->alumnos_list;*/

        
        Excel::create('Alunos de '.$curso->name, function($excel) use ($alumnos,$curso) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Alumno '.$curso->name);
            $excel->setCreator('Laravel')->setCompany('WJ Gilmore, LLC');
            $excel->setDescription('payments file');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($alumnos) {
                $sheet->row(1, [
    'Número', 'Nombre', 'Apellido', 'Fecha de Creación', 'Fecha de Actualización'
]);
                foreach($alumnos as $index => $user) {
    $sheet->row($index+2, [
        $user->id, $user->firstname, $user->lastname, $user->created_at, $user->updated_at
    ]); 
}
                
            });

        })->download('xlsx');
        echo "<pre>";

        return json_encode($alumnoArray,JSON_PRETTY_PRINT);
 

    }
    public function DownloadAttach(Request $request,$id){

        //validate the xls file
        $file = Note::findOrFail($id);
        $file_attach = $file->attached;

        
        return response()->download(public_path('storage/' . $file_attach));
 

    }
}
