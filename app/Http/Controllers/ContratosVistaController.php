<?php

namespace App\Http\Controllers;

use App\Models\ContratoMarco;
use App\Models\ValidacionesTecnicas;
use App\Traits\HashIdTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ContratosVistaController extends Controller
{
    use HashIdTrait;
    
    public function indexUrg(){
        $contratosHabilitados = $this->hashEncode(ContratoMarco::contratosHabilitadosUrg(auth()->user()->urg_id));
        $contratosNoHabilitados = $this->hashEncode(ContratoMarco::contratosNoHabilitadosUrg(auth()->user()->urg_id));
        $contratosNoParticipa = $this->hashEncode(ContratoMarco::contratosNoParticipaUrg(auth()->user()->urg_id));

        return view('urgs.contratos.index_urg')->with(['contratosHabilitados' => $contratosHabilitados,'contratosNoHabilitados' => $contratosNoHabilitados,'contratosNoParticipa' => $contratosNoParticipa]);
    }

    public function showUrg($id){

        $contrato = $this->hashEncode(ContratoMarco::find($this->hashDecode($id)));
        $contrato->capitulo_partida = json_decode($contrato->capitulo_partida);
        $contrato->validaciones_seleccionadas = json_decode($contrato->validaciones_seleccionadas);
        $contrato->sector = json_decode($contrato->sector);
        $validaciones = $this->hashEncode(ValidacionesTecnicas::allValidaciones("true"));

        return view('urgs.contratos.show_urg')->with(["contrato" => $contrato, 'validaciones' => $validaciones]);
    }

    public function indexValidador(){
        $contratosVigentes = $this->hashEncode(ContratoMarco::vigentes());
        return view('validador.contratos.index_validador')->with(['contratosVigentes' => $contratosVigentes]);
    }

    public function showValidador($id){

        $contrato = $this->hashEncode(ContratoMarco::find($this->hashDecode($id)));
        $contrato->capitulo_partida = json_decode($contrato->capitulo_partida);
        $contrato->validaciones_seleccionadas = json_decode($contrato->validaciones_seleccionadas);
        $contrato->sector = json_decode($contrato->sector);
        $validaciones = $this->hashEncode(ValidacionesTecnicas::allValidaciones("true"));

        return view('validador.contratos.show_validador')->with(["contrato" => $contrato, 'validaciones' => $validaciones]);
    }

    public function indexProveedor(){
        $contratosHabilitados = $this->hashEncode(ContratoMarco::contratosHabilitadosProveedor(Auth::guard('proveedor')->user()->id));
        $contratosNoHabilitados = $this->hashEncode(ContratoMarco::contratosNoHabilitadosProveedor(Auth::guard('proveedor')->user()->id));
        $contratosNoParticipa = $this->hashEncode(ContratoMarco::contratosNoParticipaProveedor(Auth::guard('proveedor')->user()->id));

        return view('proveedores.contratos.index_proveedor')->with(['contratosHabilitados' => $contratosHabilitados,'contratosNoHabilitados' => $contratosNoHabilitados,'contratosNoParticipa' => $contratosNoParticipa]);
    }

    public function showProveedor($id){
        $contrato = $this->hashEncode(ContratoMarco::find($this->hashDecode($id)));
        $contrato->capitulo_partida = json_decode($contrato->capitulo_partida);
        $contrato->validaciones_seleccionadas = json_decode($contrato->validaciones_seleccionadas);
        $contrato->sector = json_decode($contrato->sector);
        $validaciones = $this->hashEncode(ValidacionesTecnicas::allValidaciones("true"));

        return view('proveedores.contratos.show_proveedor')->with(["contrato" => $contrato, 'validaciones' => $validaciones]);
    }

}
