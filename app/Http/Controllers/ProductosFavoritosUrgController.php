<?php

namespace App\Http\Controllers;

use App\Models\ProductoFavoritoUrg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\HashIdTrait;


class ProductosFavoritosUrgController extends Controller
{

    use HashIdTrait;

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
        $validator = Validator::make($request->all(), [
            'pfp_id' => 'required',
            'id_favorito' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->getMessageBag()
            ]);
        } else {
            //dd("Accion", $request->input('accion'));
            if ($request->input('id_favorito') == 0) {
                $pfu  = new ProductoFavoritoUrg();
                $pfu->proveedor_ficha_producto_id = $this->hashDecode($request->input('pfp_id'));
                $pfu->urg_id = auth()->user()->urg_id;
                $pfu->save();

                return response()->json([
                    'status' => 200,
                    'id_favorito' =>  $pfu->id,
                    'message' => 'Producto agregado a tus favoritos.',
                ]);
            } else {
                return $this->destroy($request->input('id_favorito'));
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd("Si elimina ", $id);
        try {
            $pfp = ProductoFavoritoUrg::find($id);
            //dd($pfp);
            $pfp->delete();
            return response()->json([
                'status' => 200,
                'message' => "Producto quitado de tus favoritos."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => "No se pudo alcanzar el objetivo: " . $e
            ]);
        }
    }
}
