<?php

namespace App\Traits;

use App\Models\AdjudicacionDirecta;
use App\Models\AnexosAdjudicacion;
use App\Models\AnexosPublica;
use App\Models\AnexosRestringida;
use App\Models\ExpedienteContratoMarco;
use App\Models\InvitacionRestringida;
use App\Models\LicitacionPublica;
use App\Models\Proveedor;
use App\Traits\HashIdTrait;
use App\Traits\ProveedoresTrait;


trait ExpedienteTrait{

	use HashIdTrait, ProveedoresTrait;

	public function adjudicacionDirecta($id){
		$data = null;
        $adjudicacion = AdjudicacionDirecta::where('expediente_id',$id)->get();
        if($adjudicacion->isEmpty() == false ){
        	$adjudicacion = $adjudicacion[0];
	        $adjudicacion = $this->hashEncode($adjudicacion);
	        $carpeta = "adjudicacion-directa-".$adjudicacion->id;
	        if($adjudicacion->proveedores_adjudicado)
	        {
	            $proveedores = json_decode($adjudicacion->proveedores_adjudicado)->proveedores;
	        }
	        else{
	            $proveedores = Proveedor::rfcProveedor();
	            $proveedores = $this->proveedoresEdit($proveedores);
	        }
	        $countAnexos = AnexosAdjudicacion::where('adjudicacion_directa_id',$adjudicacion->id)->count();

	        $data = ['adjudicacion' => $adjudicacion, 'proveedores' => $proveedores, 'countAnexos' => $countAnexos, 'carpeta' => $carpeta];
	    }

	    return $data;
	}

	public function invitacionRestringida($id){

		$data = null;
        $invitacion = InvitacionRestringida::where('expediente_id',$id)->get();
		if($invitacion->isEmpty() == false){
			$invitacion = $invitacion[0];
	        $invitacion = $this->hashEncode($invitacion);
	        $carpeta = "invitacion-restringida-".$invitacion->id;

	        $proveedoresInvitados = json_decode($invitacion->proveedores_invitados)->proveedores;
	        $proveedoresParticiparon = $invitacion->proveedores_participaron != NULL ? json_decode($invitacion->proveedores_participaron)->proveedores : $this->proveedoresSeleccionadosObjeto(json_decode($invitacion->proveedores_invitados)->proveedores);
	        $proveedoresPropuesta = $invitacion->proveedores_propuesta != NULL ? json_decode($invitacion->proveedores_propuesta)->proveedores : ($invitacion->numero_proveedores_participaron > 0 ? $this->proveedoresSeleccionadosObjeto(json_decode($invitacion->proveedores_participaron)->proveedores) : []);
	        $proveedoresDescalificados = $invitacion->proveedores_descalificados != NULL ? json_decode($invitacion->proveedores_descalificados)->proveedores : [];
	        $proveedoresAprobados = $invitacion->proveedores_aprobados != NULL ? json_decode($invitacion->proveedores_aprobados)->proveedores : ( $invitacion->numero_proveedores_descalificados > 0 ? $this->proveedoresCalificadosObjeto(json_decode($invitacion->proveedores_descalificados)->proveedores) : []);
	        $proveedoresAdjudicados = $invitacion->proveedores_adjudicados != NULL ? json_decode($invitacion->proveedores_adjudicados)->proveedores : [];
	        $countAnexos = AnexosRestringida::where('invitacion_restringida_id',$invitacion->id)->count();
	        $data = ['invitacion' => $invitacion, 'proveedoresInvitados' => $proveedoresInvitados, 'proveedoresParticiparon' => $proveedoresParticiparon, 'proveedoresPropuesta' => $proveedoresPropuesta, 'proveedoresDescalificados' => $proveedoresDescalificados, 'proveedoresAprobados' => $proveedoresAprobados, 'proveedoresAdjudicados' => $proveedoresAdjudicados, 'carpeta' => $carpeta, 'countAnexos' => $countAnexos];
	    }
	    
        return $data;

	}

	public function licitacionPublica($id){
		$data = null;
		$licitacion = LicitacionPublica::where('expediente_id',$id)->get();
		if($licitacion->isEmpty() == false){
			$licitacion = $licitacion[0];
	        $licitacion = $this->hashEncode($licitacion);
	        $carpeta = "licitacion-publica-".$licitacion->id;
	        $proveedores = Proveedor::rfcProveedor();

	        $proveedoresBase = $licitacion->proveedores_base != NULL ? json_decode($licitacion->proveedores_base)->proveedores : $this->proveedoresEdit($proveedores);
	        $proveedoresPropuesta = $licitacion->proveedores_propuesta != NULL ? json_decode($licitacion->proveedores_propuesta)->proveedores : ($licitacion->proveedores_base != NULL ? $this->proveedoresSeleccionadosObjeto(json_decode($licitacion->proveedores_base)->proveedores) : []);
	        $proveedoresDescalificado = $licitacion->proveedores_descalificados != NULL ? json_decode($licitacion->proveedores_descalificados)->proveedores : []; 
	        $proveedoresAprobados = $licitacion->proveedores_aprobados != NULL ? json_decode($licitacion->proveedores_aprobados)->proveedores : ($licitacion->proveedores_descalificados != NULL ? $this->proveedoresCalificadosObjeto(json_decode($licitacion->proveedores_descalificados)->proveedores) : []);
	        $proveedoresAdjudicados = $licitacion->proveedores_adjudicados != NULL ? json_decode($licitacion->proveedores_adjudicados)->proveedores : [];
	        $countAnexos = AnexosPublica::where('licitacion_publica_id',$licitacion->id)->count(); 


	        $data = ['licitacion' => $licitacion, 'carpeta' => $carpeta, 'proveedoresBase' => $proveedoresBase, 'proveedoresPropuesta' => $proveedoresPropuesta, 'proveedoresDescalificado' => $proveedoresDescalificado, 'proveedoresAprobados' => $proveedoresAprobados, 'proveedoresAdjudicados' => $proveedoresAdjudicados, 'countAnexos' => $countAnexos];
    	}

    	return $data;
	}

	public function porcentaje($porcentaje,$expediente_id){
        $expediente = ExpedienteContratoMarco::find($expediente_id);
        $expediente->porcentaje += $porcentaje;
        $expediente->update();
    }
	
	
}

