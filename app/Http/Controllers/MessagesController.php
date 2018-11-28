<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Curso;
use Carbon\Carbon;
use App\Alumno;
use Lexx\ChatMessenger\Models\Message;
use Lexx\ChatMessenger\Models\Participant;
use Lexx\ChatMessenger\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Notifications\NewMessageThread;

class MessagesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
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

        //
        auth()->user()->notifications()->delete();

        return view('admin.message.index', compact('threads','user_list','cursos'));
        /*echo "<pre>";
        return json_encode($threads,JSON_PRETTY_PRINT);*/
    }
     public function show($id)
    {
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

        
        return view('admin.message.show', compact('thread', 'users'));
    }


    public function create()
    {
        $userId=Auth::id();
        $cursos = Curso::with('parent_list')->where('id',15)->get();
        $users = User::where('id', '!=', Auth::id())->whereRoleIs('parent')->get();

        $cursosa = Curso::with('alumnos_list','teacher')->whereHas('teacher', function($q) use($userId){
                $q->where('user_id', $userId);
            })->get();
        
        /*echo "<pre>";
        return json_encode($cursosa,JSON_PRETTY_PRINT);*/
        return view('admin.message.create', compact('users','cursos'));
    }
    public function store()
    {



        $input = Input::all();

        $message_to = Input::has('recipients') ? User::whereHas('students',function($q) use($input){
            $q->whereIn('alumno_id',$input['recipients']);
        })->pluck('id')->toArray() : null;

        $thread = Thread::create([
            'subject' => $input['subject'],
        ]);
        // Message
        $message = Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => $input['message'],
        ]);
        // Sender
        Participant::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'last_read' => new Carbon,
        ]);
        // Recipients
        if (count($message_to) > 0) {
            // add code logic here to check if a thread has max participants set
            // utilize either $thread->getMaxParticipants()  or $thread->hasMaxParticipants()
            $thread->addParticipant($message_to);
        }
        if (!empty($input['teacher_recipients'])) {
            // add code logic here to check if a thread has max participants set
            // utilize either $thread->getMaxParticipants()  or $thread->hasMaxParticipants()
            $thread->addParticipant(explode(',',$input['teacher_recipients']));
        }
        // check if pusher is allowed
        if(config('chatmessenger.use_pusher')) {
            $this->oooPushIt($message);
        }

        $html_parent = view('admin.message.html-message', compact('message'))->render();
        if(request()->ajax()) {
            return response()->json([
                'status' => 'OK',
                'message' => $message,
                'thread' => $thread,
                'html' => $html_parent,
            ]);
        }


        if(auth()->user()->hasRole('parent')){
            return redirect()->back()->with('info','Mensaje enviado con éxito');
        }
        elseif(auth()->user()->hasRole('teacher|administrator|superadministrator')){
            return redirect()->back()->with('info','Mensaje enviado con éxito');
        }else {
            return redirect()->route('login');
        }
        
    }
    public function update($id)
    {
        

        /*$rr = explode(',',Input::get('new_recipientsSelected'));
        $user_list = User::whereHas('students',function($q) use($rr){
            $q->whereIn('alumno_id',$rr);
        })->get()->pluck('id');

        return $user_list;*/


        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');
            return redirect()->route('messages');
        }
        //$thread->activateAllParticipants();
        // Message
        $message = Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => Input::get('message'),
        ]);
        // Add replier as a participant
        $participant = Participant::firstOrCreate([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
        ]);
        $participant->last_read = new Carbon;
        $participant->save();
        // Recipients
        if (Input::has('recipients')) {
            // add code logic here to check if a thread has max participants set
            // utilize either $thread->getMaxParticipants()  or $thread->hasMaxParticipants()
            //$thread->removeParticipant(Input::get('recipients')) ;
            $thread->addParticipant(Input::get('recipients'));
        }
        $html_parent = view('admin.message.html-message', compact('message'))->render();
        $html_admin = view('admin.message.single-message', compact('message'))->render();
        // check if pusher is allowed
        if(config('chatmessenger.use_pusher')) {
            $this->oooPushIt($message);
        }
        if(request()->ajax()) {
            return response()->json([
                'status' => 'OK',
                'message' => $message,
                'html' => $html_parent,
                'admin'=>$html_admin,
                'thread_subject' => $message->thread->subject,
            ]);
        }

        //auth()->user()->notify(new NewMessageThread($thread));
        return redirect()->back();
    }

    public function filterUser(Request $request)
    {

        $id = $request->id;
        if($request->id > 0){
            $users = Alumno::with('parent','curso')->whereHas('curso', function($q) use($id) {
            $q->where('curso_id','=', $id);
        })->whereHas('parent',function($q){
            $q->Wherenotnull('user_id');
        })->get();
        }else {
            $users = Alumno::with('parent','curso')->whereHas('parent',function($q){
            $q->Wherenotnull('user_id');
        })->get();
        }
        

        $html = view('admin.message.listusers-ajax', compact('users'))->render();

        
        return response()->json([$html]);
    }

     public function modalshow($id)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');
            return redirect()->route('messages');
        }
        // show current user in list if not a current participant
        //$users = User::whereNotIn('id', $thread->participantsUserIds())->get();
        // don't show the current user in list
        $userId = Auth::id();
        $users = User::whereNotIn('id', $thread->participantsUserIds($userId))->get();
        $thread->markAsRead($userId);
        

        $participants = User::with('profile')->selectRaw('users.id,users.name,participants.deleted_at as borrado')
        ->join('participants','participants.user_id','=','users.id')
        
        ->whereNull('participants.deleted_at')
        ->where('participants.thread_id',$id)
        ->groupBy('users.name')->get();
         //$participants = User::whereNotIn('id', $thread->participantsUserIds($userId))->get();

        

        $html = view('admin.message.showmodal', compact('thread', 'users','participants'))->render();
        if(request()->ajax()) {
            return response()->json([
            'message' => $thread->subject,
                'html' => $html,
        ]);
        };
        return response()->json([
            $participants
        ],200,[],JSON_PRETTY_PRINT);

        /*$columns =  User::whereNotIn('id', $thread->participantsUserIds($userId))->get();

        
*/
        
        
        
    }
    public function addparticipant(Request $request,$id){


    }
    public function removeparticipant(Request $request,$id){


        try {
            $thread = Thread::findOrFail($request->thread_id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $request->thread_id . ' was not found.');
            return response()->json(['error'=>'The thread with ID: ' . $request->thread_id . ' was not found.'],404);
        }
        //$thread->activateAllParticipants();

        

        if(Input::has('user_id') && Input::get('user_id') == Auth::id()){
            /*$thread->removeParticipant(Input::has('user_id')) ;*/
            $thread->removeParticipant(Input::get('user_id')) ;
            //$thread->addParticipant(Input::get('user_id'));
            return response()->json([
            'message' =>Input::has('user_id'),
        ],200);
            
        }
        



        return response()->json(['error'=>'not authorize'],403);

        /*if (Input::has('recipients')) {
            // add code logic here to check if a thread has max participants set
            // utilize either $thread->getMaxParticipants()  or $thread->hasMaxParticipants()
            
            $thread->removeParticipant(Input::get('recipients'));
        }*/

    }

    public function delete(Request $request,$id){

        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $request->thread_id . ' was not found.');
            return response()->json(['error'=>'The thread with ID: ' . $request->thread_id . ' was not found.'],404);
        }

       

        return response()->json([
                'status' => 'OK',
                'message' => $thread,
                'html' => $thread->messages(),
                'thread_subject' => $thread->messages(),
            ]);


        return $thread->messages();

    }
}
