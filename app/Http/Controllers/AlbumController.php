<?php

namespace App\Http\Controllers;

use App\Album;
use App\User;
use App\Curso;
use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;

use App\Notifications\NewAlbumNotification;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $albums = Album::withCount('photo')->get();
        $cursos = Curso::all();
        //return $albums;
        return view('admin.albums.index',compact('albums','cursos'));
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
        $token = bin2hex(openssl_random_pseudo_bytes(20));
        $userID = auth()->user()->id;
        $request->request->add(['album_name' => $request->album_name]);
        $request->request->add(['album_token' => $token]);
        $request->request->add(['album_owner' => $userID]);

        $validatedData = $request->validate([
            'album_name' => 'required|max:255',
            'album_token' => 'required|max:255',
            'album_owner' => 'required|exists:users,id',
        ]);
        
        if($request->curso == 'all'){
            $request->curso = Curso::all()->pluck('id')->toArray();
        }else {
            $request->curso = Curso::where('id',$request->curso)->pluck('id')->toArray();
        }

        //return $request->curso;

        $album = Album::create($request->all());
        $album->curso()->attach($request->curso);

        /*
        //$album->photos()->save(json_encode($request->photos));
        foreach ($request->file('photos') as $photo) {
            $name = $photo->getClientOriginalName();
            $file_name = md5($name.time()).'.'.$photo->getClientOriginalExtension();
            $sub_name = $file_name;
            $thumb_name = 'thumb_'.$file_name;
            $crop_name = 'crop_'.$file_name;
            $folder_album = time();
            $path = '/static/uploads/albums/'.$folder_album.'/';
            //$photo->move(public_path().$path, $sub_name);
            $photo->move(public_path().$path, $sub_name);

            $avatar= public_path().$path.$sub_name;

            \Image::make($avatar)->fit(400)->save( public_path($path .$thumb_name ) );
            

            $form = new Photo();
            $form->photo_name=$sub_name;
            $form->album_id=$album->album_id;
            $form->photo_path=$path;
            $form->save();
        }*/
        $aa = is_array($request->curso) ? $request->curso : (array) $request->curso;

        //$alumno_parent_sent = Curso::with('parent_list')->whereIn('id',$aa)->get()->pluck('parent_list');

        $curso_id = $request->curso;

        //return response()->json($alumno_parent_sent,[],200,JSON_PRETTY_PRINT);
        $sent_to = User::selectRaw('users.*')
        ->join('alumno_parent','alumno_parent.user_id','=','users.id')
        ->join('alumno_curso','alumno_curso.alumno_id','=','alumno_parent.alumno_id')
        ->join('cursos','cursos.id','=','alumno_curso.curso_id')
        ->whereIn('cursos.id',$curso_id)
        ->get();

        //return response()->json($sent_to,200,[],JSON_PRETTY_PRINT);


        foreach($sent_to as $users){
            $user = User::findorFail($users->id);
            $user->notify(new NewAlbumNotification($album, \Auth::id()));
            //$user->notifications()->delete();
        }
        
        //$album->photos()->attach($album->id);


        return redirect()->route('albums.show', $album->id);

        //return $request->photos;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        //
        $albums = Album::where('album_id',$id)->with('photo')->first();

        return view('admin.albums.show',compact('albums'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        //
        $albums = Album::where('album_id',$id)->with('photo')->first();

        return view('admin.albums.edit',compact('albums'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Album $album)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        $albums = Album::findOrfail($id);

        $token = $albums->pluck('album_token')->toArray();

        $path = '/albums/'.$albums->album_token;

        /*Storage::deleteDirectory($path);

        return Storage::directories('public');*/

        /*\File::delete($path);*/


        $albums->photo()->delete();
        $albums->delete();

        

        return redirect()->back()->with('info', 'Album Eliminado');
    }
}
