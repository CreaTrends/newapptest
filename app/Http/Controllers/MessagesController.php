<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Curso;
use Carbon\Carbon;
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
        $threads = Thread::forUser(Auth::id())->latest('updated_at')->paginate(5);
        // All threads that user is participating in, with new messages
        //$threads = Thread::forUserWithNewMessages(Auth::id())->latest('updated_at')->get();

        return view('admin.message.index', compact('threads'));
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
        if (Input::has('recipients')) {
            // add code logic here to check if a thread has max participants set
            // utilize either $thread->getMaxParticipants()  or $thread->hasMaxParticipants()
            $thread->addParticipant($input['recipients']);
        }
        // check if pusher is allowed
        if(config('chatmessenger.use_pusher')) {
            $this->oooPushIt($message);
        }
        if(request()->ajax()) {
            return response()->json([
                'status' => 'OK',
                'message' => $message,
                'thread' => $thread,
            ]);
        }

        auth()->user()->notify(new NewMessageThread($thread));

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
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');
            return redirect()->route('messages');
        }
        $thread->activateAllParticipants();
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
            
            $thread->addParticipant(Input::get('recipients'));
        }
        $html = view('admin.message.html-message', compact('message'))->render();
        // check if pusher is allowed
        if(config('chatmessenger.use_pusher')) {
            $this->oooPushIt($message);
        }
        if(request()->ajax()) {
            return response()->json([
                'status' => 'OK',
                'message' => $message,
                'html' => $html,
                'thread_subject' => $message->thread->subject,
            ]);
        }

        auth()->user()->notify(new NewMessageThread($thread));
        return redirect()->back();
    }
}
