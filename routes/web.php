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

Route::get('/', function () {
    return view('home');
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


Route::get('cursos/activity/{id}', 'CursoController@activity')->name('cursos.activity');
Route::get('cursos/notes/{id}', 'CursoController@notes')->name('notes');
Route::get('cursos/notes/create/{id}', 'CursoController@notes')->name('notes.create');

Route::resource('/cursos/notes', 'NoteController');

Route::get('cursos/{id}/notebook/', 'CursoController@notebook')->name('notebook.create');
Route::post('cursos/notebook/', 'CursoController@notebookstore')->name('notebook.store');
Route::get('cursos/notebook/{id}', 'NotebookController@index')->name('notebook.show');
//Route::get('cursos/notebook/{id}', 'NotebookController@index')->name('cursos.notebook');
/*



Route::resource('notes', 'NoteController');
Route::resource('notebook', 'NotebookController');
*/

//Route::resource('cursos/notebook', 'NotebookController');
//Route::get('cursos/{id}/notebook/', 'NotebookController@show')->name('cursos.notebook');

Route::get('notify', 'CursoController@notify')->name('cursos.notify');
Route::resource('/alumnos', 'AlumnoController');
Route::resource('/usuarios', 'UserController');
Route::resource('/settings', 'SettingController');
Route::put('/alumnos/updateinfo/{alumno}', 'AlumnoController@updateinfo')->name('alumnos.updateinfo');
Route::put('/alumnos/updatecurso/{alumno}', 'AlumnoController@updateCurso')->name('alumnos.updatecurso');
/*Route::resource('/actividades', 'ActividadController');
Route::resource('/comunicaciones', 'ComunicacionController');
Route::resource('/galerias', 'GeleriaController');
Route::resource('/settings', 'SettingsController');*/
Route::get('/getdata', 'CursoController@getdata')->name('cursos.getdata');
Route::get('/getcursos', 'AlumnoController@getcursos');

Route::post('/tools/import', 'ToolController@importExcel')->name('tools.import');
Route::get('/tools/export/{id}', 'ToolController@exportExcel')->name('tools.export');
Route::get('/tools/download/{file}', 'ToolController@DownloadAttach')->name('tools.download');
Route::get('tools/test', 'ToolController@test')->name('tools.test');
Route::post('invite/send/{id}', 'AlumnoController@inviteParent')->name('invite.send');
Route::get('invite/process', 'AlumnoController@inviteProcess');
// messages 
Route::get('messages', ['as' => 'admin.messages', 'uses' => 'MessagesController@index']);
Route::get('message/create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
Route::post('messages', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
Route::get('message/{id}', ['as' => 'message.show', 'uses' => 'MessagesController@show']);
Route::put('./message/{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);

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
    Route::get('profile',['as' => 'apoderado.profile', 'uses' => 'ApoderadoController@profile']);
    Route::put('profile/{id}',['as' => 'apoderado.profile.update', 'uses' => 'ApoderadoController@updateProfile']);
    Route::get('notes', ['as' => 'apoderado.notes', 'uses' => 'ApoderadoController@notes'],[
'except' => ['destroy', 'create']
]);
    Route::get('notes/{id}',['as' => 'apoderado.notes.show', 'uses' => 'ApoderadoController@noteshow']);
});

    
});

Route::get('password/expired', 'Auth\FirstloginController@index')
        ->name('password.expired');

        Route::post('password/post_expired', 'Auth\FirstloginController@update')
        ->name('password.post_expired');

/*Route::group(['prefix' => 'teacher','middleware' => 'auth', 'middleware' => ['role:teacher']], function () {
    Route::resource('/', 'TeacherController');
    Route::get('cursos', ['as' => 'teacher.cursos', 'uses' => 'CursoController@index']);
    Route::get('/getdata', 'CursoController@getdata')->name('cursos.getdata');
});*/







