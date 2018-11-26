<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/articles','UserController@getall');

Route::group(['prefix'=>'v1','middleware' => 'auth'], function(){
    Route::get('find', function(Illuminate\Http\Request $request){
        $keyword = $request->input('keyword');
        Log::info($keyword);
        $skills = DB::table('cursos')->where('name','like','%'.$keyword.'%')
                  ->select('cursos.id','cursos.name','cursos.slug')
                  ->get();
        return json_encode($skills);
    })->name('api.skills');
});




Route::middleware('auth:api')->group(function () {
  Route::get('test', function(Illuminate\Http\Request $request){
        $keyword = $request->input('keyword');
        Log::info($keyword);
        $skills = DB::table('cursos')->where('name','like','%'.$keyword.'%')
                  ->select('cursos.id','cursos.name','cursos.slug')
                  ->get();

        $rr = (array)$skills; 
        
        foreach($skills as $skill){
          $ret[] = array('value' => $skill->id, 'text' => $skill->name);
        }
        return json_encode($ret);
    })->name('api.skills');
  Route::get('parentslist', function(Illuminate\Http\Request $request){
        $keyword = $request->input('keyword');
        Log::info($keyword);
        $skills = DB::table('profiles')->where('first_name','like','%'.$keyword.'%')
                  ->select('profiles.user_id','profiles.first_name','profiles.last_name')
                  ->get();

        $rr = (array)$skills; 
        
        foreach($skills as $skill){
          $ret[] = array('value' => $skill->user_id, 'text' => $skill->first_name.' '.$skill->last_name);
        }
        return json_encode($ret);
    })->name('api.parentslist');

  Route::get('childlist', function(Illuminate\Http\Request $request){
        $keyword = $request->input('keyword');
        Log::info($keyword);
        $skills = DB::table('alumnos')->where('firstname','like','%'.$keyword.'%')
                  ->select('alumnos.id','alumnos.firstname','alumnos.lastname')
                  ->get();

        $rr = (array)$skills; 
        
        foreach($skills as $skill){
          $ret[] = array('value' => $skill->id, 'text' => $skill->firstname.' '.$skill->lastname);
        }
        return json_encode($ret);
    })->name('api.childlist');
});


Route::middleware('auth:api')->get('/alumnos','NotebookController@filter');

