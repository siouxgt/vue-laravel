$(document).ready(function () {
    $.fn.dataTable.moment( 'DD/MM/YYYY' );

    dataTableAdmin = $('#tabla_admin').DataTable({
        processing: true,
        serverSide: false,
         dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
        "<'row justify-content-md-center'<'col-sm-12't>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",       
        language: {
            "url": url + "asset/datatables/Spanish.json"
        }
    });

     dataTableAdmin.on('order.dt search.dt', function () {
        let i = 1;
        dataTableAdmin.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
            this.data(i++);
        });
    }).draw();

    $('#tabla_admin tbody').on('click', 'td.details-control', function () {
        let tr = $(this).closest('tr');
        let row = dataTableAdmin.row( tr );
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( formatA(row.data()) ).show();
            tr.addClass('shown');
        }
    });
});

function tableAdmin(){
    dataTableAdmin.destroy();
    sleep(300).then(()=> {
        dataTableAdmin = $('#tabla_admin').DataTable({
            processing: true,
            serverSide: false,
            dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
                "<'row justify-content-md-center'<'col-sm-12't>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                "url": url + "asset/datatables/Spanish.json"
            },
            ajax: {
                "url": route('incidencia_admin.data_admin'),
                "type": "GET"
            },
            columnDefs: [
                {
                    searchable: false,
                    orderable: false,
                    targets: 0,
                    className: "text-center",
                }
            ],
            order: [[2, 'asc']],
            columns: [
                { data: 'id_t', defaultContent: '' },
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                { data: 'usuario' },
                { data: 'fecha_apertura', className: "text-center" },
                { data: 'etapa' },
                { data: 'etapa_id' },
                { data: 'motivo' },
                {
                    "className": "text-center",
                    "mRender": function (data, type, row) {
                        let conten = "";
                        if(row.escala == "Leve"){
                            conten = `<span class="espera px-3 font-weight-bold">${ row.escala }</span>`;
                        }
                        if(row.escala == "Moderada"){
                            conten = `<span class="moderada px-3 font-weight-bold">${ row.escala }</span>`;
                        }
                        if(row.escala == "Grave"){
                            conten = `<span class="cancelada px-3 font-weight-bold">${ row.escala }</span>`;
                        }
                        return conten;
                    }
                },
            ]
        });
    });
}

function formatA ( d ) {
    let table = `<table class="table justify-content-md-center">
        <tr>
            <td class="bg-light">Fecha apertura</td>
            <td> ${ d.fecha_apertura } </td>
            <td class="bg-light">ID Incidencia</td>
            <td> ${ d.id_incidencia } </td>
        </tr>
        <tr>
            <td class="bg-light">Origen</td>
            <td> ${ d.etapa } </td>
            <td class="bg-light">ID Origen</td>
            <td> ${ d.etapa_id } </td>
        </tr>
        <tr>
            <td class="bg-light">Usuario</td>
            <td colspan="3"> ${ d.usuario } </td>
        </tr>
        <tr>
            <td class="bg-light">Escala</td>
            <td> ${ d.escala != null ? d.escala : "" } </td>
            <td class="bg-light">Sanción</td>
            <td> ${ d.sancion != null ? d.sancion : "" } </td>
        </tr>
        <tr>
            <td class="bg-light">Motivo</td>
            <td colspan="7"> ${ d.motivo } </td>
        </tr>
        <tr>
            <td class="bg-light">Descripción</td>
            <td colspan="7"> ${ d.descripcion } </td>
        </tr>
        </table>`;

    return table;
}


function abrirIncidenciaModal(){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route('incidencia_admin.modal_admin_incidencia'),
        dataType: 'html',
        success: function (resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function () {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({ dropdownParent: $("#abrir_incidente_modal") });
                let usuario = document.querySelector('#usuario');
                let nombre = document.querySelector('#nombre');
                let origen = document.querySelector('#origen');
                let origenId = document.querySelector('#id_origen');
                let escala = document.querySelector('#escala');
                let sancion = document.querySelector('#sancion');
                let motivo = document.querySelector('#motivo');
                usuario.addEventListener('change',()=>{
                    escala.options[0].selected = true;
                    sancion.innerHTML = `<option value="">Seleccione una opción...</option>`;
                    motivo.innerHTML = `<option value="">Seleccione una opción...</option>`;
                    let valor = usuario.options[usuario.selectedIndex].value;
                    if(valor != 0){
                        usuarios(valor);
                    }else {
                        nombre.innerHTML = `<option value="">Seleccione una opción...</option>`;
                        origen.innerHTML = `<option value="">Seleccione una opción...</option>`;
                        origenId.innerHTML = `<option value="">Seleccione una opción...</option>`;
                        escala.options[0].selected = true;
                        sancion.innerHTML = `<option value="">Seleccione una opción...</option>`;
                        motivo.innerHTML = `<option value="">Seleccione una opción...</option>`;
                    }
                });
            }).on('hidden.bs.modal', function () {
                $(this).remove();
            });
        },
        error: function (respuesta) {
            Swal.fire('¡Alerta!', 'Error de conectividad de red USR-03', 'warning');
        }
    });
}

