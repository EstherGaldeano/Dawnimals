@extends('backend.plantillas.m_edit')
@section('titulo','EDITAR PERFIL')
@section('url-index', url('backend/mantenimientos/perfiles'))

@section('url-form', action('Backend\Mantenimientos\PerfilesController@update', ['id' => $role->id ]))
@section('m_contenido')

<div class="form-group offset-md-3 col-md-6">
    <label for="rol">Perfil</label>
    <input name="rol" id="rol" type="text" class="col form-control" value="{{ $role->rol }}">
</div>
@endsection
