@extends('layouts.admin')
@section('content')

    <div class="row p-4">
        <div class="col-md-9 col-sm-12 p-3">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg">
                    <img src="{{ asset('asset/img/holaAdmin_Mesa_de_trabajo_1.svg') }}" class="img-fluid bg-light rounded" alt="/">
                  </div>

                {{-- <div class="col-sm-12 col-md-5 mt-1">
                    <div class="card bg-light border border-0">
                        <div class="card-body img-1Index">
                        </div>
                    </div>
                </div> --}}

                <div class="col-lg-2 col-md col-sm-12 bg-guinda rounded img-2Index text-truncate m-1">
                        <span class="label"> <a href="#">
                                <p class="titulo-text mt-2">Contratos Marco</p>
                            </a>
                        </span>
                        <p class="text-num">{{ $totalContratos }}</p>
                </div>

                <div class="col-lg-2 col-md col-sm-12 bg-guinda rounded img-3Index m-1">
                        <span class="label"> <a href="#">
                                <p class="titulo-text text-truncate mt-2">Proveedores</p>
                            </a>
                        </span>
                        <p class="text-num">{{ $proveedores }}</p>
                </div>

                <div class="col-lg-2 col-md col-sm-12 bg-guinda rounded img-4Index m-1">
                        <span class="label"> <a href="#">
                                <p class="titulo-text text-truncate mt-2">URGs</p>
                            </a>
                        </span>
                        <p class="text-num">{{ $urgs }}</p>
                </div>
            </div>


            <div class="row row-cols-1 row-cols-md-3 g-4 mt-2">

                <div class="col-sm-12 col-md-6 col-lg">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">

                            <div class="row align-items-center p-1">
                                <div class="col-lg-9 col-md col-sm-8">
                                    <p class="text-tarj-1 gris1 text-truncate">Contratos Marco</p>
                                </div>
                                <div class="col-lg-3 col-md col-sm-4 bg-verde text-center rounded" style="display: block">
                                    <p class="text-6 fw-bold arena mt-2">{{ $totalContratos }}</p>
                                </div>
                            </div>
                            <hr>

                            <div class="row align-items-center p-1">
                                <div class="col-9">
                                    <p class="fs-6 gris1">Por liberar</p>
                                </div>
                                <div class="col-3 bg-light text-center">
                                    <p class="fs-6 gris1 strong mt-2">{{ $porLiberar }}</p>
                                </div>
                            </div>

                            <div class="row align-items-center p-1">
                                <div class="col-9">
                                    <p class="fs-6 gris1">Por vencer</p>
                                </div>
                                <div class="col-3 bg-light text-center">
                                    <p class="fs-6 gris1 strong mt-2">{{ $porVencer }}</p>
                                </div>
                            </div>

                            <div class="row align-items-center p-1">
                                <div class="col-9">
                                    <p class="fs-6 gris1">Vencidos</p>
                                </div>
                                <div class="col-3 bg-light text-center">
                                    <p class="fs-6 gris1 strong mt-2">{{ $vencidos }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-verde text-center">
                            <a href="{{ route('contrato.index') }}" class="card-link titulo-text">Todos los Convenios</a>
                        </div>
                    </div>
                </div>


                <div class="col-sm-12 col-md-6 col-lg">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">

                            <div class="row align-items-center p-1">
                                <div class="col-lg-9 col-md col-sm-8">
                                    <p class="text-tarj-1 dorado text-truncate">Productos publicados</p>
                                </div>
                                <div class="col-lg-3 col-md col-sm-4 bg-dorado text-center rounded">
                                    <p class="text-6 fw-bold arena mt-2">{{ $countPublicados->publicados }}</p>
                                </div>
                            </div>
                            <hr>

                            <div class="row align-items-center p-1">
                                <div class="col-9">
                                    <p class="fs-6 gris1">Formularios creados</p>
                                </div>
                                <div class="col-3 bg-light text-center">
                                    <p class="fs-6 gris1 strong mt-2">{{ $formularios }}</p>
                                </div>
                            </div>

                            <div class="row align-items-center p-1">
                                <div class="col-9">
                                    <p class="fs-6 gris1">Ficha de producto</p>
                                </div>
                                <div class="col-3 bg-light text-center">
                                    <p class="fs-6 gris1 strong mt-2">{{ $allProductos->productos }}</p>
                                </div>
                            </div>

                            <div class="row align-items-center p-1">
                                <div class="col-9">
                                    <p class="fs-6 gris1">En validación técnica</p>
                                </div>
                                <div class="col-3 bg-light text-center">
                                    <p class="fs-6 gris1 strong mt-2">{{ $allValidacionTec->productos }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-dorado text-center tarj-foot-2">
                            <a href="#" class="card-link titulo-text-1">Todos los Productos</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">

                            <div class="row align-items-center p-1">
                                <div class="col-lg-9 col-md col-sm-8">
                                    <p class="text-tarj-1 guinda text-truncate text-tarj-3">Órdenes de compra</p>
                                </div>
                                <div class="col-lg-3 col-md col-sm-4 bg-guinda text-center rounded">
                                    <p class="text-6 fw-bold arena mt-2">0</p>
                                </div>
                            </div>
                            <hr>

                            <div class="row align-items-center p-1">
                                <div class="col-9">
                                    <p class="fs-6 gris1">Por entregar</p>
                                </div>
                                <div class="col-3 bg-light text-center">
                                    <p class="fs-6 gris1 strong mt-2">0</p>
                                </div>
                            </div>

                            <div class="row align-items-center p-1">
                                <div class="col-9">
                                    <p class="fs-6 gris1">Por pagar</p>
                                </div>
                                <div class="col-3 bg-light text-center">
                                    <p class="fs-6 gris1 strong mt-2">0</p>
                                </div>
                            </div>

                            <div class="row align-items-center p-1">
                                <div class="col-9">
                                    <p class="fs-6 gris1">Por calificar</p>
                                </div>
                                <div class="col-3 bg-light text-center">
                                    <p class="fs-6 gris1 strong mt-2">0</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-guinda text-center tarj-foot-3 ">
                            <a href="{{ route('orden_compra_admin.index') }}">
                                <p class="text-7 text-center col-12 titulo-text-1">Todas las Órdenes</p>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="col-md col-sm-12 rounded bg-verde p-3 mt-3" style="max-height: 480px">
            <div id="app">
                <example-component></example-component>
            </div>
            <a href="#" class="text-decoration-none mt-3">
                <div class="image-tienda text-center p-3 mt-3">
                    <img src="{{ asset('asset/img/admon_tienda.svg') }}" alt="/"
                        class="img-fluid text-center">
                    <p class="text-center arena fs-5 "><strong>Visita la</strong></p>
                    <p class="text-center arena fs-2 "><strong>Tienda en línea</strong></p>
                    
                </div>
            </a>
        </div>

    </div>

    <div class="row mt-4 p-3 justify-content-center">
        <div class="col-2">
            <p class="dorado fw-bold text-end">Contratos Marco</p>
           
        </div>
        <div class="col-10 mb-2">
            <hr>
        </div>
    </div>
  {{--   <div id="app">

        <example-component></example-component>
    </div>
 --}}

      <!-- Indicators -->
      <ul class="carousel-indicators">
        @for ($i = 0; $i < (ceil($contratos->count() / 4)); $i++)
        <li data-target="#demo" data-slide-to="{{ $i }}" class="@if($i == 0) active @endif"></li>
        @endfor
    </ul>

    <!-- The slideshow -->
        <div class="container carousel-inner no-padding ">
            @php $count = 0; @endphp
            @foreach($contratos as $key => $contrato)
              @if($count == 0)
                <div class="carousel-item @if($key == 0) active @endif"> 
              @endif
              @php $count++; @endphp
              <div class="col-xs-3 col-sm-3 col-md-3 d-flex justify-content-center">
                <div class="text-center ">
                  @if(\Carbon\Carbon::parse($contrato->created_at)->diffInDays(now()) < 90)
                    <p class="porLiberarSlider col-12">Nuevo</p>
                  @endif
                  <a href="{{ route('contrato.edit',['contrato'=>$contrato->id_e])}}">
                    <div class="row d-flex justify-content-center">
                      <div class="col-3">
                        @if( $contrato->imagen)
                          <img src="{{ asset('storage/img-contrato/'.$contrato->imagen)}}" class="perfil-3" alt="{{ $contrato->imagen }}">
                        @else    
                          <h2 class="perfil-3"><?php print(strtoupper(substr($contrato->nombre_cm, 0,1))); ?></h2>
                        @endif
                      </div>
                      <div class="col-10 ">
                        <p class="text-carrusel">{{ $contrato->nombre_cm }}</p>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
              @if($count == 4)
                </div>
                @php $count = 0; @endphp
                
               {{--  <div id="app">
                    <nav-component></nav-component>
                </div> --}}
              
              @endif
            @endforeach
            @if(($contratos->count() % 4 ) != 0)
        </div> 
            @endif              
        </div>

        <script src="{{mix('js/app.js')}}"></script>
   
 
@endsection
