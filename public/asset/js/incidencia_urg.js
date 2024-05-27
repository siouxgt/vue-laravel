$(document).ready(function () {
    $.fn.dataTable.moment( 'DD/MM/YYYY' );
	dataTableUrg = $('#tabla_urg').DataTable({
        processing: true,
        serverSide: false,
        dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
            "<'row justify-content-md-center'<'col-sm-12't>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        language: {
            "url": url + "asset/datatables/Spanish.json"
        },
        ajax: {
            "url": route('incidencia_urg.data_urg'),
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
            { data: 'proveedor' },
            { data: 's_fecha_apertura', className: "text-center" },
            { data: 'etapa' },
            { data: 'orden_compra' },
            { data: 'motivo' },
            {
                "className": "text-center",
                "mRender": function (data, type, row) {
                	let conten = "";
                	if(row.estatus){
                		conten = `<span class="cancelada px-3 font-weight-bold">Abierta</span>`;
                	}
                	else{
                		conten = `<span class="confirmada px-3 font-weight-bold">Cerrada</span>`;
                	}
                	return conten;
                }
            },
            {
                "className": "text-center",
            	"mRender": function (data, type, row) {
                    let conten = `<a href="javascript:void(0)"><i class="fa-regular fa-square-check icon-gris"></i></a>`;
                    if(row.conformidad == null && row.escala == null){
                        conten = `<a href="javascript:void(0)" onclick="modalConformidad('${row.id_e}')"><i class="fa-regular fa-square-check gold"></i></a>`;
                    }
                	return conten
                }
            },
        ]
    });

    dataTableUrg.on('order.dt search.dt', function () {
        let i = 1;
        dataTableUrg.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
            this.data(i++);
        });
    }).draw();

    $('#tabla_urg tbody').on('click', 'td.details-control', function () {
        let tr = $(this).closest('tr');
        let row = dataTableUrg.row( tr );
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    });
});


function format ( d ) {
    let table = `<table class="table justify-content-md-center">
        <tr>
            <td class="bg-light">Fecha apertura</td>
            <td> ${ d.s_fecha_apertura } </td>
            <td class="bg-light">Fecha respuesta</td>
            <td> ${ d.s_fecha_respuesta != null ? d.s_fecha_respuesta : ""} </td>
            <td class="bg-light">Tiempo de respuesta</td>
            <td> ${ d.tiempo_respuesta != null ? d.tiempo_respuesta+ " días" : "" } </td>
            <td class="bg-light">Fecha cierre</td>
            <td> ${d.s_fecha_cierre != null ? d.s_fecha_cierre : "" } </td>
        </tr>
        <tr>
            <td class="bg-light">Origen</td>
            <td> ${ d.etapa } </td>
            <td class="bg-light">ID Orden compra</td>
            <td> ${ d.orden_compra } </td>
            <td class="bg-light">ID Incidencia</td>
            <td colspan="3"> ${ d.id_incidencia } </td>
        </tr>
        <tr>
        	<td class="bg-light">Proveedor</td>
            <td colspan="7"> ${ d.proveedor } </td>
        </tr>
        <tr>
        	<td class="bg-light">Motivo</td>
            <td colspan="7"> ${ d.motivo } </td>
        </tr>
        <tr>
        	<td class="bg-light">Descripción</td>
            <td colspan="7"> ${ d.descripcion } </td>
        </tr>
        <tr>
        	<td class="bg-light">Escala</td>
            <td colspan="3"> ${ d.escala != null ? d.escala : "" } </td>
            <td class="bg-light">Sanción</td>
            <td colspan="3"> ${ d.sancion != null ? d.sancion : "" } </td>
        </tr>
        <tr>
        	<td class="bg-light">Respuesta</td>
            <td colspan="7"> ${ d.respuesta != null ? d.respuesta : "" } </td>
        </tr>
        `;
        if(d.conformidad == null){
            table +=`
                <tr>
                    <td class="bg-light">Confirmidad</td>
                    <td colspan="7"> </td>
                </tr>`;    
        }else{
        table +=`
            <tr>
        	   <td class="bg-light">Confirmidad</td>
                <td colspan="7"> ${ d.conformidad == true ? "Sí" : "No" } </td>
            </tr>`;
        }

        table +=` 
        <tr>
        	<td class="bg-light">Comentario</td>
            <td colspan="7"> ${ d.comentario != null ? d.comentario : "" } </td>
        </tr>
        </table>`;

    return table;
}

