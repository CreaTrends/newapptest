<?php

namespace App\Http\Controllers;

use App\Album;
use App\User;
use App\Curso;
use App\Photo;
use Illuminate\Http\Request;

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
        $userID = auth()->user()->id;
        $request->request->add(['album_name' => $request->album_name]);
        $request->request->add(['album_token' => bin2hex(openssl_random_pseudo_bytes(30))]);
        $request->request->add(['album_owner' => $userID]);

        $validatedData = $request->validate([
            'album_name' => 'required|max:255',
            'album_token' => 'required|max:255',
            'album_owner' => 'required|exists:users,id',
        ]);
        
        

        $album = Album::create($request->all());
        //$album->photos()->attach(json_encode($request->photos));
        //$album->photos()->save(json_encode($request->photos));
        foreach ($request->file('photos') as $photo) {
            $name = $photo->getClientOriginalName();
            $sub_name = md5($name.time()).'.'.$photo->getClientOriginalExtension();
            $thumb_name = 'thumb_'.md5($name.time()).'.'.$photo->getClientOriginalExtension();
            $folder_album = md5(time());
            $path = '/static/image/albums/'.$folder_album.'/';
            $photo->move(public_path().$path, $sub_name);
            $avatar= public_path().$path.$sub_name;
            \Image::make($avatar)->fit(200, 200)->save( public_path($path .$thumb_name ) );
            

            $form = new Photo();
            $form->photo_name=$sub_name;
            $form->album_id=$album->id;
            $form->photo_path=$path;
            $form->save();
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
    public function destroy(Album $album)
    {
        //
    }
}
