<?php

namespace App\Http\Controllers\Backend;
use App\Models\Donacion;
use App\Models\Centro;
use App\Models\Tipo;
use App\Models\Subtipo;
use App\Models\Usuario;
use App\Models\Donante;
use App\Models\Animal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Classes\Utilitat;
use App\Exports\ConverterExcel;
use Carbon\Carbon;

class DonacionController extends Controller
{
    const PREFIX = 'backend.paginas.donaciones.';
    const CONTROLADOR = 'Backend\DonacionController@';

    public function index(Request $request)
    {
        $resultado = Utilitat::cargaMantenimiento($request, Donacion::class, 'donaciones', __("backend.donacion"), $data, 25);
        if ($resultado != null) return $resultado;

        $data["centros"] = Centro::all();

        return view(self::PREFIX.'index',$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $centros= Centro::all();
        $tipos = Tipo::all();
        $subtipos = Subtipo::all();
        $usuarios = Usuario::all();
        $donantes = Donante::all();
        $animales = Animal::All();

        $data["donantes"] = $donantes;
        $data['usuarios'] = $usuarios;
        $data['centros'] = $centros;
        $data['tiposDonacion'] = $tipos;
        $data['subtiposDonacion'] = $subtipos;
        $data['animales'] = $animales;

        return view(self::PREFIX.'create', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $donacion = new Donacion();
        $donacion->subtipos_id = $request->input('subtipos_id');
        $donacion->centros_receptor_id = $request->input('centros_receptor_id');
        $donacion->centro_receptor_altres = $request->input('centro_receptor_altres');
        $donacion->usuarios_id = \Auth::user()->id;
        $donacion->usuario_receptor = $request->input('usuario_receptor');
        $donacion->centros_desti_id = $request->input('centros_desti_id');
        $donacion->donantes_id = $request->input('donantes_id');
        $donacion->coste = $request->input('coste');
        $donacion->unidades = $request->input('unidades');
        $donacion->peso = $request->input('peso');
        $donacion->fecha_donativo = Carbon::now('Europe/Madrid');
        $donacion->hay_factura = $request->input('hay_factura');
        $donacion->ruta_factura = $request->input('ruta_factura');
        $donacion->es_coordinada = $request->input('es_coordinada');

        $donacion->desc_animal = Animal::find($request->input("animal_id"))->nombre;

        try{
            $donacion->save();

            $donacion->animales()->attach($request->input("animal_id"));

            return redirect()->action(self::CONTROLADOR .'index');
        }catch(QueryException $e){
            $error = Utilitat::errorMessages($e);
            $request->session()->flash('error',$error);
            return redirect()->action(self::CONTROLADOR .'create')->withInput();
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Donacion  $donacion
     * @return \Illuminate\Http\Response
     */
    public function show(Donacion $donacion)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Donacion  $donacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Donacion $donacione)
    {
        $data['donacion'] = $donacione;
        $data['tiposDonacion'] = Tipo::all();
        $data['subtiposDonacion'] = Subtipo::all();
        $data['centros'] = Centro::all();
        $data['usuarios'] = Usuario::all();
        $data["donante"] = Donante::where('id',$donacione->donantes_id)->first();
        $data["animales"] = Animal::all();
        return view(self::PREFIX.'edit',$data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Donacion  $donacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Donacion $donacione)
    {

        $validation = validator($request->all());
        if($validation->fails()){
            return redirect('DonanteController')
                        ->withErrors($validator)
                        ->withInput();
        }else{
            $donacione->subtipos_id = $request->input('subtipos_id');
            $donacione->desc_animal = $request->input('desc_animal');
            $donacione->centros_receptor_id = $request->input('centros_receptor_id');
            $donacione->centro_receptor_altres = $request->input('centro_receptor_altres');
            $donacione->usuario_receptor = $request->input('usuario_receptor');
            $donacione->centros_desti_id = $request->input('centros_desti_id');
            $donacione->donantes_id = $request->input('donantes_id');
            $donacione->coste = $request->input('coste');
            $donacione->unidades = $request->input('unidades');
            $donacione->peso = $request->input('peso');
            $donacione->hay_factura = $request->input('hay_factura');
            $donacione->ruta_factura = $request->input('ruta_factura');
            $donacione->es_coordinada = $request->input('es_coordinada');

            $donacione->desc_animal = Animal::find($request->input("animal_id"))->nombre;

            try{
                $donacione->animales()->detach();
                $donacione->animales()->attach($request->input("animal_id"));

                $donacione->save();
                return redirect()->action(self::CONTROLADOR .'index');
            }catch(QueryException $e){
                $error = Utilitat::errorMessages($e);
                $request->session()->flash('error',$error);
                return redirect()->action(self::CONTROLADOR .'edit')->withInput();
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Donacion  $donacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Donacion $donacione)
    {
        try{
            if($donacione!=null){
                $donacione->animales()->detach();
                $donacione->delete();
                return redirect()->action(self::CONTROLADOR .'index');
            }
        }catch(QueryException $e){
            $error = Utilitat::errorMessages($e);
            $request->session()->flash('error',$error);
            return redirect()->action(self::CONTROLADOR .'index');
        }
    }

    public function diploma(Donacion $donacione){
        $data['donacion'] = $donacione;

        return view('backend.paginas.donaciones.diploma', $data);
    }
}
