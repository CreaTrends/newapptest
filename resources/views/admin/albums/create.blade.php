@extends('layouts.adminDashboard')
@section('title', 'Crear Galeria')
@section('page-subtitle','crear galeria de imagenes')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-5">
            <form action="{{route('albums.store')}}"  enctype="multipart/form-data" class="form" method="POST">
                {{ method_field('POST') }}
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name">Nombre Album</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="description">Album Description</label>
                    <textarea name="description" type="text"class="form-control" placeholder="Albumdescription"></textarea>
                </div>
                <div class="form-group">
                    <label for="cover_image">Select a Cover Image</label>
                    {{Form::file('cover_image')}}
                </div>
                <button type="submit" class="btn custom-btn is-lightgreen" data-toggle="modal" data-target="#create">Agregar Curso</button>
            </form>
        </div>
    </div>
</div>
@endsection