function usuarios(valor){
    let nombre = document.querySelector('#nombre');
    let origen = document.querySelector('#origen');
    let origenSec = document.querySelector('#id_origen');
    nombre.innerHTML = `<option value="">Seleccione una opción...</option>`;
    origen.innerHTML = `<option value="">Seleccione una opción...</option>`;
    origenSec.innerHTML = `<option value="">Seleccione una opción...</option>`;
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('incidencia_admin.combos_usuarios', {usuario: valor}),
        type: 'GET',
        dataType: 'json',
        success: function(respuesta) {
            $.each(respuesta.usuarios, function(index, value){
                let opciones = `<option value="${ value.user_id }" >${ value.nombre } </option>`;
                nombre.innerHTML += opciones; 
            });
            $.each(respuesta.origen, function(index, value){
                let opciones = `<option data="${ index }" value="${ value }">${ value } </option>`;
                origen.innerHTML += opciones; 
            });
            
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
        }
    });
}


function idOrigen(){
    let tipoUser = document.querySelector('#usuario'); 
    let user = document.querySelector('#nombre');
    let origen = document.querySelector('#origen');
    let origenId = document.querySelector('#id_origen');
    let escala = document.querySelector('#escala');
    let sancion = document.querySelector('#sancion');
    let motivo = document.querySelector('#motivo');

    tipoUser = tipoUser.options[tipoUser.selectedIndex].value;
    let userId = user.options[user.selectedIndex].value;
    let idOrigen =  origen.options[origen.selectedIndex].getAttribute('data');

    origenId.innerHTML = `<option value="">Seleccione una opción...</option>`;
    if(idOrigen != null){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : route('incidencia_admin.combos_origen', {usuario: userId, origen: idOrigen, tipo: tipoUser}),
            type: 'GET',
            dataType: 'json',
            success: function(respuesta) {
                $.each(respuesta, function(index, value){
                    let opciones = `<option value="${ value.origen }">${ value.origen } </option>`;
                    origenId.innerHTML += opciones; 
                });
            },
            error: function(respuesta) {
                Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
            }
        });
    }

    user.addEventListener('change',()=>{
        origen.options[0].selected =  true;
        escala.options[0].selected = true;
        origenId.innerHTML = `<option value="">Seleccione una opción...</option>`;
        sancion.innerHTML = `<option value="">Seleccione una opción...</option>`;
        motivo.innerHTML = `<option value="">Seleccione una opción...</option>`;
    });
}


function sanciones(){
    let escala = document.querySelector('#escala');
    let sancion = document.querySelector('#sancion');
    let motivo = document.querySelector('#motivo');
    escala = escala.options[escala.selectedIndex].value;
    sancion.innerHTML = `<option value="">Seleccione una opción...</option>`;
    motivo.innerHTML = `<option value="">Seleccione una opción...</option>`;
    if(escala != null){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : route('incidencia_admin.combos_sancion', {escala: escala}),
            type: 'GET',
            dataType: 'json',
            success: function(respuesta) {
                $.each(respuesta, function(index, value){
                    let opciones = `<option data="${ index }" value="${ value }">${ value } </option>`;
                    sancion.innerHTML += opciones; 
                });
            },
            error: function(respuesta) {
                Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
            }
        });
    }
}

function motivos() {
    let tipoUser = document.querySelector('#usuario');
    let sancion = document.querySelector('#sancion');
    let motivo = document.querySelector('#motivo'); 
    sancion = sancion.options[sancion.selectedIndex].getAttribute('data');
    tipoUser = tipoUser.options[tipoUser.selectedIndex].value;
    motivo.innerHTML = `<option value="">Seleccione una opción...</option>`;
    if(sancion != null){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : route('incidencia_admin.combos_motivo', {sancion: sancion, tipo: tipoUser}),
            type: 'GET',
            dataType: 'json',
            success: function(respuesta) {
                $.each(respuesta, function(index, value){
                    let opciones = `<option value="${ value }">${ value } </option>`;
                    motivo.innerHTML += opciones; 
                });
            },
            error: function(respuesta) {
                Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
            }
        });
    }
}

