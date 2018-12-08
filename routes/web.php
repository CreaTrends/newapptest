<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Notifications\NewNoteNotification;
use App\Note;
use App\Mail\TestMail;

use App\Events\StatusLiked;

//use Newsletter;
use \DrewM\MailChimp\MailChimp;



Route::get('/', function () {
    return redirect('home');
})->middleware('auth');

Route::get('testeando', function () {
/*
$MailChimp = new MailChimp('f18cea50340b78c0ca8e9d4309020aee-us17');


$result = $MailChimp->get('lists');
$reply_to = 'contacto@jardinanatolia.cl';
$from_name = 'test anatolia';

$result = $MailChimp->post("campaigns", [
    'type' => 'regular',
    'recipients' => ['list_id' => '32bab74239'],
    'settings' => [
        'subject_line' => 'Your Purchase Receipt-'.+time(),
           'reply_to' => $reply_to,
           'from_name' => $from_name,
           'template_id'=>100553
          ]
    ]);

$response = $MailChimp->getLastResponse();
$responseObj = json_decode($response['body']);

$html = 'aaaaaa';
$result = $MailChimp->put('campaigns/' . $responseObj->id . '/content', [
      'template' => ['id' => 100553, 
        'sections' => [
            "preheader_leftcol_content"=>'top pre header',
            "preheader_rightcol_content"=>'right pre header,api.php',
            "postcard"=>'http://www.jardinanatolia.cl/wp-content/uploads/2017/11/IMG_7813-910x400.jpg',
            "body_content"=>'esto es el body'
        ]
        ]

      ]);


$result = $MailChimp->post('campaigns/' . $responseObj->id . '/actions/send');


return response()->json($result,200,[],JSON_PRETTY_PRINT);*/
/*$note = Note::first();
$user = App\User::findorFail(4);
            $user->notify(new NewNoteNotification($note, $user->id));*/
Mail::raw('Sending emails with Mailgun and Laravel is easy!', function($message)
    {
        $message->subject('Mailgun and Laravel are awesome!');
        $message->from('no-reply@mg.jardinanatolia.cl', 'Equipo Jardin Anatolia');
        $message->replyTo('info@jardinanatolia.cl','Equipo Jardin Anatolia');
        $message->to('jalbornozdesign@gmail.com');
    });
    
});

