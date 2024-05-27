<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait ServicesTrait
{

    public function capitulo($capitulo)
    {
        $response = Http::get("https://aplicaciones.finanzas.cdmx.gob.mx/almaceneseinventarioscdmx/public/api/par_pre/" . $capitulo . "/1");
        $data = [];
        if($response->status() == 200 and !is_null(json_decode($response->body()))){
            foreach (json_decode($response->body()) as $key => $value) {
                $data[$key]['partida'] = $value->par_pre . " - " . $value->descripcion;
                $data[$key]['value'] = $value->par_pre;
            }

            $response = array('success' => true, 'data' => $data);
        } else {
            $response = array('success' => false, 'message' => "No se puede establecer conexión con el servidor.");
        }

        return $response;
    }

    public function partida($partida)
    {
        $response = Http::get("https://aplicaciones.finanzas.cdmx.gob.mx/almaceneseinventarioscdmx/public/api/cabms/" . $partida . "/1");
        $data = [];
        if($response->status() == 200 and !is_null(json_decode($response->body()))){
            foreach (json_decode($response->body()) as $key => $value) {
                $data[$key]['cabms'] = $value->cabms;
                $data[$key]['descripcion'] = $value->descripcion;
            }
            $response = array('success' => true, 'data' => $data);
        } else {
            $response = array('success' => false, 'message' => "Error al obtener la informacion.");
        }

        return $response;
    }

    public function cabms($partida, $cabms)
    {
        $response = Http::get("https://aplicaciones.finanzas.cdmx.gob.mx/almaceneseinventarioscdmx/public/api/cabms/" . $partida . "/1");
        $data = [];
        if($response->status() == 200 and !is_null(json_decode($response->body()))){
            foreach (json_decode($response->body()) as $key => $value) {
                if ($cabms == $value->cabms) {
                    $data[0]['descripcion'] = $value->descripcion;
                }
            }
            $response = array('success' => true, 'data' => $data);
        } else {
            $response = array('success' => false, 'message' => "Error al obtener la informacion.");
        }

        return $response;
    }

    public function cabmsDescripcion($partida, $cabms)
    {
        $response = Http::get("https://aplicaciones.finanzas.cdmx.gob.mx/almaceneseinventarioscdmx/public/api/cabms/" . $partida . "/1");
        $descripcion = "";
        if($response->status() == 200 and !is_null(json_decode($response->body()))){
            foreach (json_decode($response->body()) as $key => $value) {
                if ($cabms == $value->cabms) {
                    $data = $value->descripcion;
                }
            }
        }
        return $data;
    }

    public function convocatoria($convocatoria)
    {

        $response = Http::get('https://dev.finanzas.cdmx.gob.mx/requisiciones/public/api/convocatorias/' . $convocatoria . '?token=eadd7f144afa84');

        if ($response->status() == 200 && json_decode($response->body())->message != "Error: sin resultados") {
            $response = array('success' => true, 'data' => $response->body());
        } else {
            $response = array('success' => false, 'message' => "El número de convocatorias no existe en el sistema de requisiciones.");
        }

        return $response;
    }

    public function almacenes($ccg)
    {
        $response = Http::get("https://aplicaciones.finanzas.cdmx.gob.mx/almaceneseinventarioscdmx/public/api/domicilios_urgs?token=eadd7f144afa84");
        if($response->status() == 200 and !is_null(json_decode($response->body()))){
           $data = json_decode($response->body())->data;
           $cont = [];
           $elurg = '';

           $contador = 0;
           foreach ($data as $value) {
                if ($value->centro_gestor == strtoupper($ccg)) { 
                    $cont[$contador] = $value->calle . ", " . $value->colonia . ", " . $value->alcaldia . ", " . $value->cp . ", " . $value->ciudad;
                    $elurg = $value->unidad_admva;
                    $contador++;
                }
            }
            if($cont != []){
                    
                $response = array("success" => true, "direcciones" => array_unique($cont),"elurg" => $elurg);
            } else {
                $response = array("success" => false, 'message' => 'Error centro gestor no registrado.');
            }

        }
        else {
            $response = array("success" => false, 'message' => 'No se puede establecer conexión con el servidor.');
        }
          
        return $response;
    }

    public function allAlmacenes()
    {
        $response = Http::get("https://aplicaciones.finanzas.cdmx.gob.mx/almaceneseinventarioscdmx/public/api/domicilios_urgs?token=eadd7f144afa84");

        if($response->status() == 200 and !is_null(json_decode($response->body()))){

           $data = json_decode($response->body())->data;
           $cont = [];

           foreach ($data as $key => $value) {
                $cont[$key] = $value->calle . ", " . $value->colonia . ", " . $value->alcaldia . ", " . $value->cp . ", " . $value->ciudad;
           }
           if($cont != []){
                
                $response = array("success" => true, "direcciones" => array_unique($cont));
           } else {
                $response = array("success" => false, 'message' => 'Error almacenes no encontrados.');
           }
        }
        else {
            $response = array("success" => false, 'message' => 'No se puede establecer conexión con el servidor.');
        }

        return $response;
    }

    public function proveedores($rfc)
    {
        $data = [
            "token" => "DK3TBCRNGWGKB7FRNKQT",
            "data" =>
            [
                "RFC" => $rfc,
            ]
        ];
        $proveedor = Http::post("http://10.1.181.9:9017/Proveedores/getDataPerfil/", $data);
        $proveedor2 = Http::get("https://tianguisdigital.finanzas.cdmx.gob.mx/api/getDataPerfil/" . $rfc);
        $proveedor3 = Http::get("https://tianguisdigital.finanzas.cdmx.gob.mx/api/contratopedido");

        
                
        if ($proveedor->status() == 200 and json_decode($proveedor->body())->error->code == 0) {
            $response = array('success' => true, 'data' => $proveedor->body(),'data2' => json_encode([]));
            if($proveedor2->status() == 200 and json_decode($proveedor2->body()) == '"sin_perfil"'){
                $response['data2'] =  $proveedor2->body();
            }
            if($proveedor3->status() == 200){
                $respuesta = json_decode($proveedor3->body());
                $data3 = [];
                foreach($respuesta as $value){
                    if($value->rfc == $rfc){
                        $data3['rfc'] = $value->rfc;
                        $data3['acta_identidad'] = $value->acta_identidad;
                        $data3['fecha_constitucion_identidad'] = $value->fecha_constitucion_identidad;
                        $data3['titular_identidad'] = $value->titular_identidad;
                        $data3['num_notaria_identidad'] = $value->num_notaria_identidad;
                        $data3['entidad_identidad'] = $value->entidad_identidad;
                        $data3['num_reg_identidad'] = $value->num_reg_identidad;
                        $data3['fecha_reg_identidad'] = $value->fecha_reg_identidad;
                        $data3['num_instrumento_representante'] = $value->num_instrumento_representante;
                        $data3['titular_representante'] = $value->titular_representante;
                        $data3['num_notaria_representante'] = $value->num_notaria_representante;
                        $data3['entidad_representante'] = $value->entidad_representante;
                        $data3['num_reg_representante'] = $value->num_reg_representante;
                        $data3['fecha_reg_representante'] = $value->fecha_reg_representante;
                        $response['data3'] =  json_encode($data3);
                        break;
                    }
               }
            }
        } 
        elseif(json_decode($proveedor->body())->error->code == 1){
            $response = array('success' => false, 'message' => 'RFC no encontrado en el sistema de padron de proveedores.');
        }
        else {
            $response = ['success' => false, 'message' => 'Error al obtener el proveedor.'];
        }
        
        return $response;
    }

    public function personalAccesoUrg($ccg)
    {
          $response = Http::get('https://tics.finanzas.cdmx.gob.mx/accesounicotianguis/public/api/urg/'.$ccg);
          
          if($response->status() == 200){
               $response = array('success' => true, 'data' => $response->body());
          } else {
               $response = ['success' => false, 'message' => 'Error URG no registrada.'];
          }

          return $response;
    }

    public function personal($rfc){
          $response = Http::get('https://tics.finanzas.cdmx.gob.mx/accesounicotianguis/public/api/users/'.$rfc);

          if($response->status() == 200){
               $response = array('success' => true, 'data' => $response->body());
          } else {
               $response = ['success' => false, 'message' => 'Error personal no registrado.'];
          }

          return $response;
    }
	

    public function proveedoresLogin($rfc)
    {
        $response = Http::get("https://tianguisdigital.finanzas.cdmx.gob.mx/api/login/" . $rfc);
        if ($response->body() != "\"sin_usuario\"") {
            return json_decode($response->body());
        } else {
            return false;
        }
    }

    public function responsablesAlmacen($ccg){
        $response = Http::get("https://aplicaciones.finanzas.cdmx.gob.mx/almaceneseinventarioscdmx/public/api/domicilios_urgs?token=eadd7f144afa84");
          if($response->status() == 200){
               $data = json_decode($response->body())->data;
               $cont = [];

               foreach ($data as $key => $value) {
                    if($ccg == $value->centro_gestor){
                        $direccion = $value->calle . ", " . $value->colonia . ", " . $value->alcaldia . ", " . $value->cp . ", " . $value->ciudad;
                        $cont[$key] = ['direccion' => $direccion, 'responsable' => trim($value->responsable), 'telefono' => trim($value->telefono), 'puesto' => 'Responsable de almacen', 'tipo' => $value->tipo];
                    }
               }
               $response = array("success" => true, 'almacenes' => $cont);
               
          }
          else {
            $response = array("success" => false, 'message' => 'No se puede establecer conexión con el servidor.');
        }
          
        return $response;
    }

    public function contratoPedido($rfc){
        $response = Http::get("https://tianguisdigital.finanzas.cdmx.gob.mx/api/contratopedido");
        if($response->status() == 200){
            $data = json_decode($response->body());
            $response = [];
            foreach($data as $value){
                if($value->rfc == $rfc){
                    $response['rfc'] = $value->rfc;
                    $response['acta_identidad'] = $value->acta_identidad;
                    $response['fecha_constitucion_identidad'] = $value->fecha_constitucion_identidad;
                    $response['titular_identidad'] = $value->titular_identidad;
                    $response['num_notaria_identidad'] = $value->num_notaria_identidad;
                    $response['entidad_identidad'] = $value->entidad_identidad;
                    $response['num_reg_identidad'] = $value->num_reg_identidad;
                    $response['fecha_reg_identidad'] = $value->fecha_reg_identidad;
                    $response['tiene_representante'] = $value->tiene_representante;
                    $response['num_instrumento_representante'] = $value->num_instrumento_representante;
                    $response['titular_representante'] = $value->titular_representante;
                    $response['num_notaria_representante'] = $value->num_notaria_representante;
                    $response['entidad_representante'] = $value->entidad_representante;
                    $response['num_reg_representante'] = $value->num_reg_representante;
                    $response['fecha_reg_representante'] = $value->fecha_reg_representante;
                    break;
                }
           }
        }    

        return  $response;
    }

    public function efirma($cer,$key,$pass){
        $data = ["security" =>
                    [                
                        "tokenId" => "FPRUPRUEBA"
                    ],
                    "data" =>
                    [
                        "password" => $pass,
                        "cadena" => "||Nombramiento para",
                        "byteKey" => $key,
                        "bytecer" => $cer
                    ]
                ];

        $response = Http::post("10.1.181.24:9005/eFirma/firmaCadena/", $data);
        
        return $response = json_decode($response->body());
    }

    public function requisicion($ccg)
    {
        $response = Http::get('https://dev.finanzas.cdmx.gob.mx/requisiciones/public/api/CM_requisiciones/'.$ccg);

        return json_decode($response->body());
    }

}
