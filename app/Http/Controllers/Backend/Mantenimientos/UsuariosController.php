<?php

namespace App\Http\Controllers\Backend\Mantenimientos;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Classes\Utilitat;
use Illuminate\Database\QueryException;
use App\Exports\ConverterExcel;

class UsuariosController extends Controller
{
    const PREFIX = "backend.paginas.mantenimientos.usuarios.";
    const CONTROLADOR = "Backend\Mantenimientos\UsuariosController@";

    public function getRoles(){
        return [
            true => __("backend.administrador"),
            false => __("backend.trabajador")
        ];
    }

    public function index(Request $request)
    {
        $resultado = Utilitat::cargaMantenimiento($request, Usuario::class, 'usuarios', __("backend.usuarios"), $data, 10);
        if ($resultado != null) return $resultado;

        $data["roles"] = $this->getRoles();

        return view(self::PREFIX . "index", $data);
    }

    public function create()
    {
        $data["roles"] = $this->getRoles();

        return view(self::PREFIX . "create", $data);
    }

    public function store(Request $request)
    {
        $usuario = new Usuario();

        $usuario->nombre = $request->input("nombre");
        $usuario->nombre_usuario = $request->input("nombre_usuario");
        $usuario->correo = $request->input("correo");
        $usuario->admin = boolval($request->input("admin"));

        $password = $request->input("password");
        if ($password != null) {
            $usuario->password = Hash::make($request->password);
        }

        try {
            $usuario->save();

        } catch (QueryException $ex) {
            $mensaje = Utilitat::controlError($ex);
            $request->session()->flash("error", $mensaje);
            return redirect()->action(self::CONTROLADOR . 'create')->withInput();
        }
        return redirect()->action(self::CONTROLADOR . 'index');
    }

    public function edit(Usuario $usuario)
    {
        $data["roles"] = $this->getRoles();
        $data["usuario"] = $usuario;

        return view(self::PREFIX . "edit", $data);
    }

    public function update(Usuario $usuario, Request $request)
    {
        $usuario->nombre = $request->input("nombre");
        $usuario->nombre_usuario = $request->input("nombre_usuario");
        $usuario->correo = $request->input("correo");
        $usuario->admin = boolval($request->input("admin"));

        $password = $request->input("password");
        if ($password != null) {
            $usuario->password = Hash::make($request->password);
        }

        try {
            $usuario->save();

        } catch (QueryException $ex) {
            $mensaje = Utilitat::controlError($ex);
            $request->session()->flash("error", $mensaje);
            return redirect()->action(self::CONTROLADOR . 'edit')->withInput();
        }
        return redirect()->action(self::CONTROLADOR . 'index');
    }

    public function destroy(Request $request, Usuario $usuario)
    {
        try {
            $usuario->delete();
        } catch (QueryException $ex) {
            $mensaje = Utilitat::controlError($ex);
            $request->session()->flash("error", $mensaje);
        }
        return redirect()->action(self::CONTROLADOR . 'index');
    }
}
