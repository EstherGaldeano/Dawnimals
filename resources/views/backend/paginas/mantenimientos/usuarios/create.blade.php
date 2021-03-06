@extends('backend.plantillas.m_create')
@section('titulo', __("backend.usuario_alta"))
@section('url-index', url("backend/mantenimientos/usuarios"))

@section('url-form', action('Backend\Mantenimientos\UsuariosController@store'))
@section('m_contenido')


<div class="form-group col-md-6">
    <label for="nombre">{{ __("backend.nombre") }}</label>
    <input name="nombre" id="nombre" type="text" class="col form-control" value="{{ old('nombre') }}">
</div>

<div class="form-group col-md-6">
    <label for="nombre_usuario">{{ __("backend.usuario") }}</label>
    <input name="nombre_usuario" id="nombre_usuario" type="text" class="col form-control" value="{{ old('nombre_usuario') }}">
</div>

<div class="form-group col-md-6">
    <label for="correo">{{ __("backend.correo") }}</label>
    <input name="correo" id="correo" type="email" class="col form-control" value="{{ old('correo') }}">
</div>

<div class="form-group col-md-6">
    <label for="password">{{ __("backend.password") }}</label>
    <input name="password" id="password" type="password" class="col form-control" value="{{ old('password') }}">
</div>

<div class="form-group col-md-6">
    <label for="admin">{{ __("backend.perfil") }}</label>
    <select name="admin" id="admin" class="col form-control">
        @foreach($roles as $rol => $texto)
            <option value="{{ $rol }}" {{ old("admin") == $rol ? "selected" : ""}}>{{ $texto }}</option>
        @endforeach
    </select>
</div>
@endsection
