<?php

namespace App\Http\Controllers;

use App\Models\BienServicio;
use App\Models\HabilitarProducto;
use App\Traits\HashIdTrait;
use App\Traits\ServicesTrait;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class BienServicioController extends Controller
{
    use HashIdTrait, ServicesTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BienServicio  $bienServicio
     * @return \Illuminate\Http\Response
     */
    public function show(BienServicio $bienServicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BienServicio  $bienServicio
     * @return \Illuminate\Http\Response
     */
    public function edit(BienServicio $bienServicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BienServicio  $bienServicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $cont = count($request->ids);
            $producto = 0;
            foreach($request->ids as $key => $id){
                $id = $this->hashDecode($id);

                $bien = BienServicio::find($id);
                $pmr = HabilitarProducto::pmr($bien->cabms);
                if($pmr){
                    $bien->cotizado = true;
                    $bien->precio_maximo = $pmr[0]->precio_maximo;
                    $bien->update();
                    $cont--;
                    $producto++;
                }
                $response = ['success' => true, 'message' => $producto.' Bien cotizado satisfactoriamente. '. $cont.' Bien no cotizados', 'data' => $producto];
            }
            if($cont == count($request->ids)){
                $response = ['success' => false, 'message' => 'Catalogo no encontrado.'];    
            }
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error al cotizar el bien.']; 
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BienServicio  $bienServicio
     * @return \Illuminate\Http\Response
     */
    public function destroy(BienServicio $bienServicio)
    {
        //
    }

    public function data($id){
        $id = $this->hashDecode($id);

        $bienes = $this->hashEncode(BienServicio::where('requisicion_id',$id)->get());
        foreach($bienes as $key => $value){ 
            $partida = substr($value->cabms,0,4);
            $bienes[$key]->descripcion = $this->cabmsDescripcion($partida,$value->cabms);
            $bienes[$key]->precio_maximo = number_format($value->precio_maximo, 2);
            $bienes[$key]->subtotal = number_format($value->precio_maximo * $value->cantidad, 2);
            $bienes[$key]->iva = number_format(($value->precio_maximo * $value->cantidad) *.16, 2);
            $bienes[$key]->total = number_format((($value->precio_maximo * $value->cantidad) *.16) + ($value->precio_maximo * $value->cantidad), 2);
        }
        return Datatables::of($bienes)->toJson();
    }
}
