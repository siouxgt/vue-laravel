<div class="row justify-content-md-center">
    <div class="col-12 mt-2">
        <p class="text-center text-10 mb-2">Incidencias generadas por el Administrador</p>
        <div class="row mt-3 mb-3">
            <div class="col-2"></div>
            <div class="col-md-4 col-sm-12">
                <p class="text-center text-14 text-center">URG con incidencias: {{ $contadoresAdmin->urg }}</p>
            </div>
            <div class="col-md-4 col-sm-12 align-items-center">
                <p class="text-center text-14 text-center">Proveedores con incidencias: {{ $contadoresAdmin->proveedor }} </p>
            </div>
            <div class="col-2"></div>
        </div>

        <div class="row justify-content-md-center">
            <div class="col-2"></div>
            <div class="col-12 col-md-2 text-center">
                <p class="text-1"><span class="text-15">{{ $contadoresAdmin->total }}</span>-Todas</p>
            </div>
            <div class="col-12 col-md-2 text-center">
                <p class="text-1"><span class="text-15">{{ $contadoresAdmin->leve }}</span>-Leves</p>
            </div>
            <div class="col-12 col-md-2 text-center">
                <p class="text-1"><span class="text-15">{{ $contadoresAdmin->moderada }}</span>-Moderadas</p>
            </div>
            <div class="col-12 col-md-2 text-center">
                <p class="text-1"><span class="text-15">{{ $contadoresAdmin->grave }}</span>-Graves</p>
            </div>
            <div class="col-2"></div>
        </div>
        <div class="row justify-content-md-center mt-4">
            <div class="col-md-4 col-sm-12 text-center">
                <button type="button" class="btn boton-12" onclick="abrirIncidenciaModal()">Abrir incidencia</button>
            </div>
        </div>
        <hr>

        <div class="row justify-content-center">
            <div class="col-md-auto col-sm-12 mt-1">
                <select class="custom-select mr-sm-2 text-2 " id="admin_urg" onchange="filtroAdmin(this)">
                    <option selected disabled>Unidades Responsables de Gasto</option>
                    <option value="todos">Todo</option>
                    @foreach ($adminUrgs as $urg)
                        <option value="{{ $urg->id_e }}">{{$urg->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-auto col-sm-12 mt-1">
                <select class="custom-select mr-sm-2 text-2" id="admin_proveedor" onchange="filtroAdmin(this)">
                    <option selected disabled>Proveedor</option>
                    <option value="todos">Todo</option>
                    @foreach ($adminProveedores as $proveedor)
                        <option value="{{ $proveedor->id_e }}">{{ $proveedor->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-auto col-sm-12 mt-1">
                <select class="custom-select mr-sm-2 text-2" id="admin_origen" onchange="filtroAdmin(this)">
                    <option selected disabled>Origen</option>
                    <option value="todos">Todo</option>
                    @foreach ($adminOrigen as $origen)
                        <option value="{{ $origen->etapa }}">{{ $origen->etapa }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-auto col-sm-12 mt-1">
                <select class="custom-select mr-sm-2 text-2" id="admin_escala" onchange="filtroAdmin(this)">
                    <option selected disabled>Escala</option>
                    <option value="todos">Todo</option>
                    <option value="Leve">Leve</option>
                    <option value="Moderada">Moderada</option>
                    <option value="Grave">Grave</option>
                </select>
            </div>
            <div class="col-auto mt-1">
                <div class="form-row text-2">
                    <div class="input-group date">
                        <label for="de_admin" class="mr-1">De</label>
                        <input type="text" class="form-control text-1" name="de_admin" id="de_admin" autocomplete="off" onchange="filtroFechaAdmin()">
                        <span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                    </div>
                 </div>
             </div>
            <div class="col-auto mt-1">
                <div class="form-row text-2">
                   <div class="input-group date">
                        <label for="hasta_admin" class="mr-1">Hasta</label>
                        <input type="text" class="form-control text-1" name="hasta_admin" id="hasta_admin" autocomplete="off" onchange="filtroFechaAdmin()">
                        <span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>

            <div class="col-md-11 col-sm-12 mt-4">
                <div class="table-responsive-1 ml-2">
                    <table class="table border rounded" id="tabla_admin">
                        <thead>
                            <tr>
                                <th class="col-xs-1">#</th>
                                <th class="col-xs-1"></th>
                                <th class="col-xs-1 sortable text-2 font-weight-bold">Usuario</th>
                                <th class="col-xs-1 sortable tab-cent text-2 font-weight-bold">Fecha apertura</th>
                                <th class="col-xs-1 sortable tab-cent text-2 font-weight-bold">Origen</th>
                                <th class="col-xs-1 sortable tab-cent text-2 font-weight-bold">ID Origen</th>
                                <th class="col-xs-1 sortable tab-cent text-2 font-weight-bold">Motivo</th>
                                <th class="col-xs-1 sortable tab-cent text-2 font-weight-bold">Escala</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>