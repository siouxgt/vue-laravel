@extends('layouts.admin')

@section('content')

<h1 class="m-2 guinda fw-bold p-3">Unidades Responsables de Gasto (URG)</h1>
<div class="row">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item"><a href="#">Catálogos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Unidades Responsables de Gasto (URG)</li>
        </ol>
    </nav>
</div>    

<div class="container-fluid mt-4">
    <div class="row">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item reg " role="presentation">
                <button class="nav-link gris1" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
                    <a href="javascript: void(0);" onclick="history.back()" class="back text-decoration-none dorado">
                        <span>Regresar</span>
                    </a>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-decoration-none @if(!$el_estatus) active @endif hoverTab " id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                    <span class="text-1">Catálogo</span>
                </button>
            </li>
            <li class="nav-item text-decoration-none gris1" role="presentation">
                <button class="nav-link   @if($el_estatus) active @endif hoverTab" id="other-tab" data-bs-toggle="tab" data-bs-target="#messages" type="button" role="tab" aria-controls="messages" aria-selected="false">
                    <span class="text-1">Términos específicos</span></button>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane" id="home" role="tabpanel" aria-labelledby="home-tab"></div>
            <div class="tab-pane @if(!$el_estatus) active @endif" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div style="overflow-x: auto;" class="px-5 pt-4 mx-2">
                                <table>
                                    <tr>
                                        <th class="derecha">
                                            <strong>Clave</strong>
                                        </th>
                                        <td class="izquierda">
                                            {{ $urg->ccg }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="derecha">
                                            <strong>URG</strong>
                                        </th>
                                        <td class="izquierda">
                                            {{ $urg->nombre }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="derecha">
                                            <strong>Tipo URG</strong>
                                        </th>
                                        <td class="izquierda">
                                            {{ $urg->tipo }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="derecha">
                                            <strong>Dirección URG</strong>
                                        </th>
                                        <td class="izquierda">
                                            {{ $urg->direccion }}
                                        </td>
                                    </tr>
                                    <tr class="mb-5">
                                        <th class="derecha">
                                            <strong>Estatus</strong>
                                        </th>
                                        <td class="izquierda">
                                            @if( $urg->estatus ) Activo @else Inactivo @endif
                                        </td>
                                    </tr>
                                </table>
                                <hr>
                                <table>                                    
                                    @foreach( $responsables as $key => $responsable)
                                        <tr>
                                            <th class="derecha">
                                                <strong>Responsable URG</strong>
                                            </th>
                                            <td class="izquierda">
                                                {{ $responsable->nombre }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="derecha">
                                                <strong>Cargo</strong>
                                            </th>
                                            <td class="izquierda">
                                                {{ $responsable->cargo }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="derecha">
                                                <strong>Permisos</strong>
                                            </th>
                                            <td class="izquierda">
                                                {{ $responsable->rol }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                </table> 
                                <hr>
                                <table>
                                    <tr>
                                        <th class="derecha">
                                            <strong>Fecha de Adhesión</strong>
                                        </th>
                                        <td class="izquierda">
                                            {{ date('d-m-Y', strtotime($urg->fecha_adhesion)) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="derecha">
                                            <strong>Acuerdo Adhesión</strong>
                                        </th>
                                        <td class="izquierda">
                                            <a class="btn btn-cdmx dorado" target="_blank" href=" {{ route('urg.show', $urg->id . ' ' ) }} "><i class="fa-solid fa-lg fa-file-pdf"></i></a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane @if($el_estatus) active @endif" id="messages" role="tabpanel" aria-labelledby="messages">
                <div class="container fluid justify-content-center ">

                    @if(count($cmu)>0)
                    @for($i = 0; $i < count($cmu); $i++) <!---->
                        <div class="row">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading col-4" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            @if($i == 0)
                                            <a role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$i}}" aria-expanded="true" aria-controls="collapseOne">
                                                @else
                                                <a role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$i}}" aria-expanded="false" aria-controls="collapseOne">
                                                    @endif
                                                    {{strtoupper($cmu[$i]->nombre_cm)}}
                                                </a>
                                        </h4>
                                    </div>
                                    <div class="panel-collapse collapse @if($i == 0) show @endif" id="collapseOne{{$i}}" role="tabpanel" aria-labelledby="headingOne">
                                        <table>
                                            <tr>
                                                <th class="derecha">
                                                    <strong>Clave</strong>
                                                </th>
                                                <td class="izquierda">
                                                    {{$cmu[$i]->ccg}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="derecha">
                                                    <strong>URG</strong>
                                                </th>
                                                <td class="izquierda">
                                                    {{$cmu[$i]->nombre}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="derecha">
                                                    <strong>Fecha de firma</strong>
                                                </th>
                                                <td class="izquierda">
                                                    {{ date('d-m-Y', strtotime($cmu[$i]->fecha_firma)) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="derecha">
                                                    <strong>Términos específicos</strong>
                                                </th>
                                                <td class="izquierda">
                                                    <a class="btn btn-cdmx" target="_blank" href=" {{ route('cm_urg.ver_archivo', $cmu[$i]->a_terminos_especificos) }} "><i class="fa-solid fa-lg fa-file-pdf"></i></a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endfor

                        @endif
                </div>
                <!-- </article> -->
            </div>
        </div>
    </div>
</div>
@endsection