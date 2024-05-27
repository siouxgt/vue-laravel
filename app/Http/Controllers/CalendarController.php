<?php

namespace App\Http\Controllers;
use App\Traits\HashIdTrait;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    use HashIdTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.catalogos.proveedor.index');
        // aqui debe de ir la vista donde vas a menter el html
        
    }

}
