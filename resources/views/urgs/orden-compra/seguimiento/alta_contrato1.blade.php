@extends('layouts.urg')
    @section('content')
        @include('urgs.orden-compra.seguimiento.encabezado_interno')

        <section class="row justify-content-md-center">
            <div class="col-md-5 col-sm-11 align-self-center border rounded">

                <div class="col text-center">
                    <p class="text-1  m-2">Revisa los siguientes datos. Para problemas técnicos, contacta al administrador.</p>
                </div>
                <br>
                <div class="row justify-content-center mb-3">
                    <button type="button" class="btn bg-white d-flex align-items-center" id="problemas_tecnicos">
                        <i class="fa-solid fa-message text-10"></i>
                        <p class="text-mensaje">Problemas técnicos</p>
                    </button>
                </div>

                <div class="text-center mb-2">
                    <p class="text-14 ">Firma del contrato</p>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-6 col-sm-12">
                        <div class="progress-1">
                            <div class="progress-bar" role="progressbar" style="width: 20%"></div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <p class="text-11">1 de 5</p>
                </div>

                <hr>
                
                <div class="text-center mt-3">
                    <p class="text-2">URG Compradora</p>
                </div>

                <div class="text-center mb-4">
                    <p class="text-1 px-5"><strong> {{ auth()->user()->urg->ccg."-".auth()->user()->urg->nombre }} </strong></p>
                </div>


                <hr>

                <div class="text-center mt-3">
                    <p class="text-14">1. Vigencia del contrato</p>
                </div>

                <div class="text-center mt-1">
                    <p class="text-1">Selecciona el periodo de tiempo que abarcará el contrato</p>
                </div>

                
                <div class="row d-flex justify-content-center mt-2">
                    <form id="frm_contrato" action="{{ route('orden_compra_urg.alta_contrato_2') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label for="fecha_inicio" class="text-1">Fecha inicio</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-1" name="fecha_inicio" id="fecha_inicio" required autocomplete="off" @if($contrato->fecha_inicio) value="{{ $contrato->fecha_inicio->format('d/m/Y') }}" @endif>
                                    <span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>

                            <div class="col">
                                <label for="fecha_fin" class="text-1">Fecha fin</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-1" name="fecha_fin" id="fecha_fin" required autocomplete="off" @if($contrato->fecha_fin) value="{{ $contrato->fecha_fin->format('d/m/Y') }}" @endif>
                                    <span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            @if(isset($firmantes[2]))
                                <input type="hidden" name="rfc" value="{{ $firmantes[2]['rfc'] }}">
                                <input type="hidden" name="nombre" value="{{ $firmantes[2]['nombre'] }}">
                                <input type="hidden" name="primer_apellido" value="{{ $firmantes[2]['primer_apellido'] }}">
                                <input type="hidden" name="segundo_apellido" value="{{ $firmantes[2]['segundo_apellido'] }}">
                                <input type="hidden" name="puesto" value="{{ $firmantes[2]['puesto'] }}">
                                <input type="hidden" name="telefono" value="{{ $firmantes[2]['telefono'] }}">
                                <input type="hidden" name="extension" value="{{ $firmantes[2]['extension'] }}">
                                <input type="hidden" name="correo" value="{{ $firmantes[2]['correo'] }}">
                                <input type="hidden" name="firmante_id" value="{{ $firmantes[2]['id'] }}">
                            @else
                                <input type="hidden" name="rfc" value="{{ auth()->user()->rfc }}">
                                <input type="hidden" name="nombre" value="{{ auth()->user()->nombre }}">
                                <input type="hidden" name="primer_apellido" value="{{ auth()->user()->primer_apellido }}">
                                <input type="hidden" name="segundo_apellido" value="{{ auth()->user()->segundo_apellido }}">
                                <input type="hidden" name="puesto" value="{{ auth()->user()->cargo }}">
                                <input type="hidden" name="telefono" value="{{ auth()->user()->telefono }}">
                                <input type="hidden" name="extension" value="{{ auth()->user()->extension }}">
                                <input type="hidden" name="correo" value="{{ auth()->user()->email }}">
                                <input type="hidden" name="identificador" value="2">
                            @endif
                            <input type="hidden" name="contrato_id" value="{{ $contrato->id_e }}">
                        </div>
                    </form>
                </div>

                <hr>

                <div class="text-center mt-3">
                    <p class="text-14">2. Agrega y revisa los datos de las personas que firmarán el contrato</p>
                </div>

                <div class="text-center mt-3">
                    <p class="text-1"><strong>2. 1. Titular Dirección General de Administración y Finanzas u Homólogo</strong> </p>
                </div>

                @if(isset($firmantes[1]))
                    <div class="text-center">
                        <div class="botones">
                            <a class="btn mt-3 m-2 boton-2" href="javascript: void(0);" onclick="firmanteModalEdit('{{$firmantes[1]['id']}}');"><span><i class="fa-solid fa-plus"></i></span>Editar persona</a>
                        </div>
                    </div>
                    <div class="text-center mt-1">
                        <p class="text-2 mt-2">RFC</p>
                        <p class="text-1"><strong id="rfc1">{{ $firmantes[1]['rfc'] }}</strong> </p>

                        <p class="text-2 mt-3">Nombre</p>
                        <p class="text-1"><strong id="nombre1">{{ $firmantes[1]['nombre']." ".$firmantes[1]['primer_apellido']." ".$firmantes[1]['segundo_apellido']  }}</strong> </p>

                        <p class="text-2 mt-3">Puesto</p>
                        <p class="text-1"><strong id="puesto1">{{ $firmantes[1]['puesto'] }}</strong> </p>
                    </div>
                @else
                    <div class="text-center">
                        <div class="botones" id="agregar_persona1">
                            <a class="btn mt-3 m-2 boton-2" href="javascript: void(0);" onclick="firmanteModalCreate(1);"><span><i class="fa-solid fa-plus"></i></span>Agregar persona</a>
                        </div>
                    </div>
                    <div class="text-center mt-1 ocultar" id="responsable1">
                        <p class="text-2 mt-2">RFC</p>
                        <p class="text-1"><strong id="rfc1"></strong> </p>

                        <p class="text-2 mt-3">Nombre</p>
                        <p class="text-1"><strong id="nombre1"></strong> </p>

                        <p class="text-2 mt-3">Puesto</p>
                        <p class="text-1"><strong id="puesto1"></strong> </p>
                    </div>
                @endif

                <hr>


                <div class="text-center mt-1">
                    @if(isset($firmantes[2]))
                        <p class="text-1"><strong>2.2. Responsable Área de Adquisiciones o Compras</strong> </p>
                        <p class="text-2 mt-2">RFC</p>
                        <p class="text-1"><strong>{{ $firmantes[2]['rfc'] }}</strong> </p>

                        <p class="text-2 mt-3">Nombre</p>
                        <p class="text-1"><strong>{{ $firmantes[2]['nombre']." ".$firmantes[2]['primer_apellido']." ".$firmantes[2]['segundo_apellido'] }}</strong> </p>

                        <p class="text-2 mt-3">Puesto</p>
                        <p class="text-1"><strong>{{ $firmantes[2]['puesto'] }}</strong> </p>

                        <p class="text-2 mt-3">Teléfono</p>
                        <p class="text-1"><strong>{{ $firmantes[2]['telefono']." Ext. ". $firmantes[2]['extension'] }}</strong> </p>

                        <p class="text-2 mt-3">Correo electrónico</p>
                        <p class="text-1"><strong>{{ $firmantes[2]['correo'] }}</strong> </p>
                    @else 
                        <p class="text-1"><strong>2.2. Responsable Área de Adquisiciones o Compras</strong> </p>
                        <p class="text-2 mt-2">RFC</p>
                        <p class="text-1"><strong>{{ auth()->user()->rfc }}</strong> </p>

                        <p class="text-2 mt-3">Nombre</p>
                        <p class="text-1"><strong>{{ auth()->user()->nombre." ".auth()->user()->primer_apellido." ".auth()->user()->segundo_apellido }}</strong> </p>

                        <p class="text-2 mt-3">Puesto</p>
                        <p class="text-1"><strong>{{ auth()->user()->cargo }}</strong> </p>

                        <p class="text-2 mt-3">Teléfono</p>
                        <p class="text-1"><strong>{{ auth()->user()->telefono." Ext. ". auth()->user()->extension }}</strong> </p>

                        <p class="text-2 mt-3">Correo electrónico</p>
                        <p class="text-1"><strong>{{ auth()->user()->email }}</strong> </p>
                    @endif  
                </div>

                <hr>

                <div class="text-center mt-3">
                    <p class="text-14">3. Busca y agrega a otras personas que firmarán el contrato (Opcional)</p>
                </div>

                @if(isset($firmantes[4]))
                    <div class="text-center mt-3">
                        <p class="text-1"><strong>3.1. Agrega al Responsable Área Financiera</strong> </p>
                        <a class="btn btn-outline-light-v mt-3" href="javascript: void(0);" onclick="firmanteModalEdit('{{ $firmantes[4]['id']}}');"><span><i class="fa-solid fa-plus green"></i></span>Editar persona</a>
                    </div>
                    <div class="text-center mt-1">
                        <p class="text-2 mt-2">RFC</p>
                        <p class="text-1"><strong id="rfc4">{{ $firmantes[4]['rfc'] }}</strong> </p>

                        <p class="text-2 mt-3">Nombre</p>
                        <p class="text-1"><strong id="nombre4">{{ $firmantes[4]['nombre']." ".$firmantes[4]['primer_apellido']." ".$firmantes[4]['segundo_apellido']  }}</strong> </p>

                        <p class="text-2 mt-3">Puesto</p>
                        <p class="text-1"><strong id="puesto4">{{ $firmantes[4]['puesto'] }}</strong> </p>
                    </div>
                @else
                    <div class="text-center mt-3">
                        <p class="text-1"><strong>3.1. Agrega al Responsable Área Financiera</strong> </p>
                    </div>
                    <div class="text-center mt-3" id="agregar_persona4">
                        <a class="btn btn-outline-light-v mt-3" href="javascript: void(0);" onclick="firmanteModalCreate(4);"><span><i class="fa-solid fa-plus green"></i></span>Agregar persona</a>
                    </div>
                    <div class="text-center mt-1 ocultar" id="responsable4">
                        <p class="text-2 mt-2">RFC</p>
                        <p class="text-1"><strong id="rfc4"></strong> </p>

                        <p class="text-2 mt-3">Nombre</p>
                        <p class="text-1"><strong id="nombre4"></strong> </p>

                        <p class="text-2 mt-3">Puesto</p>
                        <p class="text-1"><strong id="puesto4"></strong> </p>
                    </div>
                @endif

                
                @if(isset($firmantes[5]))
                    <div class="text-center mt-3">
                        <p class="text-1"><strong>3.2. Agrega al Responsable Área Requirente</strong> </p>
                        <a class="btn btn-outline-light-v mt-3" href="javascript: void(0);" onclick="firmanteModalEdit('{{ $firmantes[5]['id']}}');"><span><i class="fa-solid fa-plus green"></i></span>Edita persona</a>
                    </div>
                    <div class="text-center mt-1">
                        <p class="text-2 mt-2">RFC</p>
                        <p class="text-1"><strong id="rfc5">{{ $firmantes[5]['rfc'] }}</strong> </p>

                        <p class="text-2 mt-3">Nombre</p>
                        <p class="text-1"><strong id="nombre5">{{ $firmantes[5]['nombre']." ".$firmantes[5]['primer_apellido']." ".$firmantes[5]['segundo_apellido']  }}</strong> </p>

                        <p class="text-2 mt-3">Puesto</p>
                        <p class="text-1"><strong id="puesto5">{{ $firmantes[5]['puesto'] }}</strong> </p>
                    </div>
                @else
                    <div class="text-center mt-3">
                        <p class="text-1"><strong>3.2. Agrega al Responsable Área Requirente</strong> </p>
                    </div>
                    <div class="text-center mt-3" id="agregar_persona5">
                        <a class="btn btn-outline-light-v mt-3" href="javascript: void(0);" onclick="firmanteModalCreate(5);"><span><i class="fa-solid fa-plus green"></i></span>Agregar persona</a>
                    </div>
                    <div class="text-center mt-1 ocultar" id="responsable5">
                        <p class="text-2 mt-2">RFC</p>
                        <p class="text-1"><strong id="rfc5"></strong> </p>

                        <p class="text-2 mt-3">Nombre</p>
                        <p class="text-1"><strong id="nombre5"></strong> </p>

                        <p class="text-2 mt-3">Puesto</p>
                        <p class="text-1"><strong id="puesto5"></strong> </p>
                    </div>
                @endif

                <div class="row mb-4 mt-5">
                    <div class="col-6">
                        <a class="btn btn-outline-light-v mt-3 mr-2 float-right" href="{{ route('orden_compra_urg.index', ['id' => session()->get('ordenCompraEstatus')]) }}">
                        <i class="fa-solid fa-arrow-left text-9"></i> Atras</a>
                    </div>
                    <div class="col-6">
                        <div class="botones">
                            <button type="submit" form="frm_contrato" class="btn boton-2 mt-3">Confirmar y continuar</button>
                        </div>
                    </div>
                </div>
        </section>

    @endsection
    @section('js')
        @routes(['ordenCompraUrg'])
        <script src="{{ asset('asset/js/seguimiento.js') }}" type="text/javascript"></script>
        <script type="text/javascript">
            let fechaContrato = "{{ $contrato->created_at->format('d/m/Y') }}";
            let fechaMax = "{{ $contrato->created_at->addDay(3)->format('d/m/Y') }}";
            let fechaEntrega = "{{ $contrato->fecha_entrega->format('d/m/Y')}}";
            
            $("#fecha_inicio").datepicker({
                format: "dd/mm/yyyy",
                language: "es",
                startDate: fechaContrato,
                endDate: fechaMax
            });

            $('#fecha_fin').datepicker({
                format: "dd/mm/yyyy",
                language: "es",
                startDate: fechaEntrega
            })

        </script>
    @endsection