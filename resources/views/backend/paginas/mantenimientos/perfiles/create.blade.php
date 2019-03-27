@extends('backend.plantillas.master')

@section('titulo','Perfiles')


@section('contenido')

<div class="container">
    <form action="{{ action("Backend\Mantenimientos\PerfilesController@store") }}" method="post">
        @csrf

        <div class="titulo text-center mb-3">
            <h4>ALTA PERFIL</h4>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h4>Datos</h4>
            </div>
            <div class="card-body row">
                <div class="form-group offset-md-3 col-md-6">
                    <label for="rol" >Nombre</label>
                    <input name="rol" id="rol" type="text" class="col form-control" value="{{ old("rol") }}">
                </div>
            </div>
        </div>
        <div class="botonAceptar text-center mb-5 mt-4">
            <button type="submit" class="btn btn-primary col-5">GUARDAR</button>
            <a class="btn btn-secondary col-5" href="{{ url("backend/mantenimientos/perfiles") }}">CANCELAR</a>
        </div>
    </form>
</div>
@endsection
