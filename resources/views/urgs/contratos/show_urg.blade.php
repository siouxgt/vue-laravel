@extends('layouts.urg')
    @section('content')

        <div class="row">
            <div class="col-12 col-lg-6">
                <h1 class="m-2 p-3">Contrato Marco - {{ $contrato->nombre_cm }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb"> 
                        <li class="breadcrumb-item"><a href="{{ route('tienda_urg.index') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('contrato_urg.index_urg') }}">Contratos Marco</a></li>
                         <li class="breadcrumb-item active">Vista</li>
                    </ol>
                </nav>
            </div>
            <div class="separator"></div>
        </div>
        <div class="container mt-5" id="container">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                        <h4 class="text-activo">Datos generales</h4>
                    </button>
                    <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                        <h4 class="inactivo text-1">Anexos</h4>
                    </button>
                </div>
            </nav>

            <div class="tab-content border" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="hr">
                        <h6 class="mx-3 titl-1">Contrato Marco</h6>
                    </div>

                    <div class="form-group m-3">
                        <div class="row mz-2">
                            <div class="col-12 col-md-3 mz-2">
                                <label class="text-1">ID: </label>
                                <span class="text-1">{{ $contrato->id }} </span>
                            </div>
                            <div class="form-group text-1 col-12 col-md-3">
                                <label class="text-1">Fecha creación: </label>
                                <span class="text-1"> {{ $contrato->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="col-md-4">
                                <p class="text-1">Imagen</p>
                                @if($contrato->imagen)
                                    <img src="{{ asset('storage/img-contrato/'.$contrato->imagen)}}" class="imagen-100">
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-4 mz-2 text-1">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="gold" >Número de contrato: </label>
                                        <span class="text-1">{{ $contrato->numero_cm }} </span>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-4 mz-2">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="gold">Nombre del contrato: </label>
                                        <span class="text-1">{{ $contrato->nombre_cm }}</span>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                         <div class="row">
                            <div class="col-12 col-md-4 mz-2">
                                <label class="text-1">Fecha inicio: </label>
                                <span class="text-1">{{ $contrato->f_inicio->format('d/m/Y') }}</span>
                            </div>
                            <div class="col-12 col-md-4 mz-2">
                                <label class="text-1">Fecha fin: </label>
                                <span class="text-1">{{ $contrato->f_fin->format('d/m/Y') }}</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-12">
                                <label class="text-1">Objeto del contrato:</label>
                                <div class="form-group">
                                    <p class="text-1">{{ $contrato->objetivo }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hr">
                        <h6 class="mx-3 titl-1">Responsables</h6>
                        <p class="mx-3">Entidad y Persona responsable del “Contrato Marco”.</p>
                    </div>

                    @php $varSeleccionado; @endphp
                    <div class="form-row mx-3">
                        @php
                            $tipoUrg = ["Dependencia","Órgano desconsentrado","Administración paraestatal","Alcaldía","Organismo autónomo"]; 
                        @endphp
                        <div class="form-group col-12 col-md-6">
                            <label class="text-1">Entidad administradora:</label>
                            <p class="text-1"> {{ $tipoUrg[$contrato->urg->tipo-1]. " - " . $contrato->urg->nombre}}</p>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <div class="form-group">
                                <label class="text-1">Domicilio de la entidad administradora</label>
                                <p class="text-1"> {{ $contrato->urg->direccion }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-row mx-3">
                        <div class="form-group col-12 col-md-6">
                            <label class="text-1">Responsable:</label>
                            <p class="text-1"> {{ $contrato->user->nombre ." ". $contrato->user->primer_apellido ." ". $contrato->user->segundo_apellido }}</p>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label class="text-1">Cargo:</label>
                            <p class="text-1">{{ $contrato->user->cargo }}</p>
                        </div>
                    </div>

                    <div class="hr">
                        <h6 class="mx-3 titl-1">Bienes / Servicios</h6>
                        <p class="mx-3">Capítulo y Partida de este Contrato Marco</p>
                    </div>

                    @php
                    // listado
                    $arr_capitulos = ['1000 SERVICIOS PERSONALES', '2000 MATERIALES Y SUMINISTROS','3000 SERVICIOS GENERALES', '4000 TRANSFERENCIAS, ASIGNACIONES, SUBSIDIOS Y OTRAS AYUDAS', '5000 BIENES MUEBLES, INMUEBLES E INTANGIBLES'];
                    @endphp
                    <div class="hr">
                        @foreach ($contrato->capitulo_partida as $cp)
                        <div class="form-row mx-3">
                            <div class="form-group col-12 col-md-6">
                                <label class="text-1">Capítulo:</label>
                                <p class="text-1">{{ $arr_capitulos[$cp->capitulo-1] }}</p>
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label class="text-1">Partida:</label>
                                <p class="text-1">{{ $cp->partida ." - ". $cp->descripcion }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <h6 class="mx-3 gold">¿Este Contrato Marco comprende bienes y/o servicios de lineamientos de compras verdes?</h6>
                    <div class="custom-control custom-switch mx-4">
                        <p class="text-1"> @if ($contrato->compras_verdes) Si @else No @endif</p>
                    </div>

                    <div class="form-row mx-3">
                        <div class="form-group col-12 col-md-6">
                            <h6 class="gold">Validación técnica de este Contrato Marco</h6>
                            <div class="custom-control custom-switch">
                                <p class="text-1">@if ($contrato->validacion_tecnica) Si @else No @endif </p>    
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label class="text-1">Dirección</label>
                            <ul>
                               @for($i=0; $i < count($contrato->validaciones_seleccionadas); $i++)
                                    @for($j=0; $j < count($validaciones); $j++)
                                        @if($contrato->validaciones_seleccionadas[$i]->id_val_sel == $validaciones[$j]->id)
                                            <li class="text-1">{{ $validaciones[$j]->direccion ." - ". $validaciones[$j]->siglas }}</li>
                                            @break
                                        @endif
                                    @endfor
                               @endfor 
                           </ul>
                           
                        </div>

                        <div class="form-group col-12 col-lg-12 col-md-6 mt-3 text-1">
                            @php
                            $sectoresEspecificos = ['mipymes' => 'MIPYMES', 'campesinos' => 'Campesinos', 'cooperativas' => 'Cooperativas', 'elpm' => 'Empresas lideradas por mujeres', 'sr' => 'Grupos rurales', 'proa' => 'Productor agricola', 'general' => 'General'];
                            //Indice
                            @endphp
                            <label for="sector"> Contrato Marco para sectores especifico</label>
                            <ul>
                                @for($i=0; $i < count($contrato->sector); $i++)
                                    <li class="text-1"> {{ $sectoresEspecificos[$contrato->sector[$i]->sector] }}</li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-profile" role="tabpanel">
                    <h6 class="titl-1">Documentos adjuntos</h6>
                    <br>
                    <input type="hidden" id="id_contrato_marco" name="id_contrato_marco" value="{{ $contrato->id_e }}">
                    <div class="container">
                        <table class="table justify-content-md-center" id="tabla_anexos_contrato">
                            <thead>
                                <tr>
                                    <th scope="col">Número</th>
                                    <th scope="col">Nombre del documento</th>
                                    <th scope="col" class="tab-cent">Público</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>


            </div>
        </div>  
        

    @endsection
    @section('js')
        @routes(['anexosContrato'])
        <script src="{{ asset('asset/js/vista_contrato.js') }}" type="text/javascript"></script>
    @endsection