function modalConformidad(incidencia){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route('incidencia_urg.modal_conformidad'),
        dataType: 'html',
        success: function (resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function () {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({ dropdownParent: $("#info_proveedor_modal") });
                let incidenci = document.querySelector('#incidencia');
                incidenci.value = incidencia;
                let conformidad = document.querySelector('#conformidad');
                let divComentario = document.querySelector('#div_comentario');
                conformidad.addEventListener('change',(e)=>{
                    let valor = conformidad.options[conformidad.selectedIndex].value;
                    if(valor == 'No')
                    {
                        divComentario.classList.remove('ocultar');
                    }
                    else{
                        divComentario.classList.add('ocultar');
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

function saveConformidad(){
     if (!formValidate('#frm_conformidad')) { return false; }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('incidencia_urg.conformidad_save'),
        type: 'POST',
        data: $("#frm_conformidad").serialize(),
        dataType: 'json',
        success: function (respuesta){
            if (respuesta.success == true) {
                $('#conformidad_incidencia').modal('hide').on('hidden.bs.modal', function(){
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

function caracteres(text,contador) {
    let longitudAct = text.value.length;
    document.querySelector(`#${contador}`).innerHTML = `${longitudAct}/1000 palabras`;
}

function filtroUrg(select){
    let data = select.getAttribute('id')+"-"+select.options[select.selectedIndex].value;
    dataTableUrg.destroy();
    dataTableUrg = $('#tabla_urg').DataTable({
        processing: true,
        serverSide: false,
        dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
            "<'row justify-content-md-center'<'col-sm-12't>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        language: {
            "url": url + "asset/datatables/Spanish.json"
        },
        ajax: {
            "url": route('incidencia_urg.data_urg_filtro', {filtro: data}),
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
            { data: 'proveedor' },
            { data: 's_fecha_apertura', className: "text-center" },
            { data: 'etapa' },
            { data: 'orden_compra' },
            { data: 'motivo' },
            {
                "className": "text-center",
                "mRender": function (data, type, row) {
                    let conten = "";
                    if(row.estatus){
                        conten = `<span class="cancelada px-3 font-weight-bold">Abierta</span>`;
                    }
                    else{
                        conten = `<span class="confirmada px-3 font-weight-bold">Cerrada</span>`;
                    }
                    return conten;
                }
            },
            {
                "className": "text-center",
                "mRender": function (data, type, row) {
                    let conten = `<a href="javascript:void(0)"><i class="fa-regular fa-square-check icon-gris"></i></a>`;
                    if(row.conformidad == null && row.escala == null){
                        conten = `<a href="javascript:void(0)" onclick="modalConformidad('${row.id_e}')"><i class="fa-regular fa-square-check gold"></i></a>`;
                    }
                    return conten
                }
            },
        ]
    });

}

function filtroFechaUrg(){
    let de = document.querySelector('#de_urg');
    let hasta = document.querySelector('#hasta_urg');
    let auxDe = de.value.split('/');
    let dataDe = auxDe[0]+"_"+auxDe[1]+"_"+auxDe[2];
    let auxHasta = hasta.value.split('/');
    let dataHasta = auxHasta[0]+"_"+auxHasta[1]+"_"+auxHasta[2];
    let data = "fecha-"+dataDe+"-"+dataHasta;
    auxDe = Date.parse(auxDe[2] + '/' + auxDe[1] + '/' + auxDe[0]);
    auxHasta = Date.parse(auxHasta[2] + '/' + auxHasta[1] + '/' + auxHasta[0]);
    if(auxDe < auxHasta){
        dataTableUrg.destroy();
        dataTableUrg = $('#tabla_urg').DataTable({
            processing: true,
            serverSide: false,
            dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
                "<'row justify-content-md-center'<'col-sm-12't>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                "url": url + "asset/datatables/Spanish.json"
            },
            ajax: {
                "url": route('incidencia_urg.data_urg_filtro', {filtro: data}),
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
                { data: 'proveedor' },
                { data: 's_fecha_apertura', className: "text-center" },
                { data: 'etapa' },
                { data: 'orden_compra' },
                { data: 'motivo' },
                {
                    "className": "text-center",
                    "mRender": function (data, type, row) {
                        let conten = "";
                        if(row.estatus){
                            conten = `<span class="cancelada px-3 font-weight-bold">Abierta</span>`;
                        }
                        else{
                            conten = `<span class="confirmada px-3 font-weight-bold">Cerrada</span>`;
                        }
                        return conten;
                    }
                },
                {
                    "className": "text-center",
                    "mRender": function (data, type, row) {
                        let conten = `<a href="javascript:void(0)"><i class="fa-regular fa-square-check icon-gris"></i></a>`;
                        if(row.conformidad == null && row.escala == null){
                            conten = `<a href="javascript:void(0)" onclick="modalConformidad('${row.id_e}')"><i class="fa-regular fa-square-check gold"></i></a>`;
                        }
                        return conten
                    }
                },
            ]
        });
    }
}