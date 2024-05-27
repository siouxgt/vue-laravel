<div class="row justify-content-md-center">
    <div class="col-12 mt-2">
        <p class="text-center text-10 mb-2">Unidades Responsables de Gasto</p>
        <p class="text-center text-14 mb-4">Proveedores con incidencias: {{ $contadoresUrg->proveedores}}</p>

        <div class="row justify-content-md-center">
            <div class="col-2"></div>
            <div class="col-12 col-md-2 text-center">
                <p class="text-1"><span class="text-15">{{ $contadoresUrg->todos }}</span>-Todas</p>
            </div>
            <div class="col-12 col-md-2 text-center">
                <p class="text-1"><span class="text-15">{{ $contadoresUrg->abiertas }}</span>-Abiertas</p>
            </div>
            <div class="col-12 col-md-2 text-center">
                <p class="text-1"><span class="text-15">{{ $contadoresUrg->respuestas }}</span>-Respuestas</p>
            </div>
            <div class="col-12 col-md-2 text-center">
                <p class="text-1"><span class="text-15">{{ $contadoresUrg->cerradas }}</span>-Cerradas</p>
            </div>
            <div class="col-2"></div>
        </div>
        <hr>

        <div class="row justify-content-center ml-3">
            <div class="col-md-2 col-sm-12 mt-1">
                <select class="custom-select mr-sm-2 text-2" onchange="filtroUrg(this)" id="urg_proveedor">
                    <option selected disabled>Proveedores</option>
                    <option value="todos">Todas</option>
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id_e }}">{{ $proveedor->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-auto col-sm-12 mt-1">
                <select class="custom-select mr-sm-2 text-2" onchange="filtroUrg(this)" id="urg_estatus">
                    <option selected>Estatus</option>
                    <option value="todos">Todos</option>
                    <option value="true">Abierta</option>
                    <option value="false">Cerrada</option>
                </select>
            </div>
            <div class="col-auto mt-1">
                <div class="form-row text-2">
                    <div class="input-group date">
                        <label for="de_urg" class="mr-1">De</label>
                        <input type="text" class="form-control text-1" name="de_urg" id="de_urg" autocomplete="off" onchange="filtroFechaUrg()">
                        <span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-auto mt-1">
                <div class="form-row text-2">
                   <div class="input-group date">
                        <label for="hasta_urg" class="mr-1">Hasta</label>
                        <input type="text" class="form-control text-1" name="hasta_urg" id="hasta_urg" autocomplete="off" onchange="filtroFechaUrg()">
                        <span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-md-11 col-sm-12 mt-4">
                <div class="table-responsive-1 ml-2">
                    <table class="table border rounded" id="tabla_urg">
                        <thead>
                            <tr>
                                <th class="col-xs-1">#</th>
                                <th class="col-xs-1"></th>
                                <th class="col-xs-1 sortable text-2 font-weight-bold">Proveedor</th>
                                <th class="col-xs-1 sortable tab-cent text-2 font-weight-bold">Fecha apertura</th>
                                <th class="col-xs-1 sortable tab-cent text-2 font-weight-bold">Origen</th>
                                <th class="col-xs-1 sortable tab-cent text-2 font-weight-bold">ID Origen</th>
                                <th class="col-xs-1 sortable tab-cent text-2 font-weight-bold">Motivo</th>
                                <th class="col-xs-1 sortable tab-cent text-2 font-weight-bold">Estatus</th>
                                <th class="col-xs-1 tab-cent text-2 font-weight-bold">Solucionado</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>