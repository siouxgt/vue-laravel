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
                "url": route('incidencia_urg.data_admin'),
                "type": "GET"
            },
            columnDefs: [
                {
                    searchable: false,
                    orderable: false,
                    targets: 0,
                    className: "text-center"
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
                { data: 's_fecha_apertura', className: "text-center" },
                { data: 'id_incidencia' },
                { data: 'etapa' },
                { data: 'etapa_id' },
                { data: 'motivo' },
                { data: 'sancion' },
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
            <td> ${ d.s_fecha_apertura } </td>
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

function filtroAdmin(select){
    let data = select.getAttribute('id')+"-"+select.options[select.selectedIndex].value;
    console.log(data);
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
            "url": route('incidencia_urg.data_admin_filtro', {filtro: data}),
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
            { data: 's_fecha_apertura', className: "text-center" },
            { data: 'id_incidencia' },
            { data: 'etapa' },
            { data: 'etapa_id' },
            { data: 'motivo' },
            { data: 'sancion' },
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
                "url": route('incidencia_urg.data_admin_filtro', {filtro: data}),
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
                { data: 's_fecha_apertura', className: "text-center" },
                { data: 'id_incidencia' },
                { data: 'etapa' },
                { data: 'etapa_id' },
                { data: 'motivo' },
                { data: 'sancion' },
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