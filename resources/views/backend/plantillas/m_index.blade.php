@extends('backend.plantillas.master')
@section("titulo") @yield("titulo")
@endsection

@section('contenido')

<div class="cabecera mb-4">
    <div class="row">
        <div class="col-md-9 col-sm-12">
            <h1>@yield('titulo')</h1>
        </div>
        <div class="col-md-3 col-sm-12 d-flex justify-content-end align-items-center">
            <button class="btn btn-primary" style="margin-right: 10px;" data-toggle="collapse" data-target=".filtro"><span class="fa fa-filter"></span></button>
            <button class="btn btn-info" style="margin-right:10px;" onclick="exportExcel()"><span class="fa fa-file-excel"></span></button>
            <a href="@yield('url-crear')" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Agregar donante"> <i class="fa fa-plus"></i> </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>@yield('subtitulo')</h3>
    </div>
    <div class="card-body">
        @yield('m_contenido')
    </div>
</div>
@endsection

@section("modals")
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modalTitulo"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('backend.pregunta_borrar') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btnAceptar">{{ __('backend.aceptar') }}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('backend.cancelar') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section("scripts")
<script>
    var elemento;

        function destroySubmit(element, event, titulo){
            event.preventDefault();

            $("#modalDelete .modalTitulo").html(titulo);
            $("#modalDelete").modal("show");

            elemento = element;
        }

        $("#modalDelete .btnAceptar").on("click", function(){
            elemento.form.submit();
        });

        function exportExcel(){
            var exportar = $("#exportarExcel");
            exportar.click();
        }

</script>
@endsection
