<?php

namespace App\Http\Controllers;

use App\Apoderado;
use Illuminate\Http\Request;
use App\User;
use App\Profile;
use App\Alumno;
use App\Album;
use App\Note;
use App\Curso;
use App\Notebook;
use DB;
use Carbon\Carbon;
use Faker\Generator as Faker;

use Lexx\ChatMessenger\Models\Message;
use Lexx\ChatMessenger\Models\Participant;
use Lexx\ChatMessenger\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;


class ApoderadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$user_id = 404;
        $user_id = auth()->user()->id;
        $apoderado = User::with('students','profile')->where('id',$user_id)->first();
        
       /*echo "<pre>";
       return json_encode($apoderado,JSON_PRETTY_PRINT);*/
       return view('apoderados.index',compact('apoderado'));
       
    }
    public function feed()
    {
        //
        
        $user_id = auth()->user()->id;
        $apoderado = User::with('childs','profile')->where('id',$user_id)->first();

        

        $alumno_id = 298;
        $dt = Carbon::today();

        /*$nsotebooks = Notebook::whereDate('notebook_date', $dt->subDay(2))
        ->with('activities')
        ->with('attachs')
        ->whereHas('alumno',function($q) use($alumno_id){
            $q->where('alumno_id',$alumno_id);
        })
        ->orderBy('notebook_date', 'DESC')
        ->paginate(10);*/

        $notebooks = Notebook::whereDate('notebook_date', $dt->subDay(0))
        ->with('activities')
        ->with('attachs')
        ->with('alumno')
        ->whereHas('alumno',function($q) use($alumno_id){
            $q->where('alumno_id',$alumno_id);
        })
        ->get()
        ->groupBy(function($item)
        {
          return Carbon::parse($item->notebook_date)->format('d-M-y');
        });

        $alumno_profile = Alumno::with('curso')->findOrFail($alumno_id);
        
        //dd($alumno_profile);
        
        /*echo "<pre>";
        //return json_encode($feed,JSON_PRETTY_PRINT);
        return json_encode($notebooks,JSON_PRETTY_PRINT);*/
        return view('apoderados.index',compact('notebooks','alumno_profile','apoderado'));
       
    }

    public function inbox(){
        // All threads, ignore deleted/archived participants
        $threads = Thread::getAllLatest()->get();
        // All threads that user is participating in
        $threads = Thread::forUser(Auth::id())->latest('updated_at')->paginate(10);
        // All threads that user is participating in, with new messages
        //$threads = Thread::forUserWithNewMessages(Auth::id())->latest('updated_at')->get();

        $user_list = Alumno::with('parent','curso')->whereHas('parent',function($q){
            $q->Wherenotnull('user_id');
        })->get();

        $cursos = Curso::all();
       /* echo "<pre>";
        return json_encode($threads, JSON_PRETTY_PRINT);*/
        /*echo "<pre>";
        return json_encode($threads,JSON_PRETTY_PRINT);*/
        return view('apoderados.inbox.index',compact('threads'));
    }
    public function inboxshow($id){
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');
            return redirect()->route('messages');
        }
        // show current user in list if not a current participant
        // $users = User::whereNotIn('id', $thread->participantsUserIds())->get();
        // don't show the current user in list
        $userId = Auth::id();
        $users = User::whereNotIn('id', $thread->participantsUserIds($userId))->get();
        $thread->markAsRead($userId);
        
        return view('apoderados.inbox.show', compact('thread', 'users'));
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Apoderado  $apoderado
     * @return \Illuminate\Http\Response
     */
    
    public function show(Request $request,$id,$date=NULL)
    {
        //
        

        $child = $id;
        try {
            $apoderado = User::whereHas('students',function($q) use($id){
                $q->where('alumno_id',$id);
            })
            ->whereRoleIs('parent')
            ->findOrFail(Auth::id());

        } catch(\Exception $e){
             // do task when error
              return response()->json([
                'status' => 'error',
                'message'=>$e->getMessage()
            ],404);
        }

        if(!empty($request->date)>0){
            $dt = Carbon::parse($request->date)->toDateString();

        }else {
          $dt = Carbon::today()->toDateString();  
        }

        $user_id = auth()->user()->id;
        
        $alumno_id = $id;

        $curso = Curso::whereHas('childs',function($q) use($alumno_id){
            $q->where('alumno_id',$alumno_id);
        })->first()->id;
        $curso_id = $curso;

        $albums = DB::table('albums')
        ->join('album_curso', 'album_curso.album_id', '=', 'albums.album_id')
        ->join('photos', 'photos.album_id', '=', 'albums.album_id')
        ->where('album_curso.curso_id',$curso_id)
        ->get();


        /*$notebooks= Notebook::with('attachs')
        ->with('activities')
        ->selectRaw('alumno_parent.alumno_id as alumno_id, users.id as padre_id,notebooks.id as feed_id, notebooks.*')
        ->join('alumno_notebook','alumno_notebook.notebook_id','=','notebooks.id')
        ->join('alumno_parent','alumno_parent.alumno_id','=','alumno_notebook.alumno_id')
        ->join('users','users.id','=','alumno_parent.user_id')
        ->where('alumno_parent.alumno_id',$id)
        ->where('alumno_parent.user_id',$user_id)
        ->whereDate('notebooks.created_at', '=', $dt)
        ->orderBy('notebooks.created_at', 'DESC')
        ->first();*/

        $notebooks= Notebook::join('alumno_parent','alumno_parent.alumno_id','=','notebooks.alumno_id')
        ->where('notebooks.alumno_id',$id)
        ->where('alumno_parent.user_id',$user_id)
        ->whereNotNull('notebooks.data')
        ->whereDate('notebooks.created_at', '=', $dt)
        ->orderBy('notebooks.created_at', 'DESC')
        ->get()
        ->groupBy(function($item){ 
            
            return Carbon::parse($item->created_at)->format('d-M-y');
        });
        
        
        

        //$date = Carbon::parse($dt)->toDateString();
        $next_notebook = Carbon::parse($dt)->addDays(1)->toDateString();
        $prev_notebook = Carbon::parse($dt)->subDays(1)->toDateString();

        
        $previousnotebook = Notebook::where('notebooks.alumno_id',$id)
        ->whereNotNull('notebooks.data')
        ->whereDate('created_at','<',$dt)
        ->orderBy('created_at','DESC')
        ->pluck('created_at')->first();


        $nextnotebook =  Notebook::where('notebooks.alumno_id',$id)
        ->whereNotNull('notebooks.data')
        ->whereDate('created_at','>',$dt)
        ->orderBy('created_at','ASC')
        ->pluck('created_at')->first();

        $date_link_prev = Carbon::parse($previousnotebook)->format('Y-m-d');
        $navlink_feed = [];
        $navlink_feed['prev_text'] = Carbon::parse($previousnotebook)->format('l j');
        $navlink_feed['prev_url'] = route('child.feed',['id'=>$alumno_id,'date'=>$date_link_prev]);

        $date_link_next = Carbon::parse($nextnotebook)->format('Y-m-d');
        $nextnotebook_link = [];
        $navlink_feed['next_text'] = Carbon::parse($nextnotebook)->format('l j');
        $navlink_feed['next_url'] = route('child.feed',['id'=>$alumno_id,'date'=>$date_link_next]);

        

        $notebook_select = Notebook::select('notebook_date')
        ->whereHas('alumno',function($q) use($alumno_id){
            $q->where('alumno_id',$alumno_id);
        })->get()
        ->groupBy(function($item)
        {
          return Carbon::parse($item->notebook_date)->format('y-m-d');
        });

        $alumno_profile = Alumno::with('curso')->findOrFail($alumno_id);

        
        if($request->has('nid')){
            $notification = Auth::user()->notifications()->findOrFail($request->nid)->markAsRead();
        }
        
        //dd($alumno_profile);
        /*echo "<pre>";
        return json_encode([$previousnotebook,$nextnotebook],JSON_PRETTY_PRINT);
       echo "<pre>";
        return json_encode($previousnotebook,JSON_PRETTY_PRINT);*/
        /*return json_encode($previousnotebook,JSON_PRETTY_PRINT);*/
        return view('apoderados.show',compact('nextnotebook','previousnotebook','albums','notebooks','alumno_profile','notebook_select','notebook_date'));
    }
    public function albums(){

        $apoderado = User::with('alumno_parent','profile')->where('id',auth()->user()->id)->first();
        $is_user = auth()->user()->id;
        $cursos = Alumno::with('parent','curso')->whereHas('parent',function($q) use($is_user){
            $q->where('user_id',$is_user);
        })->first();

        //$curso_id = $curso->curso;
        if(!empty($cursos)){
        foreach($cursos->curso as $curso ){
                    $id[] =$curso->id;
                }

        }else {
            $id[] = 0;
        }
        
        $albums = Album::with('photo')->whereHas('curso',function($q) use($id){
            $q->whereIn('curso_id',$id);
        })->get();
        /*$alumno_id = $id;

        $curso = Curso::whereHas('childs',function($q) use($alumno_id){
            $q->where('alumno_id',$alumno_id);
        })->first()->id;
        $curso_id = $curso;

        $albums = DB::table('albums')
        ->join('album_curso', 'album_curso.album_id', '=', 'albums.album_id')
        ->join('photos', 'photos.album_id', '=', 'albums.album_id')
        ->where('album_curso.curso_id',$curso_id)
        ->get();*/
        /*echo "<pre>";
        return json_encode($albums,JSON_PRETTY_PRINT);*/
        return view('apoderados.albums.index',compact('albums'));

    }
    public function album($id){

        $albums = Album::with('photo')->findOrFail($id);

        return view('apoderados.albums.show',compact('albums'));

    }
    public function profile(){
        $id = auth()->user()->id;

        $userprofile = User::with('profile')->findOrFail($id);
        return view('apoderados.profile.index',compact('userprofile'));

    }
    public function updateProfile(Request $request,$id){
        $this->validate($request, array(
            'firstname' => 'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|max:255',
            'birthday' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
        ));
        $user = User::findOrFail($id);
        $user->name = $request->firstname;
        $user->email = $request->email;

        $user->save();

        $customer = Profile::where('user_id',$user->id)->first();
        $customer->first_name = $request->firstname;
        $customer->last_name = $request->lastname;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->telephone = $request->phone;
        $customer->birthday = $request->birthday;
        $user->profile()->save($customer);


        return redirect()->route('apoderado.profile',$user->id)->with('info','Perfil Actualizado con exito');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Apoderado  $apoderado
     * @return \Illuminate\Http\Response
     */
    public function edit(Apoderado $apoderado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Apoderado  $apoderado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apoderado $apoderado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Apoderado  $apoderado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apoderado $apoderado)
    {
        //
    }
    public function child()
    {
        //
        $apoderadoID = 435;
        $apoderado = User::where('id',435)->whereRoleIs('parent')->first();
        $childs = User::with('alumno_parent')->findOrFail($apoderado->id);


        $notes = DB::table('notes');
        
       echo "<pre>";
       return json_encode($childs,JSON_PRETTY_PRINT);
        return view('apoderados.childs',compact('childs'));
    }
    public function showChild($id){

        $child = Alumno::where('id',$id)->first();
        echo "<pre>";
        return json_encode($child,JSON_PRETTY_PRINT);

    }

    public function notes(Request $request){
        $parentID = auth()->user()->id;
        $parent = User::findOrFail($parentID);
        $parentID = $parent->id;

        /*$notes = DB::table('notes')
        ->join('alumno_curso', 'alumno_curso.curso_id', '=', 'notes.curso_id')
        ->join('alumno_parent', 'alumno_parent.alumno_id', '=', 'alumno_curso.alumno_id')
        ->join('profiles', 'notes.user_id', '=', 'profiles.user_id')
        ->select('notes.*','profiles.image as sender_image','profiles.user_id as parent_id','profiles.first_name as sender_name','profiles.last_name as sender_lastname')
        ->where('alumno_parent.user_id',$parentID)
        ->orderBy('notes.sticky', 'DESC')
        ->orderBy('notes.created_at', 'DESC')
        ->paginate(5);*/
        $notes = Note::SelectRaw('notes.*,note_user.readed')
        ->join('note_user','note_user.note_id','=','notes.id')
        ->where('note_user.user_id',auth()->user()->id)
        ->orderBy('notes.sticky', 'DESC')
        ->orderBy('notes.created_at', 'DESC')
        ->paginate(50);

       return view('apoderados.notes.index',compact('notes','parent'));
        //$notes = Note::with('user')->get();
        echo "<pre>";
        return json_encode($notes,JSON_PRETTY_PRINT);

    }
    public function noteshow(Request $request, $id){

        $notes = Note::with('user')->where('id',$id)->where('user_id',auth()->user()->id)->get();
        $notes = Note::SelectRaw('notes.*')
        ->join('note_user','note_user.note_id','=','notes.id')
        ->where('note_user.user_id',auth()->user()->id)
        ->where('notes.id',$id)
        ->get();

        if($notes->isEmpty()){
            return response()->json([
            'message' => 'Invalid Request',
            'status' => 403
        ], 403);
        }
        /*return response()->json([
            'message' => 'Wrong email or password',
            'status' => 422
        ], 422);*/
        $parent = User::where('id',auth()->user()->id)->first();

        //auth()->user()->unreadNotifications->markAsRead();

        $notification = auth()->user()->notifications()->where('id',$request->get('nid'))->first();
        /*dd($notes);*/
        if($notification){
            $notification->markAsRead();
        }

        $update = Note::find($id)->note_user()->wherePivot('user_id', '=', auth()->user()->id)->whereNull('readed_at')
        ->update([
            'readed_at' => Carbon::now(),
            'readed' => '1'
        ]);
        

        return view('apoderados.notes.show',compact('notes','parent'));

    }
}
