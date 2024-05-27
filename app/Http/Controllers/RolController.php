<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function roles(){
        $roles = Rol::select('id','rol')->get();
        if($roles->isNotEmpty()){
            $response = ['status' => 'success', 'code' => 200, 'data' => $roles];
        }
        else {
            $response = ['status' => 'success', 'code' => 200, 'data' => 'Sin roles'];
        }

        return $response;
    }
}
