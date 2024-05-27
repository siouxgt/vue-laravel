<?php

namespace App\Http\Controllers;

use App\Traits\ServicesTrait;

class ServiceController extends Controller
{
	use ServicesTrait;

	public function capitulos($capitulo)
    {
        return $this->capitulo($capitulo);
    }

    public function partidas($partida){

    	return $this->partida($partida);

    }

    public function claveCabms($partida, $cabms){

        return $this->cabms($partida,$cabms);

    }

    public function convocatorias($convocatoria){
        return $this->convocatoria($convocatoria);
    }

    public function almacen($ccg){
        return $this->almacenes($ccg);
    }

    public function allAlmacen(){
        return $this->allAlmacenes();
    }

    public function proveedor($rfc){
        return $this->proveedores($rfc);
    }

    public function accesoUnico($ccg){
        return  $this->personalAccesoUrg($ccg);
    }

    public function personalAcceso($rfc){
        return $this->personal($rfc); 
    }

    public function responsableAlmacen($ccg){
        return $this->responsablesAlmacen($ccg);
    }

    public function datosProveedorContrato($rfc){
        return $this->contratoPedido($rfc);
    }

    public function reqisiciones($ccg){
        return $this->requisicion($ccg);
    }
}