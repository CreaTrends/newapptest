@extends('layouts.app')

@section ('css')
@endsection

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Hola {{$user->name}}</strong> por seguridad necesitas cambiar tu clave de acceso
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card shadow-sm p-3 mb-5 bg-white rounded">
                <div class="card-header">
                    <h4 class="card-title">Actualiza tu contraseña</h4>
                    <h6 class="card-subtitle">Inresa tu nueva contraseña</h6>
                </div>
                <div class="card-body">
                    @if (Session::has('success'))
                    <div class="alert alert-success">{!! Session::get('success') !!}</div>
                    @endif
                    @if (Session::has('failure'))
                    <div class="alert alert-danger">{!! Session::get('failure') !!}</div>
                    @endif
                    <form action="{{ route('password.post_expired') }}" method="post" role="form" class="form-horizontal">
                        {{csrf_field()}}
                        <div class="form-group{{ $errors->has('old') ? ' has-error' : '' }}">
                            <label for="email" class="custom-label">Password Actual</label>
                            <input id="password" type="password" class="form-control" name="old">

                            @if ($errors->has('old'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('old') }}</strong>
                                </span>
                                @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="custom-label">Nueva Contraseña</label>
                            <input id="password" type="password" class="form-control" name="password">
                                
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                        </div>
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password" class="custom-label">Confirmar nueva Contraseña</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                
                                @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block custom-btn is-default">
                            Cambiar contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection