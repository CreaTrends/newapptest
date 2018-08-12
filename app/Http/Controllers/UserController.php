<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Profile;
use App\Role;


use Notification;
use App\Notifications\NewNotebook;
use Mail;
use App\Mail\WelcomeParent;


class UserController extends Controller
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
    public function index(Request $request)
    {
        //
        
        //$users = User::orderBy('id', 'desc')->with('profile')->with('roles')->get();
        $id = 1;

        $user_id = auth()->user()->id;
        $roles = Role::all();
        if (request()->has('filter_status')) {
            $status_filter =$request->filter_status;
            $users = User::
            whereHas('profile', function($q) use($status_filter) {
                $q->where('status','=',$status_filter);
            })
            ->with('roles')
            ->with('profile')
            ->get();
        }elseif(request()->has('filter_role')){
            $users = User::whereRoleIs($request->filter_role)
            ->with('roles')
            ->with('profile')
            ->get();
        }
        else{
            $users = User::orderBy('id', 'ASC')
            ->with('roles')
            ->with('profile')
            ->get();
        }
        //echo $user_id;
        //echo "<pre>";
        //return json_encode($users,JSON_PRETTY_PRINT);
        //return $users;
        //return dd($users);
        //return $request->yy;
        $data['menu'] = array(
            "Feed"
        );
        $data['action'] = array(

        );
        return view('admin.users.index',compact('users','roles','dataMenu'));
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
        $this->validate($request, array(
            'firstname'      => 'required',
            'lastname'      => 'required',
            'email' => 'required|email|unique:users,email',
        ));
        $password = $this->make_password();
        $request->api_token = bin2hex(openssl_random_pseudo_bytes(30));
        $request->password = bcrypt($password);
        $user = User::create([
            'name' => $request->firstname,
            'email' => $request->email,
            'api_token' => bin2hex(openssl_random_pseudo_bytes(30)),
            'password' => bcrypt($password)
        ]);
        $user->attachRole($request->role);


        $customer = new Profile();
        $customer->first_name = $request->firstname;
        $customer->last_name = $request->lastname;
        $customer->email = $request->email;
        $user->profile()->save($customer);

        $user->password = $password;
        
        Mail::to($user->email)->send(new WelcomeParent($user));
        //$user->profile()->save($request->name);
        //$user->profile()->save($request->name);
        //Profile::create($request->all());

        //$user = User::create($request->all());
        /*if ($request->data['rolesSelected']) {

        }*/
        //$sss = bcrypt('password');
        //$user->profile()->attach($request->get('tags'));
        return redirect()->back()->with('info', 'Usuario Agregado con exito ');
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
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        //$user = User::where('id', $id)->with('profile')->with('roles')->get();
        return User::with('profile')->with('roles')->findOrFail($id);
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
        $user = User::find($id)->delete();
        return redirect()->back()->with('info', 'Eliminado correctamente');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getall()
    {
        //
        //$user_id = auth()->user()->id;
        //$user = User::where('id', 2)->with('profile')->with('roles')->get();
        $users = User::orderBy('id', 'ASC')
            ->with('roles')
            ->with('profile')
            ->get();
        //echo $user_id;
        return $users;
    }

    public function testmessage(){

        $sender = User::whereName('Superadministrator')->first();
        $recipient = User::whereName('Parent')->first();

        Messenger::from($sender)->to($recipient)->message('Hey!')->send();
        
        return "hola";
    }
    /**
     * List all messages.
     *
     * @param  \Gerardjbaez\Messenger\Models\MessageThread $thread
     * @return Response
     */
    public function all()
    {
        // This will load all messages with sender
        return "hola";
    }
}
