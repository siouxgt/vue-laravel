<div class="row justify-content-md-center">
    <div class="col-12 mt-2">
        <p class="text-center text-10 mb-2">Incidencias generadas por el Administrador</p>

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
        <hr>

        <div class="row justify-content-center">            
            <div class="col-md-auto col-sm-12 mt-1">
                <select class="custom-select mr-sm-2 text-2" id="admin_origen" onchange="filtroAdmin(this)">
                    <option selected disabled>Origen</option>
                    <option value="todos">Todo</option>
                    @foreach ($origenes as $origen)
                        <option value="{{ $origen->etapa }}">{{ $origen->etapa }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-auto col-sm-12 mt-1">
                <select class="custom-select mr-sm-2 text-2" id="admin_motivo" onchange="filtroAdmin(this)">
                    <option selected disabled>Motivo</option>
                    <option value="todos">Todo</option>
                    @foreach ($motivos as $motivo)
                        <option value="{{ $motivo->motivo }}">{{ $motivo->motivo }}</option>
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
                                <th class="col-xs-1 sortable tab-cent text-2 font-weight-bold">Fecha apertura</th>
                                <th class="col-xs-1 sortable tab-cent text-2 font-weight-bold">ID Incidencia</th>
                                <th class="col-xs-1 sortable tab-cent text-2 font-weight-bold">Origen</th>
                                <th class="col-xs-1 sortable tab-cent text-2 font-weight-bold">ID Origen</th>
                                <th class="col-xs-1 sortable tab-cent text-2 font-weight-bold">Motivo</th>
                                <th class="col-xs-1 sortable tab-cent text-2 font-weight-bold">Sanción</th>
                                <th class="col-xs-1 sortable tab-cent text-2 font-weight-bold">Escala</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>