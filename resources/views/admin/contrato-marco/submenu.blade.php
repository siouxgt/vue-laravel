<h1 class="m-2 guinda p-3">Alta Contratos Marco</h1>
<div class="row">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('contrato.index') }}">Contratos Marco</a></li>
        </ol>
    </nav>
</div>    
<hr>
<div class="container-fluid">
    <div class="row">
        <h2 class="display-4 titulo-1 mb-2" id="punto-encuentro">{{ strtoupper(session()->get('nombreCm')) }}</h2>
    </div>
    <div class="row">
        <!-- Alta Contrato -->
        <article class="col-12 col-md-4 col-lg-2  mt-3 d-none d-sm-none d-md-block">
            <div>
                @if(Request::is('contrato/*') or Request::is('anexos_contrato'))
                <div class="cuadros bac-green rounded">
                    <div class="card-1" style="width:100%;">
                @else
                <div class="border shadow-sm">
                    <div class="card-2 " style="width:100%;">
                @endif
                        <ul class="list-group list-group-flush list-unstyled align-middle">
                            <li class="dorado text-center pt-4 border-bottom p-3"><strong>Alta Contrato</strong></li>

                            <li class="@if(Request::is('contrato/*') or Request::is('anexos_contrato')) list-group-item-1 @else list-group-item-2 @endif border-bottom">
                                <ul class="list-unstyled p-2">
                                    <li>Del <strong id="fecha_inicio_alta">@if($fechas->fecha_inicio_alta) {{ $fechas->fecha_inicio_alta->formatLocalized('%d %B %Y') }} @endif</strong><a href="javascript:void(0)" onclick="submenu_modal('alta','{{session('contrato')}}')" class="float-end"><i class="fa-solid fa-calendar-plus"></i></a></li>
                                    <li>Al <strong id="fecha_fin_alta">@if($fechas->fecha_fin_alta) {{ $fechas->fecha_fin_alta->formatLocalized('%d %B %Y') }} @endif </strong></li>
                                </ul>
                            </li>
                            <li class="@if(Request::is('contrato/*') or Request::is('anexos_contrato')) list-group-item-1 @else list-group-item-3 @endif iconosFut p-3 ">
                                <a href="{{ route('contrato.edit', ['contrato' => session()->get('contrato')]) }}" class="text-leaft"><i class="fa-solid fa-pen-to-square fa-lg" aria-hidden="true"></i></a>
                                <a href="javascript: void(0)" class="float-end"><i class="fa-solid fa-file-pdf fa-lg" aria-hidden="true"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <p class="@if(Request::is('contrato/*') or $fechas->alta ) indicador-count-card @else indicador-count-card-2 @endif  fa-solid fa-check text-center"></p>
                </div>
            </div>
        </article>
        <!-- Alta Contrato -->
        <!-- Grupo Revisor -->
        <article class="col-12 col-md-4 col-lg-2 mt-3">
            <div>
                @if(Request::is('grupo_revisor') or Request::is('grupo_revisor/*')) 
                <div class="bac-green rounded shadow-sm">
                    <div class="card-1" style="width:100%;">
                @else
                <div class="border shadow-sm">
                    <div class="card-2" style="width:100%;">
                @endif
                        <ul class="list-group list-group-flush list-unstyled align-middle">
                            <li class="dorado text-center pt-4 border-bottom p-3"><strong>Grupo Revisor</strong></li>

                            <li class="@if(Request::is('grupo_revisor') or Request::is('grupo_revisor/*')) list-group-item-1 @else list-group-item-2 @endif border-bottom">
                                <ul class="list-unstyled p-2">
                                     <li>Del <strong id="fecha_inicio_revisor">@if($fechas->fecha_inicio_revisor) {{ $fechas->fecha_inicio_revisor->formatLocalized('%d %B %Y') }} @endif</strong><a href="javascript: void(0)" onclick="submenu_modal('revisor','{{session('contrato')}}')" class="float-end"><i class="fa-solid fa-calendar-plus"></i></a></li>
                                    <li>Al <strong id="fecha_fin_revisor">@if($fechas->fecha_fin_revisor) {{ $fechas->fecha_fin_revisor->formatLocalized('%d %B %Y') }} @endif</strong></li>
                                </ul>
                            </li>
                            <li class="@if(Request::is('grupo_revisor') or Request::is('grupo_revisor/*')) list-group-item-1 @else list-group-item-3 @endif iconosFut p-3 ">
                                <a href="{{ route('grupo_revisor.index') }}" class="text-leaft"><i class="fa-solid fa-circle-plus fa-lg" aria-hidden="true"></i></a>
                                <a href="javascript: void(0)" class="float-end"><i class="fa-solid fa-file-pdf fa-lg" aria-hidden="true"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <p class="@if(Request::is('grupo_revisor') or Request::is('grupo_revisor/*') or $fechas->revisor) indicador-count-card @else indicador-count-card-2 @endif fa-solid fa-check text-center"></p>
                </div>
            </div>
        </article>
        <!-- Grupo Revisor -->
        <!-- Creación Expediente -->
        <article class="col-12 col-md-4 col-lg-2 mt-3">
            <div>
                @if(Request::is('expedientes_contrato') or Request::is('expedientes_contrato/*')) 
                <div class="bac-green rounded shadow-sm">
                    <div class="card-1 rounded" style="width:100%;">
                @else
                <div class="border shadow-sm">
                    <div class="card-2" style="width:100%;">
                @endif
                        <ul class="list-group list-group-flush list-unstyled align-middle">
                            <li class="dorado text-center pt-4 border-bottom p-3 text-truncate"><strong>Creación Expediente</strong></li>

                            <li class="@if(Request::is('expedientes_contrato') or Request::is('expedientes_contrato/*')) list-group-item-1 @else list-group-item-2 @endif border-bottom">
                                <ul class="list-unstyled p-2">
                                    <li>Del <strong id="fecha_inicio_expediente">@if($fechas->fecha_inicio_expediente) {{ $fechas->fecha_inicio_expediente->formatLocalized('%d %B %Y') }} @endif</strong><a href="javascript: void(0)" onclick="submenu_modal('expediente','{{session('contrato')}}')" class="float-end"><i class="fa-solid fa-calendar-plus"></i></a></li>
                                    <li>Al <strong id="fecha_fin_expediente">@if($fechas->fecha_fin_expediente) {{ $fechas->fecha_fin_expediente->formatLocalized('%d %B %Y') }} @endif</strong></li>
                                </ul>
                            </li>
                            <li class="@if(Request::is('expedientes_contrato') or Request::is('expedientes_contrato/*')) list-group-item-1 @else list-group-item-3 @endif iconosFut p-3 ">
                                <a href="{{ route('expedientes_contrato.index') }}" class="text-leaft"><i class="fa-solid fa-circle-plus fa-lg" aria-hidden="true"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <p class="@if(Request::is('expedientes_contrato') or Request::is('expedientes_contrato/*') or $fechas->expediente) indicador-count-card @else indicador-count-card-2 @endif fa-solid fa-check text-center"></p>
                </div>
            </div>
        </article>
        <!-- Creación Expediente -->
        <!-- Habilitar Proveedores -->
        <article class="col-12 col-md-4 col-lg-2 mt-3">
            <div>
                @if(Request::is('habilitar_proveedores') or Request::is('habilitar_proveedores/*')) 
                <div class="cuadros bac-green rounded">
                    <div class="card-1" style="width:100%;">
                @else
                <div class="border shadow-sm">
                    <div class="card-2" style="width:100%;">
                @endif
                        <ul class="list-group list-group-flush list-unstyled align-middle">
                            <li class="dorado text-center pt-4 border-bottom p-3 text-truncate"><strong>Habilitar Proveedores</strong></li>

                            <li class="@if(Request::is('habilitar_proveedores') or Request::is('habilitar_proveedores/*')) list-group-item-1 @else list-group-item-2 @endif border-bottom">
                                <ul class="list-unstyled p-2">
                                    <li>Del <strong id="fecha_inicio_proveedor">@if($fechas->fecha_inicio_proveedor) {{ $fechas->fecha_inicio_proveedor->formatLocalized('%d %B %Y') }} @endif</strong><a href="javascript: void(0)" onclick="submenu_modal('proveedor','{{session('contrato')}}')" class="float-end"><i class="fa-solid fa-calendar-plus"></i></a></li>
                                    <li>Al <strong id="fecha_fin_proveedor">@if($fechas->fecha_fin_proveedor) {{ $fechas->fecha_fin_proveedor->formatLocalized('%d %B %Y') }} @endif</strong></li>
                                </ul>
                            </li>
                            <li class="@if(Request::is('habilitar_proveedores') or Request::is('habilitar_proveedores/*')) list-group-item-1 @else list-group-item-3 @endif iconosFut p-3 ">
                                <a href="{{ route('habilitar_proveedores.index') }}" class="text-leaft"><i class="fa-solid fa-pen-to-square fa-lg" aria-hidden="true"></i></a>
                                <a href="javascript: void(0)" class="float-end"><i class="fa-solid fa-file-pdf fa-lg" aria-hidden="true"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <p class="@if(Request::is('habilitar_proveedores') or Request::is('habilitar_proveedores/*') or $fechas->proveedor) indicador-count-card @else indicador-count-card-2 @endif fa-solid fa-check text-center"></p>
                </div>
            </div>
        </article>
        <!-- Habilitar Proveedores -->
        <!-- Habilitar Productoso -->
        <article class="col-12 col-md-4 col-lg-2 mt-3">
            <div>
                @if(Request::is('habilitar_productos') or Request::is('habilitar_productos/*')) 
                <div class="cuadros bac-green rounded">
                    <div class="card-1" style="width:100%;">
                @else
                <div class="border shadow-sm">
                    <div class="card-2" style="width:100%;">
                @endif
                        <ul class="list-group list-group-flush list-unstyled align-middle">
                            <li class="dorado text-center pt-4 border-bottom p-3 text-truncate"><strong>Habilitar Productos</strong></li>

                            <li class="@if(Request::is('habilitar_productos') or Request::is('habilitar_productos/*')) list-group-item-1 @else list-group-item-2 @endif border-bottom">
                                <ul class="list-unstyled p-2">
                                    <li>Del <strong id="fecha_inicio_producto">@if($fechas->fecha_inicio_producto) {{ $fechas->fecha_inicio_producto->formatLocalized('%d %B %Y') }} @endif</strong><a href="javascript: void(0)" onclick="submenu_modal('producto','{{session('contrato')}}')" class="float-end"><i class="fa-solid fa-calendar-plus"></i></a></li>
                                    <li>Al <strong id="fecha_fin_producto">@if($fechas->fecha_fin_producto) {{ $fechas->fecha_fin_producto->formatLocalized('%d %B %Y') }} @endif</strong></li>
                                </ul>
                            </li>
                            <li class="@if(Request::is('habilitar_productos') or Request::is('habilitar_productos/*')) list-group-item-1 @else list-group-item-3 @endif iconosFut p-3 ">
                                <a href="{{ route('habilitar_productos.index') }}" class="text-leaft"><i class="fa-solid fa-pen-to-square fa-lg" aria-hidden="true"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <p class="@if(Request::is('habilitar_productos') or Request::is('habilitar_productos/*') or $fechas->producto) indicador-count-card @else indicador-count-card-2 @endif fa-solid fa-check text-center"></p>
                </div>
            </div>
        </article>
        <!--  Habilitar Productoso -->
        <!-- Habilitar URGs -->
        <article class="col-12 col-md-4 col-lg-2 mt-3">
            <div>
                @if(Request::is('cm_urg') or Request::is('cm_urg/*')) 
                <div class="cuadros bac-green rounded">
                    <div class="card-1" style="width:100%;">
                @else
                <div class="border shadow-sm">
                    <div class="card-2" style="width:100%;">
                @endif
                        <ul class="list-group list-group-flush list-unstyled align-middle">
                            <li class="dorado text-center pt-4 border-bottom p-3"><strong>Habilitar URGs</strong></li>

                            <li class="@if(Request::is('cm_urg') or Request::is('cm_urg/*')) list-group-item-1 @else list-group-item-2 @endif border-bottom">
                                <ul class="list-unstyled p-2">
                                    <li>Del <strong id="fecha_inicio_urg">@if($fechas->fecha_inicio_urg) {{ $fechas->fecha_inicio_urg->formatLocalized('%d %B %Y') }} @endif</strong><a href="javascript: void(0)" onclick="submenu_modal('urg','{{session('contrato')}}')" class="float-end"><i class="fa-solid fa-calendar-plus"></i></a></li>
                                    <li>Al <strong id="fecha_fin_urg">@if($fechas->fecha_fin_urg) {{ $fechas->fecha_fin_urg->formatLocalized('%d %B %Y') }} @endif</strong></li>
                                </ul>
                            </li>
                            <li class="@if(Request::is('cm_urg') or Request::is('cm_urg/*')) list-group-item-1 @else list-group-item-3 @endif iconosFut p-3 ">
                                <a href="{{ route('cm_urg.index') }}" class="text-leaft"><i class="fa-solid fa-circle-plus fa-lg" aria-hidden="true"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <p class="@if(Request::is('cm_urg') or Request::is('cm_urg/*') or $fechas->urg) indicador-count-card @else indicador-count-card-2 @endif fa-solid fa-check text-center"></p>
                </div>
            </div>
        </article>
        <!-- Alta Contrato -->
    </div>
</div>

@section('js3')
    <script src="{{ asset('asset/js/submenu.js') }}" type="text/javascript"></script>
@endsection