<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\OrdenCompraFirma;
use App\Traits\HashIdTrait;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class ContratoOcUrgController extends Controller
{
    use HashIdTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $totalContratos = count(Contrato::allFirmante(auth()->user()->rfc));
        
        return view('urgs.orden-compra.contratos.index')->with(['totalContratos' => $totalContratos]);
    }

    public function data(){
        $contratos = $this->hashEncode(Contrato::allFirmante(auth()->user()->rfc));
        $firmante = ['titular','adquisiciones','proveedor','financiera','requiriente'];
        foreach($contratos as $key => $contrato){
            $firmas = OrdenCompraFirma::firmas($contrato->id);
            foreach($firmas as $firma){
                $aux = $firmante[$firma->identificador-1];
                $contratos[$key]->$aux = true;
            }
        }
        return Datatables::of($contratos)->toJson();
    }
   
}
