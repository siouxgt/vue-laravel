@extends($layout)
	@section('content')
		<div class="col-12">
		    <h1 class="m-2 px-3">Mensajes</h1>
		    <p class="text-1 ml-4">En esta página encontrarás los mensajes de tus compradores, administrador y sistema.</p>
		</div>
		<hr>

		<div class="row justify-content-md-center">
            <div class="col-lg-5 col-md-12 col-sm-12 mt-2 offset-md-7">
                <div class="row justify-content-sm-center ml-2">
                    <button type="button" class="btn bg-white ml-1 text-2 border font-weight-bold" onclick="mensajes(2)"><i class="fa-solid fa-inbox gris"></i>Todos</button>
                    <button type="button" class="btn bg-white ml-1 text-2 border" onclick="mensajes(3)"><i class="fa-sharp fa-solid fa-paper-plane gris"></i> Enviados</button>
                    <button type="button" class="btn bg-white ml-1 text-2 border" onclick="mensajes(4)"><i class="fa-solid fa-box-archive gris"></i> Archivados</button>
                    <button type="button" class="btn bg-white ml-1 text-2 border" onclick="mensajes(5)"><i class="fa-regular fa-rectangle-xmark gris"></i> Eliminados</button>
                </div>
            </div>
        </div>

        <div class="row align-items-cente mb-2 mt-2r">
            <div class="col-lg-4 col-md-5 col-sm-12 offset-1">
                
                <input type="checkbox" class="form-check-input bac-green mt-3" id="todos" onclick="todos()">
                
                <button type="button" class="btn bg-white" id="destaca">
                    <i class="fa-solid fa-star gold"></i>
                </button>
                <button type="button" class="btn bg-white" id="archiva">
                    <i class="fa-solid fa-box-archive gold"></i>
                </button>
                <button type="button" class="btn bg-white" id="elimina">
                    <i class="fa-regular fa-rectangle-xmark gold"></i>
                </button>
            </div>
            <div class="col-lg-3 col-md-1"><p class="text-9-1 mt-2">Sin leer: <strong id="sin_leer">{{ $sinLeer[0]->sin_leer }}</strong></p></div>
            <div class="col-lg-2 col-md-5 col-sm-12">
                <div class="col-auto my-1">
                    <select class="custom-select mr-sm-2 text-1" id="mostrar">
                        <option value="2" selected>Mostrar</option>
                        <option value="2">Todo</option>
                        <option value="6">Destacado</option>
                        <option value="7">No leído</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row justify-content-md-center">
            <div class="col-md-11 col-sm-12 ml-2">
                <table class="table border rounded" id="table_mensajes">
                    <thead>
                        <tr>
                            <th class="col-xs-1"></th>
                            <th class="col-xs-1 tab-cent text-2 font-weight-bold">#</th>
                            <th class="col-xs-1"></th>
                            <th class="col-xs-1 sortable text-2 font-weight-bold">Fecha</th>
                            <th class="col-xs-1 sortable text-2 font-weight-bold">Remitente</th>
                            <th class="col-xs-1 sortable text-2 font-weight-bold">Asunto</th>
                            <th class="col-xs-1"></th>
                            <th class="col-xs-2 sortable text-2 font-weight-bold">Origen</th>
                            <th class="col-xs-1"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div> 

	@endsection
	@section('js')
    	@routes(['mensajeUser'])
    	<script src="{{ asset('asset/js/user_mensajes.js') }}" type="text/javascript"></script>
	@endsection