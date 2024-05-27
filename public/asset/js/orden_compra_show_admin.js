$(document).ready(function () {
    $.fn.dataTable.moment( 'DD/MM/YYYY' );
    let id = document.querySelector('#orden_compra_id');
	let dataTable = $('#table_orden').DataTable({
            processing: true,
            serverSide: false,
            dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
                "<'row justify-content-md-center'<'col-sm-12't>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                "url": url + "asset/datatables/Spanish.json"
            },
            ajax: {
                "url": route('orden_compra_admin.data_show', {id: id.value}),
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
            order: [[1, 'asc']],
            columns: [
                { data: 'id_t', defaultContent: '' },          
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },
                { data: 'proveedor' },
                { 
                    "className": "text-center",
                    "mRender": function (data, type, row) {

                        return `<span class="etapa px-3">${row.etapa}</span>`;
                    }
                },
                { 
                    "className": "text-center",
                    "mRender": function (data, type, row) {

                        return `<span class="etapa-${row.css} px-3">${row.estatus}</span>`;
                    }
                },
                { data: 'fecha_fin', className: "text-center" },
                { data: 'incidencias', className: "text-center" },
                { 
                    "orderable": false,
                    "className": "text-center",
                    "mRender": function (data, type, row) {
                        let content = '';
                        if(row.producto_aceptado){
                            content = `<a class="btn btn-cdmx" href="${ route('orden_compra_admin.acuse_producto_confirmada', {proveedor: row.proveedor_id}) }"><i class="fa fa-file-invoice-dollar fa-lg like-gold"></i></a>`;
                        }
                        return content;
                    }
                },
                { 
                    "orderable": false,
                    "className": "text-center",
                    "mRender": function (data, type, row) {

                        return `<a class="btn btn-cdmx" href="${ route('orden_compra_admin.seguimiento', {id: row.id_e}) }"><i class="fa-solid fa-pen-to-square text-gold"></i></a>`;
                    }
                },                 
            ],

        });
      
        
        dataTable.on('order.dt search.dt', function () {
            let i = 1;
            dataTable.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                this.data(i++);
            });
        }).draw();

        $('#table_orden tbody').on('click', 'td.details-control', function () {
            let tr = $(this).closest('tr');
            let row = dataTable.row( tr );
            if ( row.child.isShown() ) {
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(row.data()) ).show();
                let table2 = $('#table_orden_'+row.data().id).DataTable({
                    paging: false,
                    searching: false,
                    info: false,
                    language: {
                        "url": url + "asset/datatables/Spanish.json"
                    },
                });
                tr.addClass('shown');
            }
        });
});

function format ( d ){
    var content = `<table class="table justify-content-md-center" id="table_orden_${d.id}">
        <thead>
            <th scope="col" class="sortable font-weight-bold">id</th>
            <th scope="col" class="sortable font-weight-bold">CAMBS CDMX</th>
            <th scope="col" class="sortable font-weight-bold">Producto</th>
            <th scope="col" class="sortable font-weight-bold">Cantidad</th>
            <th scope="col" class="sortable font-weight-bold">Total</th>
            <th scope="col" class="sortable font-weight-bold">Confirmación</th>
        </thead>
        <tbody>`;
    $.ajax({
            async: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : route('orden_compra_admin.data_productos', {id: d.proveedor_id}),
            type: 'GET',
            success: function(respuesta) {
                if (respuesta.success == true) {
                    let data = JSON.parse(respuesta.data);
                    let total = 0;
                    for (var i = 0; i < data.length; i++) {
                        total = ((data[i].cantidad * data[i].precio) *.16) + (data[i].cantidad * data[i].precio);
                        content += `<tr>
                                        <td scope="col">${i+1}</td>
                                        <td scope="col">${data[i].cabms}</td>
                                        <td scope="col">${data[i].nombre}</td>
                                        <td scope="col">${data[i].cantidad}</td>
                                        <td scope="col">$${new Intl.NumberFormat().format( total )}</td>
                                        <td scope="col"class="${data[i].estatusCss}">${data[i].estatus}</td>`;
                                    content +=`</tr>`;
                    }
                    content += `</tbody>
                                </table>`;
                }
            },
            error: function(respuesta) {
                Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
            }
         });
    return content;
}

function buscar(){
    let etapa = document.querySelector('#etapa');
    let productos = document.querySelector('#table_orden_filter');
    if(productos != null){
        productos.firstChild.lastChild.value = etapa.value;
        var clickEvent = document.createEvent('MouseEvents');
        clickEvent.initEvent ("mouseup", true, true);
        productos.firstChild.lastChild.dispatchEvent (clickEvent);
    }
}