Route::get('notebooks-indeex', function () {
    return view('admin.notebooks.show');
});
Route::get('pushertest', function () {



    $note = Note::first();
    $user = auth()->user();
    $message = "Hello";

    $user = App\User::find(3);
    $user->notify(new NewNoteNotification($note, $user->id));
    $user = App\User::find(Auth::id());

  //event(new StatusLiked($note,$user));

    return "Event has been sent!";
});
Route::get('pusher', function () {
    return view('counter');
})->middleware('auth');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::group(['prefix' => 'admin','middleware' => 'auth','middleware' => ['role:teacher|administrator|superadministrator']], function () {
//Route::resource('tasks', 'TaskController', ['except' => 'show', 'create', 'edit']);
Route::middleware(['password_expired'])->group(function () {
Route::get('usuarios/all', 'UserController@getall');

Route::resource('admin', 'AdminController');
Route::get('/', 'AdminController@index')->name('index');
/*Cursos*/
Route::resource('/cursos', 'CursoController');
Route::get('notebook/report', 'NotebookController@report')->name('notebook.report');
Route::get('notebook/forms', 'NotebookController@forms')->name('notebook.forms');
Route::resource('notebook', 'NotebookController');


Route::get('cursos/activity/{id}', 'CursoController@activity')->name('cursos.activity');
Route::get('cursos/notes/{id}', 'CursoController@notes')->name('notes');
Route::get('cursos/notes/create/{id}', 'CursoController@notes')->name('notes.create');

Route::resource('/cursos/notes', 'NoteController');

Route::get('cursos/{id}/notebook/', 'CursoController@notebook')->name('notebook.create');
//Route::post('cursos/notebook/', 'CursoController@notebookstore')->name('notebook.store');
Route::get('cursos/notebook/{id}', 'NotebookController@index')->name('notebook.show');

Route::post('cursos/deleteall','CursoController@deleteall')->name('cursos.deleteall');
//Route::get('cursos/notebook/{id}', 'NotebookController@index')->name('cursos.notebook');
/*



Route::resource('notes', 'NoteController');
Route::resource('notebook', 'NotebookController');
*/
Route::resource('notes', 'NoteController');
Route::post('notes/deleteall','NoteController@deleteall')->name('notes.deleteall');
Route::post('notes/saving','NoteController@save')->name('notes.save');
Route::get('notes/display/{id}','NoteController@displaynote')->name('notes.display');
//Route::resource('cursos/notebook', 'NotebookController');
//Route::get('cursos/{id}/notebook/', 'NotebookController@show')->name('cursos.notebook');

Route::get('notify', 'CursoController@notify')->name('cursos.notify');
Route::resource('/alumnos', 'AlumnoController');
Route::resource('/usuarios', 'UserController');
Route::resource('/settings', 'SettingController');
Route::put('/alumnos/updateinfo/{alumno}', 'AlumnoController@updateinfo')->name('alumnos.updateinfo');
Route::put('/alumnos/updatecurso/{alumno}', 'AlumnoController@updateCurso')->name('alumnos.updatecurso');
Route::post('alumnos/deleteall','AlumnoController@deleteall')->name('alumnos.deleteall');
/*Route::resource('/actividades', 'ActividadController');
Route::resource('/comunicaciones', 'ComunicacionController');
Route::resource('/galerias', 'GeleriaController');
Route::resource('/settings', 'SettingsController');*/
Route::get('/getdata', 'CursoController@getdata')->name('cursos.getdata');
Route::get('/getcursos', 'AlumnoController@getcursos');

Route::post('/tools/import', 'ToolController@importExcel')->name('tools.import');
Route::get('/tools/export/{id}', 'ToolController@exportExcel')->name('tools.export');
Route::get('/tools/download/{id}/{file}','ToolController@DownloadAttach')->name('admin.tools.download')->middleware('auth');
Route::get('tools/test', 'ToolController@test')->name('tools.test');
Route::post('invite/send/{id}', 'AlumnoController@inviteParent')->name('invite.send');
Route::get('invite/process', 'AlumnoController@inviteProcess');
// messages 
Route::get('messages', ['as' => 'admin.messages', 'uses' => 'MessagesController@index']);
Route::get('message/create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
Route::post('messages', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
Route::get('message/{id}', ['as' => 'message.show', 'uses' => 'MessagesController@show']);
Route::get('messagemodal/{id}', ['as' => 'admin.message.showmodal', 'uses' => 'MessagesController@modalshow']);
Route::put('/message/{id}', ['as' => 'admin.inbox.update', 'uses' => 'MessagesController@update']);
Route::post('/messages/filter', ['as' => 'admin.messages.filter', 'uses' => 'MessagesController@filterUser'])->middleware('auth');
Route::post('/messages/removeparticipant/{id}', ['as' => 'admin.messages.removeparticpant', 'uses' => 'MessagesController@removeparticipant'])->middleware('auth');
Route::get('/message/delete/{id}', ['as' => 'message.delete', 'uses' => 'MessagesController@delete']);
// albums 
Route::resource('albums','AlbumController');

});
});

/*Route::group(['prefix' => 'messages'], function () {
    Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
    Route::get('/unread', ['as' => 'messages.unread', 'uses' => 'MessagesController@unread']); // ajax + Pusher
    Route::get('/create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
    Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
    Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
    Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
    Route::get('{id}/read', ['as' => 'messages.read', 'uses' => 'MessagesController@read']); // ajax + Pusher
});*/

Route::group(['prefix' => 'apoderado','middleware' => 'auth', 'middleware' => ['role:parent']], function () {
    

Route::middleware(['password_expired'])->group(function () {
    //Route::resource('/', 'ApoderadoController@index');
    Route::get('/',['as' => 'apoderado.feed', 'uses' => 'ApoderadoController@index']);
    Route::get('child/{id}',['as' => 'apoderado.child', 'uses' => 'ApoderadoController@show']);
    Route::get('childs', 'ApoderadoController@child')->name('apoderado.childs');
    Route::get('childs/{id}', 'ApoderadoController@showChild')->name('apoderador.childs.show');
    Route::get('messages', ['as' => 'apoderado.messages', 'uses' => 'ApoderadoController@inbox']);

    Route::get('message/{id}', ['as' => 'apoderados.inbox.show', 'uses' => 'ApoderadoController@inboxshow']);
    Route::put('/message/{id}', ['as' => 'apoderados.inbox.update', 'uses' => 'MessagesController@update']);
    Route::delete('/message/{id}', ['as' => 'apoderados.inbox.delete', 'uses' => 'MessagesController@removeparticipant']);

    Route::get('profile/{id}',['as' => 'apoderado.profile', 'uses' => 'ApoderadoController@profile']);
    Route::put('profile/{id}',['as' => 'apoderado.profile.update', 'uses' => 'ApoderadoController@updateProfile']);
    Route::get('notes', ['as' => 'apoderado.notes', 'uses' => 'ApoderadoController@notes'],[
'except' => ['destroy', 'create']
]);
    Route::delete('notes/deleteuser/{id}','NoteController@deleteuser')->name('notes.deleteuser');
    Route::get('notes/display/{id}','NoteController@displaynote')->name('apoderado.notes.display');
    Route::get('notes/{id}',['as' => 'apoderado.notes.show', 'uses' => 'ApoderadoController@noteshow']);
    Route::get('/tools/download/{id}/{file}', 'ToolController@DownloadAttach')->name('apoderados.tools.download');
    

    Route::get('albums',['as' => 'apoderado.albums', 'uses' => 'ApoderadoController@albums']);
    Route::get('album/{id}/{token}',['as' => 'apoderado.album', 'uses' => 'ApoderadoController@album']);

    Route::get('child/{id}/feed',['as' => 'child.feed', 'uses' => 'ApoderadoController@show']);
    Route::get('child/{id}/feed',['as' => 'child.feed', 'uses' => 'ApoderadoController@show']);
    /*Route::get('cauro/{id}',['as' => 'cauro', 'uses' => 'ApoderadoController@cauro']);*/
    Route::get('notebook/{id}',['as' => 'notebook.show', 'uses' => 'NotebookController@show']);


    Route::get('/messages/new', 'ApoderadoController@createmessage')->name('apoderados.message.create');
    Route::post('inbox', ['as' => 'apoderado.messages.store', 'uses' => 'MessagesController@store']);

    Route::delete('/messages/removeparticipant/{id}', ['as' => 'apoderado.messages.removeparticpant', 'uses' => 'MessagesController@removeparticipant'])->middleware('auth');

    Route::get('messagemodal/{id}', ['as' => 'apoderado.message.showmodal', 'uses' => 'MessagesController@modalshow']);
});



    
});

Route::get('password/expired', 'Auth\FirstloginController@index')
        ->name('password.expired');

        Route::post('password/post_expired', 'Auth\FirstloginController@update')
        ->name('password.post_expired');

Route::group(['prefix' => 'tools/notifications','middleware' => 'auth','middleware' => ['role:teacher|administrator|superadministrator|parent']], function () {
    Route::get('delete', 'ToolController@notificationdelete')->name('tools.deletenotification');
    Route::get('readall', 'ToolController@notificationreadall')->name('tools.readallnotification');
    Route::get('markasread', 'ToolController@notificationmarkasread')->name('tools.markasreadnotification');
});







