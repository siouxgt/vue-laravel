@extends('layouts.admin')

@section('content')
    <h1 class="m-2 guinda p-3"><strong>Productos</strong></h1>
    <input type="hidden" @if (session()->has('error')) value="{{ session('error') }}" @endif id="mensaje">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                <li class="breadcrumb-item">Catálogos</li>
                <li class="breadcrumb-item"><a href="{{ route('cat_producto.index') }}">Productos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editar</li>
            </ol>
        </nav>
    </div>
    <hr>
    <div class="container mt-3">
        <form action="{{ route('cat_producto.update', ['cat_producto' => $catProducto->id_e]) }}" method="POST"
            enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">

                <div class="col-sm-10">
                    <h2 class="fs-5 fw-bold dorado">Características generales del producto</h2>
                </div>
                <div class="col-sm-2 text-end">
                    <div class="form-check form-switch ">
                        <label class="form-check-label gris1 fw-bold" for="flexSwitchCheckReverse estatus">Ficha
                            Activa </label>
                        <input class="form-check-input ml-4" type="checkbox" id="flexSwitchCheckReverse estatus" value="1"
                            @if ($catProducto->estatus) checked @endif>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row align-items-end my-3">
                @php
                    $date = now();
                @endphp
                <div class="col-sm-12 col-md-4  gris1">
                    <div class="form-group">
                        <label for="" class="text-1">Número de ficha</label>
                        <input class="form-control gris1" type="text" name="numero_ficha" id="numero_ficha" value="{{ $catProducto->numero_ficha }}" readonly>
                        <input type="hidden" id="ultimo" value="{{ $catProducto->id }}">
                        <input type="hidden" id="fecha" value="{{ $date->format('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-sm-12 col-md-3  gris1">
                    <div class="form-group">
                        <label for="version" class="text-1">Versión</label>
                        <input class="form-control gris1" type="text" name="version" id="version" value="{{ number_format($catProducto->version, 1) }}" readonly>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3 gris1">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="nueva_version" name="nueva_version" value="1">
                        <label class="custom-control-label ml-lg-3" for="nueva_version">Nueva versión</label>
                    </div>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-12 col-md-6 mz-2 gris1">
                    <div class="form-group">
                        <label for="capitulo" class="text-1 mx-3">Capítulo</label>
                        @if ($enUso[0]->count)
                            <input type="text" class="text-1 form-control" readonly name="capitulo" value="{{ $catProducto->capitulo }}">
                        @else
                            <select class="form-control gris1" id="capitulo" name="capitulo" required>
                                {{-- <option value="{{ $catProducto->capitulo }}">{{ $catProducto->capitulo }}</option> --}}
                                <option value="2000 - MATERIALES Y SUMINISTROS" data="2"
                                    {{ $catProducto->capitulo == '2000 - MATERIALES Y SUMINISTROS' ? 'selected' : '' }}>2000
                                    - MATERIALES Y SUMINISTROS</option>
                                <option value="3000 - SERVICIOS GENERALES" data="3"
                                    {{ $catProducto->capitulo == '3000 - SERVICIOS GENERALES' ? 'selected' : '' }}>3000 -
                                    SERVICIOS GENERALES</option>
                                <option value="4000 - TRASFERENCIAS, ASIGNACIONES, SUBSIDIOS Y OTRAS AYUDAS" data="4"
                                    {{ $catProducto->capitulo == '4000 - TRASFERENCIAS, ASIGNACIONES, SUBSIDIOS Y OTRAS AYUDAS' ? 'selected' : '' }}>
                                    4000 - TRASFERENCIAS, ASIGNACIONES, SUBSIDIOS Y OTRAS AYUDAS</option>
                                <option value="5000 - BIENES MUEBLES, INMUEBLES E INTANGIBLES" data="5"
                                    {{ $catProducto->capitulo == '5000 - BIENES MUEBLES, INMUEBLES E INTANGIBLES' ? 'selected' : '' }}>
                                    5000 - BIENES MUEBLES, INMUEBLES E INTANGIBLES</option>
                            </select>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-6 mz-2">
                    <div class="form-group">
                        <label for="partida" class="text-1 mx-3">Partida</label>
                        @if ($enUso[0]->count)
                            <input type="text" class="text-1 form-control" readonly name="partida" value="{{ $catProducto->partida }}">
                        @else
                            <select class="form-control text-1" id="partida" name="partida" required>
                                <option value="{{ $catProducto->partida }}">{{ $catProducto->partida }}</option>
                            </select>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="cabms" class="text-1 mx-3">Clave CABMS</label>
                        @if ($enUso[0]->count)
                            <input type="text" class="text-1 form-control" readonly name="cabms" value="{{ $catProducto->cabms }}">
                        @else
                            <select class="form-control" id="cabms" name="cabms" required>
                                <option value="{{ $catProducto->cabms }}">{{ $catProducto->cabms }}</option>
                            </select>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-9">
                    <div class="form-group">
                        <label for="descripcion" class="text-1">Descripción de la clave CABMS</label>
                        <input class="form-control text-1" type="text" id="descripcion" name="descripcion" value="{{ $catProducto->descripcion }}" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="form-group">
                        <label for="nombre_corto" class="text-1 mx-3">Nombre del Producto</label>
                        <input class="form-control text-1" id="nombre_corto" name="nombre_corto" value="{{ $catProducto->nombre_corto }}" required>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="contrato" class="text-1 mx-3">Número de Contrato Marco</label>
                        @if ($enUso[0]->count)
                            <input type="text" class="text-1 form-control" readonly value="{{ $catProducto->contratoMarco->numero_cm }}">
                            <input type="hidden" class="text-1 form-control" readonly name="contrato"
                                value="{{ $catProducto->contrato_m_id }}">
                        @else
                            <select class="form-control text-1" id="contrato" name="contrato" required>
                                <option value="{{ $catProducto->contratoMarco->id_e }}">
                                    {{ $catProducto->contratoMarco->numero_cm }}</option>
                                @foreach ($contratos as $contrato)
                                    <option value="{{ $contrato->id }}" data="{{ $contrato->nombre_cm }}">
                                        {{ $contrato->numero_cm }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group text-1">
                        <label for="contrato_nombre" class="text-1 mx-3">Nombre del contrato</label>
                        <input class="form-control text-1" type="text" id="contrato_nombre" value="{{ $catProducto->contratoMarco->nombre_cm }}"readonly>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row y-3">
                <div class="col-12 col-md-12">

                    <label for="especificaciones" class="text-1 mx-3">Especificaciones</label>
                    <textarea class="form-control text-1" id="especificaciones" rows="3" name="especificaciones" required>{{ $catProducto->especificaciones }}</textarea>

                </div>
                <div class="col-12 col-md-4 mt-3">

                    <label for="medida" class="text-1 mx-3">Unidad de medida</label>
                    <select class="form-select text-1" id="medida" name="medida" required>
                        <option value="{{ $catProducto->medida }}">{{ $catProducto->medida }}</option>
                        <option value="">Selecciones una opción</option>
                        <option value="arrendamiento">Arrendamiento</option>
                        <option value="bolsa">Bolsa</option>
                        <option value="bote">Bote</option>
                        <option value="bulto">Bulto</option>
                        <option value="caja">Caja</option>
                        <option value="carga">Carga</option>
                        <option value="carrete">Carrete</option>
                        <option value="cartucho">Cartucho</option>
                        <option value="conjunto">Conjunto</option>
                        <option value="día">Día</option>
                        <option value="envase">Envase</option>
                        <option value="equipo">Equipo</option>
                        <option value="estuche">Estuche</option>
                        <option value="frasco">Frasco</option>
                        <option value="galon">Galon</option>
                        <option value="hojas">Hojas</option>
                        <option value="juego">Juego</option>
                        <option value="kg">Kg</option>
                        <option value="kit">Kit</option>
                        <option value="lata">Lata</option>
                        <option value="libro">Libro</option>
                        <option value="licencia">Licencia</option>
                        <option value="litro">Litro</option>
                        <option value="lote">Lote</option>
                        <option value="metro">Metro</option>
                        <option value="millar">Millar</option>
                        <option value="MT2">MT2</option>
                        <option value="MT3">MT3</option>
                        <option value="paca">Paca</option>
                        <option value="paquete">Paquete</option>
                        <option value="par">Par</option>
                        <option value="pieza">Pieza</option>
                        <option value="por persona">Por persona</option>
                        <option value="porrón">Porrón</option>
                        <option value="rollo">Rollo</option>
                        <option value="servicio">Servicio</option>
                        <option value="tambo">Tambo</option>
                        <option value="tonelada">Tonelada</option>
                        <option value="tramo">Tramo</option>
                        <option value="tubo">Tubo</option>
                        <option value="unidad">Unidad</option>
                        <option value="vial">Vial</option>
                    </select>

                </div>
            </div>
            <hr>
            <div class="row align-items-end mz-3">
                <div class="col-sm-12 col-md-4">
                    <div class="form-group switch-leaft">
                        <label for="validacion_tecnica" class="text-1 mx-3">Validación técnica</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="validacion_tecnica" name="validacion_tecnica" value="1" @if ($catProducto->validacion_id) checked @endif>
                          </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-end my-3">
                <div class="col-12 col-md-4 text-1">
                    <label for="tipo_prueba">
                        Tipo de prueba requerida
                    </label>
                    <input type="text" class="form-control text-1" id="tipo_prueba" name="tipo_prueba" value="{{ $catProducto->tipo_prueba }}" disabled>
                </div>
                <div class="col-12 col-md-4">
                    <label for="equipo_validacion" class="text-1 mx-3">Equipo para validación técnica</label>
                    <select class="form-select text-1" id="equipo_validacion" name="equipo_validacion" disabled>
                        <option value="">Seleccione una opción</option>
                        @foreach ($validaciones as $validacion)
                            <option value="{{ $validacion->id }}" @if ($catProducto->validacion_id == $validacion->id) selected @endif>
                                {{ $validacion->siglas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12 col-md-6 mz-2">
                    <div class="form-group">
                        <label for="archivo_ficha_tecnica" class="text-1 mx-3">Ficha técnica (Machote)</label>
                        <input type="file" class="form-control text-1" id="archivo_ficha_tecnica" accept=".doc,.docx" name=" archivo_ficha_tecnica">
                        <label class="text-1 mt-3 mx-3">Archivo actual:</label> <a href="{{ asset('storage/cat-producto/' . $catProducto->archivo_ficha_tecnica) }}" target="_blank" class="text-1">{{ $catProducto->archivo_ficha_tecnica }}</a>
                    </div>
                </div>
            </div>
            <div class="row modal-footer text-end">
                <div class="col-md-2 col-sm-12">
                    <button type="submit" class="btn btn-white boton-1 btn-block">Actualizar</button>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('js')
    @routes(['catProducto', 'service'])
    <script src="{{ asset('asset/js/cat_producto.js') }}" type="text/javascript"></script>
@endsection