function adminIncidenteSave(){
    if (!formValidate('#frm_incidencia')) { return false; }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('incidencia_admin.save'),
        type: 'POST',
        data: $("#frm_incidencia").serialize(),
        dataType: 'json',
        success: function (respuesta){
            if (respuesta.success == true) {
                $('#abrir_incidente_modal').modal('hide').on('hidden.bs.modal', function(){
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                    $('#tabla_admin').DataTable().ajax.reload();
                });
            }
            else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function filtroAdmin(select){
    let data = select.getAttribute('id')+"-"+select.options[select.selectedIndex].value;
    dataTableAdmin.destroy();
    dataTableAdmin = $('#tabla_admin').DataTable({
        processing: true,
        serverSide: false,
        dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
            "<'row justify-content-md-center'<'col-sm-12't>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        language: {
            "url": url + "asset/datatables/Spanish.json"
        },
        ajax: {
            "url": route('incidencia_admin.data_admin_filtro', {filtro: data}),
            "type": "GET"
        },
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: 0,
                className: "text-center",
            }
        ],
        order: [[2, 'asc']],
        columns: [
            { data: 'id_t', defaultContent: '' },
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { data: 'usuario' },
            { data: 'fecha_apertura', className: "text-center" },
            { data: 'etapa' },
            { data: 'etapa_id' },
            { data: 'motivo' },
            {
                "className": "text-center",
                "mRender": function (data, type, row) {
                    let conten = "";
                    if(row.escala == "Leve"){
                        conten = `<span class="espera px-3 font-weight-bold">${ row.escala }</span>`;
                    }
                    if(row.escala == "Moderada"){
                        conten = `<span class="moderada px-3 font-weight-bold">${ row.escala }</span>`;
                    }
                    if(row.escala == "Grave"){
                        conten = `<span class="cancelada px-3 font-weight-bold">${ row.escala }</span>`;
                    }
                    return conten;
                }
            },
        ]
    });
}

function filtroFechaAdmin(){
    let de = document.querySelector('#de_admin');
    let hasta = document.querySelector('#hasta_admin');
    let auxDe = de.value.split('/');
    let dataDe = auxDe[0]+"_"+auxDe[1]+"_"+auxDe[2];
    let auxHasta = hasta.value.split('/');
    let dataHasta = auxHasta[0]+"_"+auxHasta[1]+"_"+auxHasta[2];
    let data = "fecha-"+dataDe+"-"+dataHasta;
    auxDe = Date.parse(auxDe[2] + '/' + auxDe[1] + '/' + auxDe[0]);
    auxHasta = Date.parse(auxHasta[2] + '/' + auxHasta[1] + '/' + auxHasta[0]);
    if(auxDe < auxHasta){
        dataTableAdmin.destroy();
        dataTableAdmin = $('#tabla_admin').DataTable({
            processing: true,
            serverSide: false,
            dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
                "<'row justify-content-md-center'<'col-sm-12't>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                "url": url + "asset/datatables/Spanish.json"
            },
            ajax: {
                "url": route('incidencia_admin.data_admin_filtro', {filtro: data}),
                "type": "GET"
            },
            columnDefs: [
                {
                    searchable: false,
                    orderable: false,
                    targets: 0, 
                    className: "text-center",
                }
            ],
            order: [[2, 'asc']],
            columns: [
                { data: 'id_t', defaultContent: '' },
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                { data: 'usuario' },
                { data: 'fecha_apertura', className: "text-center" },
                { data: 'etapa' },
                { data: 'etapa_id' },
                { data: 'motivo' },
                {
                    "className": "text-center",
                    "mRender": function (data, type, row) {
                        let conten = "";
                        if(row.escala == "Leve"){
                            conten = `<span class="espera px-3 font-weight-bold">${ row.escala }</span>`;
                        }
                        if(row.escala == "Moderada"){
                            conten = `<span class="moderada px-3 font-weight-bold">${ row.escala }</span>`;
                        }
                        if(row.escala == "Grave"){
                            conten = `<span class="cancelada px-3 font-weight-bold">${ row.escala }</span>`;
                        }
                        return conten;
                    }
                },
            ]
        });
    }
}


function modalRespuesta(id){
	$.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route('incidencia_admin.modal_respuesta'),
        dataType: 'html',
        success: function (resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function () {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({ dropdownParent: $("#info_proveedor_modal") });
                let incidente = document.querySelector('#incidente');
                incidente.value = id;
                let escala = document.querySelector('#escala');
                let sancion = document.querySelector('#sancion');
                escala.addEventListener('change',()=>{
                	sancion.innerHTML = `<option>Seleccione una opción...</option>`;
                	let valor = escala.options[escala.selectedIndex].value;
                	if(valor != 0){
	                	respuestaSancion(valor);
	                }
                });
            }).on('hidden.bs.modal', function () {
                $(this).remove();
            });
        },
        error: function (respuesta) {
            Swal.fire('¡Alerta!', 'Error de conectividad de red USR-03', 'warning');
        }
    });
}

function respuestaSancion(valor){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('incidencia_admin.combos_respuesta', {escala: valor}),
        type: 'GET',
        dataType: 'json',
        success: function(respuesta) {
            $.each(respuesta, function(index, value){
                let opciones = `<option value="${ value }">${ value } </option>`;
                sancion.innerHTML += opciones; 
            });
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
        }
    });
}

function caracteres(text,contador) {
    let longitudAct = text.value.length;
    document.querySelector(`#${contador}`).innerHTML = `${longitudAct}/1000 palabras`;
}


function respuestaSave(){
	if (!formValidate('#frm_respuesta')) { return false; }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('incidencia_admin.respuesta_save'),
        type: 'POST',
        data: $("#frm_respuesta").serialize(),
        dataType: 'json',
        success: function (respuesta){
            if (respuesta.success == true) {
                $('#responder_modal').modal('hide').on('hidden.bs.modal', function(){
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                    $('#tabla_urg').DataTable().ajax.reload();
                });
            }
            else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}