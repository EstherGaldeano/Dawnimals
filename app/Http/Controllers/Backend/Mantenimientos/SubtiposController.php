<?php

namespace App\Http\Controllers\Backend\Mantenimientos;

use App\Models\Subtipo;
use App\Models\Tipo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\Utilitat;
use Illuminate\Database\QueryException;
use App\Exports\ConverterExcel;

class SubtiposController extends Controller
{
    const PREFIX = "backend.paginas.mantenimientos.subtipos.";
    const CONTROLADOR = "Backend\Mantenimientos\SubtiposController@";

    public function index(Request $request)
    {
        $query = Subtipo::query();

        $data = [];
        $query = Utilitat::setFiltros($request, $query, $data);

        if ($request->input('submit') == 'excel'){
            $queryFin = [];

            $lang = \App::getLocale();

            foreach($query->get() as $item){
                array_push($queryFin, [
                    $lang = "ca" ? $item->nombre_cat : $item->nombre_esp,
                    $item->tipos->nombre,
                    $item->gama_alta,
                    $item->gama_media,
                    $item->gama_baja,
                    $item->tipo_unidad
                ]);
            }
            $queryFin = collect($queryFin);

            $headings = [
                __("backend.nombre"),
                __("backend.tipo"),
                __("backend.alta"),
                __("backend.media"),
                __("backend.baja"),
                __("backend.unidad")
            ];

            return ConverterExcel::export($queryFin, $headings, __("backend.subtipos"));
        }

        $data["subtipos"] = $query->paginate(10);
        $data["tipos"] = Tipo::all();

        return view(self::PREFIX . "index", $data);
    }

    public function create()
    {
        $data["tipos"] = Tipo::all();

        return view(self::PREFIX . "create", $data);
    }

    public function store(Request $request)
    {
        $subtipo = new Subtipo();

        $subtipo->nombre_cat = $request->input("nombre_cat");
        $subtipo->nombre_esp = $request->input("nombre_esp");
        $subtipo->nombre_eng = $request->input("nombre_eng");
        $subtipo->tipos_id = $request->input("tipos_id");
        $subtipo->gama_alta = $request->input("gama_alta");
        $subtipo->gama_media = $request->input("gama_media");
        $subtipo->gama_baja = $request->input("gama_baja");
        $subtipo->tipo_unidad = $request->input("tipo_unidad");

        try {
            $subtipo->save();

        } catch (QueryException $ex) {
            $mensaje = Utilitat::controlError($ex);
            $request->session()->flash("error", $mensaje);
            return redirect()->action(self::CONTROLADOR . 'create')->withInput();
        }
        return redirect()->action(self::CONTROLADOR . 'index');
    }

    public function edit(Subtipo $subtipo)
    {
        $data["subtipo"] = $subtipo;
        $data["tipos"] = Tipo::all();

        return view(self::PREFIX . "edit", $data);
    }

    public function update(Request $request, Subtipo $subtipo)
    {
        $subtipo->nombre_cat = $request->input("nombre_cat");
        $subtipo->nombre_esp = $request->input("nombre_esp");
        $subtipo->nombre_eng = $request->input("nombre_eng");
        $subtipo->tipos_id = $request->input("tipos_id");
        $subtipo->gama_alta = $request->input("gama_alta");
        $subtipo->gama_media = $request->input("gama_media");
        $subtipo->gama_baja = $request->input("gama_baja");
        $subtipo->tipo_unidad = $request->input("tipo_unidad");

        try {
            $subtipo->save();

        } catch (QueryException $ex) {
            $mensaje = Utilitat::controlError($ex);
            $request->session()->flash("error", $mensaje);
            return redirect()->action(self::CONTROLADOR . 'edit')->withInput();
        }
        return redirect()->action(self::CONTROLADOR . 'index');
    }

    public function destroy(Request $request, Subtipo $subtipo)
    {
        try {
            $subtipo->delete();
        } catch (QueryException $ex) {
            $mensaje = Utilitat::controlError($ex);
            $request->session()->flash("error", $mensaje);
        }
        return redirect()->action(self::CONTROLADOR . 'index');
    }
}
